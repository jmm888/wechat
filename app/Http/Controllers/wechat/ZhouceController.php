<?php

namespace App\Http\Controllers\wechat;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Tools\Tools;
use Illuminate\Support\Facades\Redis;

class ZhouceController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }
   public function login()
    {
        return view('zhouce/login');
    }
    public function wechat_login(){
       $redirect_uri = 'http://www.jmm_wxlaravel.com/zhouce/code';
        //用户同意授权，获取code
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:'.$url);
   }
   public function code(Request $request)
   {
       //接受全部
    $req =  $request->all();
    //通过code换取网页授权access_token
    $result=file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
    $res = json_decode($result,1);
    //拉取用户信息(需scope为 snsapi_userinfo)
    $res_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$res['access_token'].'&openid='.env('WECHAT_APPID').'&lang=zh_CN');
    $zhouce_res_info = json_decode($res_info,1);
    //dd($zhouce_res_info);
    //取出openID
   $openid = $zhouce_res_info['openid'];
   //dd($openid);
    $user_id = DB::table('regist')->where(['openid'=>$openid])->first();
    //如不为空则登录
    if(!empty($user_id)){
        $zhouce_session = $request->session()->put('user_id',$user_id->user_id);
        echo'成功';
    }else{
      //为空注册登录
        $user_id = DB::table('regist')->insertGetiD([
            'useremail'=>$zhouce_res_info['nickname'],
            'userpwd'=>'',
            'openid'=>$openid,
        ]);
        $result = DB::table('wechat_user')->insert([
            'user_id'=>$user_id,
            'openid'=>$openid,
        ]);
        $zhouce_session = $request->session()->put('user_id',$user_id->user_id);
        echo'ok';
    }
   }
    //微信 留言主页
    public function user_list()
    {
        //dd(111);
        $url = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/get?access_token='.$this->tools->get_wechat_access_token().'&next_openid=');
        $re = json_decode($url,1);
        $lase_info = [];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info=file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->get_wechat_access_token()."&openid=".$v."&lang=zh_CN");
            $user = json_decode($user_info,1);
            //dd($user);
            $lase_info[$k]['nickname'] = $user['nickname'];
            $lase_info[$k]['openid'] = $v;
        }
        $lase_info = json_encode($lase_info);
        $lase_info = json_decode($lase_info);
        return view('zhouce/user_list',['info'=>$lase_info]);
    }
    //执行 留言列表
    public function message(Request $request)
    {
        $req = $request->all()['openid'];
        //dd($req);
        return view('zhouce.message',['openid'=>$req]);
    }
    //添加留言执行页面
    public function message_do(Request $request)
    {
        $req = $request->all();
        dd($req);
    }
}
