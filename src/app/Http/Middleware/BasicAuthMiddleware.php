<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class BasicAuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
    // 入力されたユーザー名とパスワードを取得
    $username = $request->getUser();
    $password = $request->getPassword();

    if ($username == env('BASIC_AUTH_USERNAME') && $password == env('BASIC_AUTH_PASSWORD')) {
        return $next($request);
    }

    return response('認証情報が必要です', 401, ['WWW-Authenticate' => 'Basic']);
    }
}
