<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Models\Channel;
use App\Models\Thread;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilters;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadsFilters $filters)
    {
        $threads = $this->getThreads($channel, $filters);
        if (request()->wantsJson()) {
            return $threads;
        }
        return view('threads.index', compact('threads'));
    }

    protected function getThreads(Channel $channel, ThreadsFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        return $threads->paginate(20);
    }

    public function show($channel, Thread $thread)
    {
        $thread->create_at_see;
        if (auth()->check()) {
            auth()->user()->read($thread);
        }
        return view('threads.show', [
            'thread'  => $thread,
        ]);
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('delete', $thread);
        $thread->delete();
        if (request()->wantsJson()) {
            return response([], 204);
        }
        return redirect('/threads');
    }

    public function store(Request $request, Spam $spam)
    {
        $this->validate($request, [
            'title'      => 'required',
            'body'       => ['required', new SpamFree],
            'channel_id' => 'required|exists:channels,id'
        ], [
            'channel_id.required' => '频道 必选',
            'channel_id.exists'   => '频道 不存在'
        ]);

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
        ]);

        return redirect($thread->path())
            ->with('flash','你的帖子已发布成功');
    }

    public function create()
    {
        return view('threads.create');
    }


}
