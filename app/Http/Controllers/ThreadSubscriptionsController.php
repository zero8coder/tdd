<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadSubscriptionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store($channelId,Thread $thread)
    {
        return $thread->subscribe();
    }

    public function destroy($channelId,Thread $thread)
    {
        return $thread->unsubscribe();
    }
}
