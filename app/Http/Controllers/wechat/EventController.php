<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    //接受微信发过来的消息（用户互动）
    public function event()
    {
        //echo $_GET['echostr'];
        //$xml_string  = file_get_contents('php://http');//获取
        $re = file_put_contents('./1.text','222222222');
        dd($re);
    }
}
