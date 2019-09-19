<?php

namespace App\Http\Controllers\wechat;
use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
class AgentController extends Controller
{
    //    封装公共方法调用redis
    public $tools;
    public $client;
    public function __construct(Tools $tools,Client $client)
    {
        $this->tools = $tools;
        $this->client = $client;
    }

    //用户列表
    public function agent_list()
    {
        $user_info = DB::table('regist')->get();
        return view('agent.userlist',['info'=>$user_info]);
    }
    //生成二维码
    public function create_qrcode(Request $request)
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'expire_seconds'=>30 * 24 * 3600,
            'action_name'=>'QR_SCENE',
            'action_info'=>[
                'scene'=>[
                    'scene_id'=>$request->all()['uid']
                ]
            ]
        ];
//        dd($data);
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        $qrcode_info = file_get_contents('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket='.UrlEncode($result['ticket']));
        $path ='/wechat/qrcode/'.time().rand(1000,9999).'.jpg';
        $aa = Storage::put($path,$qrcode_info);
        DB::table('regist')->where(['user_id'=>$request->all()['uid']])->update([
            'qrcode_url'=>'/storage'.$path,
        ]);
//        dd($path);

        return redirect('wechat/agent_list');
    }
}
