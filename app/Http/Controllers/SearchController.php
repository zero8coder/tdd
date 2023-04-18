<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use App\Models\Trending;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function show(Trending $trending)
    {
        $search = request('q');
        $threads = Thread::search($search)->paginate(20);
        if (request()->expectsJson()) {
            return $threads;
        }
        return view('threads.index', [
           'threads' => $threads,
           'trending' => $trending->get()
        ]);
    }
}
