<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LoginController extends Controller
{
    public function index()
    {
        return view('index/login');
    }
    public function reg()
    {
        return view('index/reg');
        //dump(session('email'));
    }
    public function email()
    {
        $useremail = Request()->useremail;
        //dd($useremail);
        $this->send($useremail);
    }
    public function send($useremail){
        $rand = rand(100000,999999);
        \Mail::raw('您的验证码是'.$rand ,function($message)use($useremail)
        {
        //设置主题
            $message->subject("欢迎注册滕浩有限公司");
        //设置接收方
            $message->to($useremail);
        });
        session(['email'=>$rand]);
    }
    public function reg_do(){
        $data =Request()->except(['_token']);
       if($data['mil'] != session('email')){
           echo "<script>alert('验证码错误');history.go(-1);</script>";
       }
       if($data['userpwds'] != $data['userpwd']){
            echo "<script>alert('密码和确认密码 必须一致');history.go(-1);</script>";
       }
       //dd($data);
       unset($data['mil']);
       unset($data['userpwds']);
       //dd($data);
       $res =DB::table('regist')->insert($data);
      if($res){
          return redirect('index/login');
      }
    }
    //登录页面
    public function login_do()
    {
        $data = Request()->except(['_token']);
        $res = DB::table('regist')->where('useremail',$data['useremail'])->first();
        $res = json_decode(json_encode($res), true);
        if(!$res){
            echo "<script>alert('邮箱或手机号不存在');history.go(-1);</script>";die;          
        }
        if($data['userpwd'] != $res['userpwd'])
        {
            echo "<script>alert('密码不正确');history.go(-1);</script>";die;         
        }
        //存session
        session(['userIndex'=>$res]);
        return redirect('/');
    }
}
