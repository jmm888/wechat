<?php
namespace App\Tools;

use Illuminate\Support\Facades\Redis;

class Tools
{
    public $redis;

    public function __construct()
    {
        $this->redis = new \Redis();
        $this->redis->connect('127.0.0.1', '6379');
    }

    public function curl_post($url,$data)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        curl_setopt($curl,CURLOPT_POSTFIELDS,$data);
        $data = curl_exec($curl);
        $errno = curl_errno($curl);  //错误码
        $err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }
    /*
     * 获取access_token
     * */
    public function get_wechat_access_token()
    {
        //加入缓存
        $access_token_key='wechat_access_token';
        // Redis::del($access_token_key);die;
        $info = $this->redis->get($access_token_key);
        //dd($info);
        if($info){
            return $info;
        }else{
            //$appid = env('WECHAT_APPID');
            $appid = 'wxdb1e7178bb7c4c75';
            $secret ='77a62cd6410c7962b7bdd3cf3c6340eb';
            //$secret = env('WECHAT_APPSECRET');
            $result = file_get_contents("https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret");
            //dd($result);
            // 转化数组   1==true
            $re = json_decode($result,1);
            //dd($re);
            $this->redis->set($access_token_key,7200,$re['access_token']);//加入缓存
            return  $re['access_token'];
        }
    }
    /*
     * 获取jsapi_ticket
     * */
    public function get_wechat_jsapi_ticket()
    {
        //加入缓存
        $access_api_key='wechat_jsapi_ticket';
        // Redis::del($access_token_key);die;
        $info = $this->redis->get($access_api_key);
        //dd($info);
        if($info){
            return $info;
        }else{
            $appid = env('WECHAT_APPID');
            $secret = env('WECHAT_APPSECRET');
            $result = file_get_contents('https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token='.$this->get_wechat_access_token().'&type=jsapi');
            //dd($result);
            // 转化数组   1==true
            $re = json_decode($result,1);
            $this->redis->set($access_api_key,7200,$re['ticket']);//加入缓存
            return  $re['ticket'];
        }
    }

    /**
     * 网页授权获取用户openid
     * @return [type] [description]
     */
    public static function getOpenid()
    {
        //echo 1;die;
        //先去session里取openid
        $openid = session('openid');
       // var_dump($openid);die;
        if(!empty($openid)){
            return $openid;
        }
        //微信授权成功后 跳转咱们配置的地址 （回调地址）带一个code参数
        $code = request()->input('code');
        if(empty($code)){
            //没有授权 跳转到微信服务器进行授权
            $host = $_SERVER['HTTP_HOST'];  //域名
            $uri = $_SERVER['REQUEST_URI']; //路由参数
            $redirect_uri = urlencode("http://".$host.$uri);  // ?code=xx
            $url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".env('WECHAT_APPID')."&redirect_uri={$redirect_uri}&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
            header("location:".$url);die;
        }else{
            //通过code换取网页授权access_token
            $url =  "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".env('WECHAT_APPID')."&secret=".env('WECHAT_APPSECRET')."&code={$code}&grant_type=authorization_code";
            $data = file_get_contents($url);
            $data = json_decode($data,true);
            $openid = $data['openid'];
            //获取到openid之后  存储到session当中
            session(['openid'=>$openid]);
            return $openid;
            //如果是非静默授权 再通过openid  access_token获取用户信息
        }
    }
}
