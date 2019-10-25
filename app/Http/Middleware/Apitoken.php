<?php

namespace App\Http\Middleware;

use App\Model\Login;
use Closure;

class Apitoken
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
        $token = $request->input('token');
        //验证如果token不存在
        if(empty($token))
        {
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //验证token是否正确
        $userData = Login::where(['token'=>$token])->first();
        if(!$userData)
        {
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //验证token是否过期
        if(time() > $userData['expire_time'])
        {
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //延长token有效期
        $userData->expire_time = time()+7200;
        $userData->save();
        $mid_params = ['userData'=>$userData];
        $request->attributes->add($mid_params);//添加参数
        return $next($request);
    }
}
