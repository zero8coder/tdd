<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index(Channel $channel)
    {
        if ($channel->exists) {
            $threads = $channel->threads()->latest();
        } else {
            $threads = Thread::latest();
        }
        if ($username = request('by')) {
            $user = User::where('name', $username)->firstOrFail();
            $threads->where('user_id', $user->id);
        }
        $threads = $threads->get();
        return view('threads.index', compact('threads'));
    }

    public function show($channelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'      => 'required',
            'body'       => 'required',
            'channel_id' => 'required|exists:channels,id'
        ], [
            'channel_id.required' => '频道 必选',
            'channel_id.exists' => '频道 不存在'
        ]);

        $thread = Thread::create([
            'user_id'    => auth()->id(),
            'channel_id' => request('channel_id'),
            'title'      => request('title'),
            'body'       => request('body'),
        ]);

        return redirect($thread->path());
    }

    public function create()
    {
        return view('threads.create');
    }

}
