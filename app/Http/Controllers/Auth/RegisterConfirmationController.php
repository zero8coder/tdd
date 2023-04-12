<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;

class RegisterConfirmationController extends Controller
{
    public function index()
    {
        $user = User::where('confirmation_token', request('token'))
            ->first();

        if (!$user) {
            return redirect(route('threads'))
                ->with('flash', 'Unknown token.');
        }

        $user->confirm();

        return redirect('/threads')
            ->with('flash', '你的账号认证成功');
    }
}
