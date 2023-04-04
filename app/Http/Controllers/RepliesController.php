<?php

namespace App\Http\Controllers;

use App\Inspections\Spam;
use App\Models\Reply;
use App\Models\Thread;

class RepliesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'index']);
    }

    public function store($channelId, Thread $thread)
    {
        try {
            $this->validateReply();

            $reply = $thread->addReply([
                'body'    => request('body'),
                'user_id' => auth()->id()
            ]);
        } catch (\Exception $e) {
            return response('回复有问题', 422);
        }

        return $reply->load('owner');
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
        try {
            $this->validateReply();
            $reply->body = request('body');
            $reply->update();
        } catch (\Exception $e) {
            return response('回复保存走失了', 422);
        }

        return response()->json(['code' => 200, 'message' => '成功', 'data' => 1]);
    }

    public function index($channelId, Thread $thread)
    {
        return $thread->replies()->paginate(20);
    }

    protected function validateReply()
    {
        $this->validate(request(), ['body' => 'required']);
        resolve(Spam::class)->detect(request(('body')));
    }
}
