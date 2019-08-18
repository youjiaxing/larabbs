<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class EnsureEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /* @var \App\Models\User $user */
        if ($request->user() &&
            $request->user() instanceof MustVerifyEmail &&
            !$request->user()->hasVerifiedEmail() &&
            !$request->is('logout', 'email/*')
        ) {
            return $request->expectsJson() ?
                abort(403, '邮箱未认证') :
                redirect()->route('verification.notice');
        }
        return $next($request);
    }
}
