<?php

namespace App\Http\Controllers\wechat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use GuzzleHttp\Client;
use DB;
class UploadController extends Controller
{
   public function upload()
   {
       return view('wechat.upload');
   }


    /*
     * 微信 素材管理页面
     * */
    public function wechat_source(Request $request,Client $client)
    {

    }
   public function guzzle_upload($url,$path,$client,$is_video=0,$title='',$desc='')
   {
           $multipart=[
               [
                   'name'     => 'media',
                   'contents' => fopen($path, 'r')
               ]
       ];
    if($is_video==1){
        $multipart[]=[
            'name'=>'description',
            'contents'=>json_encode(['title'=>$title,'introduction'=>$desc],JSON_UNESCAPED_UNICODE)
        ];
    }
       $result = $client->request('POST',$url,[
           'multipart' => $multipart
       ]);
       return $result->getBody();
   }
   public function upload_do(Request $request,Client $client)
   {

       //接收选择文件上传的类型
    $type = $request->all()['type'];
    //dd($type);
    $source_type='';
    switch($type){
        case 1: $source_type = 'image'; break;
        case 2: $source_type = 'voice'; break;
        case 3: $source_type = 'video'; break;
        case 4: $source_type = 'thumb'; break;
        default;
    }
       $name='images';
       if(!empty(request()->hasFile($name)) && request()->file($name)->isValid()){
           //大小 资源 类型限制
           $size=$request->file($name)->getClientSize()/1024/1024; //获取图片大小
           $ext=$request->file($name)->getClientOriginalExtension();//文件类型
           if($source_type=='image'){
               if(!in_array($ext,['jpg','png','jpeg','gif'])){
                   dd('图片类型不支持');
               }
               if($size>2){
                   dd('文件过大');
               }
           }elseif($source_type=='voice'){}
           $file_name=time().rand(10000,99999).'.'.$ext;
           $path=request()->file($name)->storeAs('wechat/'.$source_type,$file_name);
           $storage_path = '/storage/'.$path;
           $path=realpath('./storage/'.$path);
           $url = 'https://api.weixin.qq.com/cgi-bin/material/add_material?access_token='.$this->get_wechat_access_token().'&type='.$source_type;
//           $url="https://api.weixin.qq.com/cgi-bin/media/upload?access_token=".$this->get_wechat_access_token()."&type=TYPE";
//           dd($url);
//           $result=$this->curl_upload($url,$path,$client);
           if($source_type=='video'){
               $title = '标题';//视频 标题
               $desc = '描述';//视频描述
               $result = $this->guzzle_upload($url,$path,$client,1,$title,$desc);
           }else{
               $result = $this->guzzle_upload($url,$path,$client);
           }
           $re = json_decode($result,1);
//         $res =  $this->client_up($url,$path,$client);
         dd($re);
           //插入数据库
           DB::table('wechat_source')->insert([
               'media_id'=>$re['media_id'],
               'type'=>$type,
               'path'=>$storage_path,
               'add_time'=>time()
           ]);
        echo'ok';
       }
   }

    // 储存redis
    public function get_wechat_access_token()
    {
        // // 实例化redis
        // $redis= new \Redis();
        // // 链接redis
        // $redis->connect('127.0.0.1','6379');
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
            Redis::set($access_token_key,$re['access_token']);//加入缓存
            Redis::setTimeout($access_token_key,7200);//加入缓存

            return  $re['access_token'];
        }
    }

    public function curl_upload($url,$path)
    {
        $curl = curl_init($url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($curl,CURLOPT_POST,true);  //发送post
        $form_data = [
            'meida' => new \CURLFile($path)
        ];
        curl_setopt($curl,CURLOPT_POSTFIELDS,$form_data);
        $data = curl_exec($curl);
        //$errno = curl_errno($curl);  //错误码
        //$err_msg = curl_error($curl); //错误信息
        curl_close($curl);
        return $data;
    }

}
