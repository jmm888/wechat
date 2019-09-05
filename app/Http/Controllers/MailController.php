<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MailController extends Controller
{
   public function index()
   {
       $email = '15033887793@163.com';
       $this->sendMail($email);
   }
   public function sendMail($email){
    \Mail::send('mail' , ['name'=>$email] ,function($message)use($email){
    //设置主题
        $message->subject("欢迎注册滕浩有限公司");
    //设置接收方
        $message->to($email);
    });
}


}
