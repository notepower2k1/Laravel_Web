<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class isBanned
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
        if(Auth::check()){
            if(Auth::user()->status == '1') //1 - Admin & 0 - User
            {
                return $next($request);

            }
            else    
            {
                Auth::logout();
                return redirect('login')->with('fail', 'Tài khoản của bạn đã bị khóa. Liên hệ quản trị viên để biết thêm chi tiết');
            }
        }    
        else{
            return $next($request);
        }
      
    }
}
