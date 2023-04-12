<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RedirectIfEmailNotConfirmed
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->user()->confirmed) { // 如果用户未认证，则重定向
            return redirect('/threads')->with('flash', '你先确认邮箱');
        }

        return $next($request);
    }
}
