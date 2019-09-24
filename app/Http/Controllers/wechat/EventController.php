<?php

namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EventController extends Controller
{
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }
    //接受微信发过来的消息（用户互动）
    public function event()
    {
//        //echo $_GET['echostr'];
//        //$xml_string  = file_get_contents('php://http');//获取
//        $re = file_put_contents('./1.text','222222222');
//        dd($re);

        $xml_string = file_get_contents('php://input');//是个可以访问请求的原始数据的只读流
//        dd($xml_string);
        $wechat_log_path=storage_path('logs/wechat/').date('Y-m-d').'.log';
        file_put_contents($wechat_log_path,"--------------------------\n",FILE_APPEND);
        file_put_contents($wechat_log_path,$xml_string,FILE_APPEND);
        file_put_contents($wechat_log_path,"\n--------------------------\n\n",FILE_APPEND);
        $xml_obj=simplexml_load_string($xml_string,'SimpleXMLElement',LIBXML_NOCDATA);
//        dd($xml_obj);
        $xml_arr=(array)$xml_obj;
//        dd($xml_arr);
        \Log::Info(json_encode($xml_arr,JSON_UNESCAPED_UNICODE));
//        echo $_GET['echostr'];
        //dd($xml_arr);
        //业务逻辑
//        dd($xml_arr);
        /*if($xml_arr['MsgType']=='event'){
            if($xml_arr['Event']=='subscribe'){
                $share_code=explode('_',$xml_arr['EventKey'])[1];
                $user_openid=$xml_arr['FromUserName'];//粉丝openid
                //判断是否已经关注过
                $wechat_openid=DB::table('regist')->where(['openid'=>$user_openid])->first();
                if(empty($wechat_openid)){
                    DB::table('regist')->where(['user_id'=>$share_code])->increment('share_num',1);
                    DB::table('wechat_openid')->insert([
                        'openid'=>$user_openid
                    ]);

                }
            }else{
                //欢迎回来
                $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA[欢迎回来]]></Content></xml>';
                echo $xml_str;
            }
        }*/
        if($xml_arr['MsgType']=='event' && $xml_arr['Event']=='subscribe'){
            //关注
            //openid拿到用户基本信息
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN';
            $re = file_get_contents($url);
            $user_info = json_decode($re,1);
            $message='欢迎关注'.$user_info['nickname'].'同学，感谢您的关注';
            $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
            echo $xml_str;
        }

    }
}
