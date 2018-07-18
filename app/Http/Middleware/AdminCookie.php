<?php

namespace App\Http\Middleware;

use Closure;

class AdminCookie
{
    /**
     * Handle an incoming request.
     *
     * 此处为了解决 同浏览器 同域名 的情况下，
     * 前后台同时登陆后，点击任意一个退出，
     * 前后台都会退出的情况。
     *
     * 解决办法：进入后台时，强制更换后台 cookie name
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        config([
            'session.cookie' => 'BlogAdminSession'
        ]);

        return $next($request);
    }
}
