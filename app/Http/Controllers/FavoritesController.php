<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use Illuminate\Support\Facades\DB;

class FavoritesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Reply $reply)
    {
        $reply->favorite();
        return response()->json(['code' => 200]);
    }

    public function destroy(Reply $reply)
    {
        $reply->unfavorite();
        return response()->json(['code' => 200]);
    }
}
