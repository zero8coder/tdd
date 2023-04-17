<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Models\Channel;
use App\Models\Thread;
use App\Models\Trending;
use App\Rules\SpamFree;
use Illuminate\Http\Request;
use App\Filters\ThreadsFilters;
use Illuminate\Support\Str;
use Zttp\Zttp;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel, ThreadsFilters $filters, Trending $trending)
    {
        $threads = $this->getThreads($channel, $filters);
        if (request()->wantsJson()) {
            return $threads;
        }

        return view('threads.index',
            [
                'threads'  => $threads,
                'trending' => $trending->get()
            ]
        );
    }

    protected function getThreads(Channel $channel, ThreadsFilters $filters)
    {
        $threads = Thread::latest()->filter($filters);

        if ($channel->exists) {
            $threads = $threads->where('channel_id', $channel->id);
        }
        return $threads->paginate(20);
    }

    public function show($channel, Thread $thread, Trending $trending)
    {
        $thread->create_at_see;
        if (auth()->check()) {
            auth()->user()->read($thread);
        }
        // 记录热门程度
        $trending->push($thread);
        // 记录浏览次数
        $thread->increment('visits');
        return view('threads.show', [
            'thread' => $thread,
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

//        $response = Zttp::asFormParams()->post('https://www.google.com/recaptcha/api/siteverify',[
//            'secret' => config('services.recaptcha.secret'),
//            'response' => $request->input('g-recaptcha-response'),
//            'remoteip' => $_SERVER['REMOTE_ADDR']
//        ]);
//
//        if (! $response->json()['success']) {
//            throw new \Exception('Recaptcha 失败');
//        }


        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
        ]);

        if (request()->wantsJson()) {
            return response($thread,201);
        }


        return redirect($thread->path())
            ->with('flash', '你的帖子已发布成功');
    }

    public function create()
    {
        return view('threads.create');
    }

    public function update($channelId,Thread $thread)
    {
        if (request()->has('locked')) {
            if (! auth()->user()->isAdmin()) {
                return response('', 403);
            }

        }
    }

}
