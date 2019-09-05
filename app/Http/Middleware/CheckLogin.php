<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        //执行动作 模拟session登录
        $user = session('user');
       // dd($user);
        if(!$user){
            return redirect('/login');
        }
        return $next($request);
    }
}
