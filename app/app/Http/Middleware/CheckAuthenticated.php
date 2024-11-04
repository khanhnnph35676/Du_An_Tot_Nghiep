<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAuthenticated
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
        // Kiểm tra nếu người dùng chưa đăng nhập
        if (!Auth::check() && Auth::id()  !=  1 ) {
            return redirect()->route('loginAdmin');
        }
        return $next($request);
    }
}
