<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;
class Api
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
        //解决跨域问题
        header("Access-Control-Allow-Origin:*");
        header('Access-Control-Allow-Methods:POST');
        header('Access-Control-Allow-Headers:x-requested-with, content-type');


        //根据IP做防刷
        $ip = $_SERVER['REMOTE_ADDR'];//获取ip
//        dd($ip);
        $cache_name ="pass_time".$ip; //记录当前ip 一分钟访问了多少次 缓存里
        $num = Cache::get($cache_name); //上一次缓存了多少次
        if(!$num)
        {
            $num = 0;
        }
        if($num >10)
        {
            //ip记录到文件 服务器端配置屏蔽某个ip
            echo json_encode([
                'ret'=>201,
                'msg'=>'访问接口过于频繁,请稍后',
            ]);die;
        }
        $num += 1;
        Cache::put($cache_name,$num,60);
        return $next($request);
    }
}
