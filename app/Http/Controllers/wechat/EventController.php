<?php

namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EventController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
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
        //业务逻辑
        //签到逻辑
        if($xml_arr['MsgType']=='event' && $xml_arr['Event']=='CLICK'){
            if($xml_arr['EventKey']=='sign'){
                //签到
                $today = date("Y-m-d",time());//当天日期
                $last_day = date('Y-m-d',strtotime('-1 days'));//昨天日期
                $openid_info = DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->first();
                if(empty($openid_info)){
                    //没有数据，存入
                    DB::table("wechat_openid")->insert([
                        'openid'=>$xml_arr['FromUserName'],
                        'add_time'=>time()
                    ]);
                }
                $openid_info = DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->first();
                if($openid_info->sign_day == $today){
                    //已签到
                    $message='您已签到';
                    $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }else{
                    //未签到 积分
                    if($last_day == $openid_info->sign_day){
                        //连续签到 五天一轮
                        if($openid_info->sign_days >= 5){
                            DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
                                'sign_days'=>1,
                                'score'=>$openid_info->score + 5,
                                'sign_day'=>$today,
                            ]);
                        }else{
                            DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
                                'sign_days'=>$openid_info->sign_days + 1,
                                'score'=>$openid_info->score + 5 * ($openid_info->sign_days + 1),
                                'sign_day'=>$today,
                            ]);
                        }
                    }else{
                        //非连续签到
                        // 加积分 连续天数变一
                        DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->update([
                           'sign_days'=>1,
                            'score'=>$openid_info->score + 5,
                            'sign_day'=>$today,
                        ]);
                    }
                    $message='签到成功';
                    $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }
            }
            if($xml_arr['EventKey']=='score'){
                //查积分
                $openid_info = DB::table("wechat_openid")->where(['openid'=>$xml_arr['FromUserName']])->first();
                if(empty($openid_info)){
                    DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->insert([
                        'openid'=>$xml_arr['FromUserName'],
                        'add_time'=>time()
                    ]);
                    $message='积分：0';
                    $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }else{
                    $message='积分:'.$openid_info->score;
                    $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
                    echo $xml_str;
                }
            }
        }
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
        //dd($xml_arr);
        //关注逻辑
        if($xml_arr['MsgType']=='event' && $xml_arr['Event']=='subscribe'){
            //关注
            //openid拿到用户基本信息
            $url = 'https://api.weixin.qq.com/cgi-bin/user/info?access_token='.$this->tools->get_wechat_access_token().'&openid='.$xml_arr['FromUserName'].'&lang=zh_CN';
            $re = file_get_contents($url);
            $user_info = json_decode($re,1);
            //存入数据库
            $db_user = DB::table('wechat_openid')->where(['openid'=>$xml_arr['FromUserName']])->first();
            //dd($db_user);
            $time=date("Y-m-d",time());
            if(empty($db_user)){
                //没有数据，存入数据库
                DB::table('wechat_openid')->insert([
                   'openid'=>$xml_arr['FromUserName'],
                    'add_time'=>time(),
                    'sign_day'=>$time,
                ]);
            }
            $message='欢迎'.$user_info['nickname'].'同学，感谢您的关注';
            $xml_str='<xml><ToUserName><![CDATA['.$xml_arr['FromUserName'].']]></ToUserName><FromUserName><![CDATA['.$xml_arr['ToUserName'].']]></FromUserName><CreateTime>'.time().'</CreateTime><MsgType><![CDATA[text]]></MsgType><Content><![CDATA['.$message.']]></Content></xml>';
            echo $xml_str;
        }
    }
}
