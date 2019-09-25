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
//            $appid = env('WECHAT_APPID');
            $appid = 'wxdb1e7178bb7c4c75';
            $secret = env('WECHAT_APPSECRET');
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
}
