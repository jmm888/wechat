<?php

namespace App\Http\Controllers\index;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class LoginController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    public function index()
    {
        dd();
        return view('index/login');
    }
    /*
     * 八月份月考题B卷6题
     * */
    public function push(){
        $user_url = 'https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=';
        $openid_info = file_get_contents($user_url);
        $user_result = json_decode($openid_info,1);
        foreach($user_result['data']['openid'] as $v){
         $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
        $data =[
            'touser'=>$v,
            'template_id'=>'PNYzLGRGwnH0E9FwiAsh4MhUqR1qv8E-3znwRv7dXzM',
            'data'=>[],
            ];
            $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        }
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
