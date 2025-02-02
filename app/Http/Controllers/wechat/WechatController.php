<?php
namespace App\Http\Controllers\wechat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use DB;
use App\Tools\Tools;
use GuzzleHttp\Client;
class WechatController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }
    /**
     * 调用频次清0
     */
    public function  clear_api(){
        $url = 'https://api.weixin.qq.com/cgi-bin/clear_quota?access_token='.$this->tools->get_wechat_access_token();
        $data = ['appid'=>env('WECHAT_APPID')];
        $this->tools->curl_post($url,json_encode($data));
    }
    /*
     * JSSDK使用步骤
     * */
    public function location()
    {
        $url = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        $jsapi_ticket= $this->tools->get_wechat_jsapi_ticket();
        //dd($req);
        $timestamp=time();
        $nonceStr =rand(1000,9999).'suibian';
       $sign_str='jsapi_ticket='.$jsapi_ticket.'&nonceStr='.$nonceStr.'&$timestamp='.$timestamp.'&url='.$url;
       $signature =sha1($sign_str);
       //echo $signature;
        return view('wechat/location',['nonceStr'=>$nonceStr,'timestamp'=>$timestamp,'signature'=>$signature]);
    }

    /*
    *发送模板消息
    * */
    public function push_template_message()
    {
        $openid='oYE-HwD2Xq3rj-G3ylLs9fUZyd2U';
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
        $data=[
            'touser'=>$openid,
            'template_id'=>'ZLQGvOW6z9Y7QfneYFKQOmKhQbFi8OiXnNVbNDN0EpI',
            'url'=>'http://www.jmm_wxlaravel.com',
            'data'=>[
                'first'=>[
                   'value'=>'first',
                   'color'=>''
                ],
                'keyword1'=>[
                    'value'=>'亲爱的范含笑小姐',
                    'color'=>''
                ],
                'remake'=>[
                'value'=>'欢迎再来',
                'color'=>''
                ]
            ]
        ];
        $re = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result = json_decode($re,1);
        dd($result);
    }

    //用户信息页
    public function get_user_list(Request $request)
    {
//        //使用Easywechat获取用户列表
//        $app = app('wechat.official_account');
//        dd($app->user->list($nextOpenId = null));  // $nextOpenId 可选
//        dd();
        $req = $request->all();
        //dd($req);
        $url = "https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->get_wechat_access_token()."&next_openid=";
        $result = file_get_contents($url);
        $re = json_decode($result,1);
        //dd($re);
        $last_info = [];
        foreach($re['data']['openid'] as $k=>$v){
            $user_info = file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$v.'&lang=zh_CN');
            $user = json_decode($user_info,1);
            // dd($user);
            $last_info[$k]['nickname'] = $user['nickname'];
            $last_info[$k]['openid'] = $v;
        }
        return view('wechat.userList',['info'=>$last_info,'tagid'=>isset($req['tagid'])?$req['tagid']:'']);
  }
    public function get_access_token()
    {
        return $this->tools->get_wechat_access_token();
    }

    //详情页
    public function add_msg($openid)
        {
            $user_info=file_get_contents('https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$openid.'&lang=zh_CN');
            $user_info = json_decode($user_info,1);
             //dd($user_info);
            return view('wechat/user_info',['info'=>$user_info]);
        }


        //9.3登录
        public function login()
        {
            return view('wechat/login');
        }
        public function wechat_login()
        {
            $redirect_uri = 'http://www.jmm_wxlaravel.com/wechat/code';
            $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid='.env('WECHAT_APPID').'&redirect_uri='.urlencode($redirect_uri).'&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect';
            header('Location:'.$url);
        }

    public function code(Request $request)
    {
        $req = $request->all();
        //dd($req);
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid='.env('WECHAT_APPID').'&secret='.env('WECHAT_APPSECRET').'&code='.$req['code'].'&grant_type=authorization_code');
        $re = json_decode($result,1);
        //dd($re);
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token='.$re['access_token'].'&openid='.env('WECHAT_APPID').'&lang=zh_CN');
        $wechat_user_info = json_decode($user_info,1);
         //dd($wechat_user_info);
        //取出openid
         $openid = $wechat_user_info['openid'];
        //  dd($openid);
        $user_id = DB::table('regist')->where(['openid'=>$openid])->first();
        //dd($user_id);
        if(!empty($user_id)){
            //登录
            $wechat_session = $request->session()->put('user_id',$user_id->user_id);
            echo 'ok';
        }else{
            //为空注册登录
          $user_id = DB::table('regist')->insertGetid([
            'useremail'=>$wechat_user_info['nickname'],
                'userpwd'=>"",
                'openid'=>$openid
          ]);
          //dump($user_id);
          $user_result = DB::table('wetchat_user')->insert([
                'user_id'=>$user_id,
                'openid'=>$openid,
          ]);
        //   dump($user_result);
        $wechat_session = $request->session()->put('user_id',$user_id->user_id);
            echo 'ok';
        }
    }
    /*
    * 获取access_token
    * */
        public function get_wechat_access_token()
    {
        //加入缓存
        $access_token_key='wechat_access_token';
        // Redis::del($access_token_key);die;
        $info = Redis::get($access_token_key);
        if($info){
            return $info;
        }else{
            $appid = env('WECHAT_APPID');
            $secret = env('WECHAT_APPSECRET');
            $result = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret");
            // 转化数组   1==true
            $re = json_decode($result,1);
            Redis::set($access_token_key,7200,$re['access_token']);//加入缓存
            return  $re['access_token'];
        }
    }
    }

