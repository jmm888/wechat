<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Login;
class UserController extends Controller
{
    /**
     * 用户登录接口
     */
    public function login(Request $request)
    {
        //接受用户名，密码
        $username = $request->input('username');
        $userpwd = $request->input('userpwd');
        //查询数据库，进行校验
        $res = Login::where(['user_name'=>$username,'user_pwd'=>$userpwd])->first();
        //验证
        if(empty($res))
        {
             echo "用户名或密码错误";die;
        }
        //用户登录成功
        //生成token令牌
        $token = md5('login_id'.time());//生成一个不重复的token令牌
        //修改数据库
        $res->token = $token;
        $res->expire_time = time()+7200;//过期时间
        $res->save();
        //把token返回给客户端
        return json_encode(['ret'=>1,'msg'=>'查询成功','token'=>$token]);
    }
    /*
     * 接受token进行验证
     * */
    public function getUser(Request $request)
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
        //具体业务逻辑
    }
}
