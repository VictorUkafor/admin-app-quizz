<?php

namespace App\Http\Middleware;

use Closure, Auth;

class AdminCheck
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
        if (Auth::check()) {
            $user = Auth::user();

            if (($user->user_type !== 'admin')){

                Auth::logout();
                return redirect()->route('login');
            }

        }else{
            return redirect()->route('login');
        }
        return $next($request);
    }
}
