<?php

namespace App\Model;
class Code
{
/*
 * 封装curl_post curl_get 方法
 * */
    public function curl_get($url)
    {
        //初始化
        $ch = curl_init();
        //设置选项，包括URL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        //执行并获取HTML文档内容
        $output = curl_exec($ch);
        //释放curl句柄
        curl_close($ch);
    }
    public function curl_post($url,$data)
    {
//        //初始化
//////        $ch = curl_init();
//////        //设置选项，包括URL
//////        curl_setopt($ch, CURLOPT_URL, $url);
//////        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//////        // post数据
//////        curl_setopt($ch, CURLOPT_POST, 1);
//////        // post的变量
//////        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
//////        //执行并获取HTML文档内容
//////        $output = curl_exec($ch);
//////        //释放curl句柄
//////        curl_close($ch);
//////        return;
///
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
}
