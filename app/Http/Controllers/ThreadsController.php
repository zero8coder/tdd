<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Support\Facades\Log;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }

    public function index()
    {
        $threads = Thread::latest()->get();
        return view('threads.index', compact('threads'));
    }

    public function show($channelId, Thread $thread)
    {
        return view('threads.show', compact('thread'));
    }

    public function store()
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => request('channel_id'),
            'title' => request('title'),
            'body' => request('body'),
        ]);

        return redirect($thread->path());
    }

    public function create()
    {
        return view('threads.create');
    }

}
