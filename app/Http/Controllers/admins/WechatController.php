<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Wechat;
use Illuminate\Support\Facades\Cache;
class WechatController extends Controller
{
    //注册页面
    public function regist()
    {
        return view('wechat/regist');
    }
    //注册执行页面
    public function regist_do(Request $request)
    {
        $data  = $request->input();
        //生成一个APPID
        $appid = "php"."1902"."1001";
        //生成一个appsecret32位
        $appsecret = md5(time().rand(1000,9999));
        //注册时生成APPID ，判断有没有APPID
        $res = Wechat::orderBy('user_id','desc')->limit(1)->first('appid')->toArray();
        if(empty($res['appid']))
        {
            //入库
            Wechat::create([
                'user_name'=>$data['username'],
                'user_pwd'=>$data['pwd'],
                'appid'=>$appid,
                'secret'=>$appsecret
            ]);
        }else{
            //appid加一入库
            Wechat::create([
                'user_name'=>$data['username'],
                'user_pwd'=>$data['pwd'],
                'appid'=>$res['appid']+1,
                'secret'=>$appsecret
            ]);
        }
        return redirect('api/login');
    }
    //登录页面
    public function login()
    {
        return view('wechat/wechat_login');
    }
    //登录执行页面
    public function login_do(Request $request)
    {
        //接收数据
        $username = $request->input('username');
        $pwd = $request->input('pwd');
        $key = "wechat_user";
        //判断提交过来的 数据是否和数据库一致
        $res = Wechat::where(['user_name'=>$username,'user_pwd'=>$pwd])->first();
        if(empty($res))
        {
            echo "<script>alert('账号或密码错误,请重新输入');history.go(-1);</script>";

        }else{
            //储存Cache
            Cache::set('wechat_user',$res);
            return redirect("api/wechat");
        }
    }
    //域名首页
    public function wechat()
    {
        //取出Cache  发送APPID 和secret
        $res = Cache::get("wechat_user")->toArray();
        //客户端域名 $_SERVER  判断客户端域名是否和数据库一致
        $Clientname = $_SERVER['HTTP_HOST'];

        //生成一个不重复的 Token

        return view('wechat/wechat_url',['data'=>$res]);
    }
    public function wechat_do(Request $request)
    {
        $api_url = $request->input('api_url');
        $user_id = $request->input('user_id');
        if(empty($api_url))
        {
            echo "<script>alert('域名不能为空,请重新输入');history.go(-1);</script>";
        }else{
            $result = Wechat::where(['user_id'=>$user_id])->update(['api_url'=>$api_url]);
        }

    }
}
