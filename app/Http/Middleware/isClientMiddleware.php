<?php

namespace App\Http\Middleware;

use App\Models\Status;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;

class isClientMiddleware
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
        if (auth('web')->check() && auth('web')->user()->role_id == User::ROLE_CLIENT && auth('web')->user()->status_id == Status::ACTIVE){
            return $next($request);
        }
        /*Logout*/
        auth('web')->logout();
        return redirect()->route('login');
    }
}
