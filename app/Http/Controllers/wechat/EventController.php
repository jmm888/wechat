<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EventController extends Controller
{
    //接受微信发过来的消息（用户互动）
    public function event()
    {
        //echo 111;
        echo $_GET['echostr'];
    }
}
