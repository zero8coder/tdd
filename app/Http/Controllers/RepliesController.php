<?php

namespace App\Http\Controllers;

use App\Events\ThreadReceivedNewReply;
use App\Http\Requests\CreatePostRequest;
use App\Models\Reply;
use App\Models\Thread;
use App\Models\User;
use App\Notifications\YouWereMentioned;
use App\Rules\SpamFree;
use Illuminate\Support\Facades\Gate;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function store($channelId, Thread $thread, CreatePostRequest $request)
    {
        return $thread->addReply([
            'body'    => request('body'),
            'user_id' => auth()->id()
        ])->load('owner');

    }

    public function destroy(Reply $reply)
    {
        $this->authorize('delete', $reply);
        $reply->delete();

        return response()->json(['code' => 200, 'message' => '成功', 'data' => 1]);
    }

    public function update(Reply $reply)
    {
        $this->authorize('update', $reply);
        $this->validate(request(), ['body' => ['required', new SpamFree]]);
        $reply->update(['body' => request('body')]);
        return response()->json(['code' => 200, 'message' => '成功', 'data' => 1]);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

}
