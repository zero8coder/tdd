<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Spam;
use App\Models\Thread;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function store($channelId, Thread $thread, Spam $spam)
    {
        $this->validate(request(), ['body' => 'required']);


        $spam->detect(request(('body')));

        $reply =  $thread->addReply([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);
        return $reply->load('owner');
    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();

        return response()->json(['code' => 200, 'message' => '成功', 'data'=>1]);
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $reply->body = request('body');
        $reply->update();
        return response()->json(['code' => 200, 'message' => '成功', 'data'=>1]);

    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }
}
