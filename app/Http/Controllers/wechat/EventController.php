<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class EventController extends Controller
{
    //接受微信发过来的消息（用户互动）
    public function event()
    {
//        //echo $_GET['echostr'];
//        //$xml_string  = file_get_contents('php://http');//获取
//        $re = file_put_contents('./1.text','222222222');
//        dd($re);

        $xml_string = file_get_contents('php://input');//是个可以访问请求的原始数据的只读流
        //dd($xml_string);
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

    }
}
