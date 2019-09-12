<?php

namespace App\Http\Controllers\Tags;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Tools\Tools;

class TagController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    /*
     * 推送标签群发消息
     * */
    public function push_tag_message()
    {
        return view('tag.pushtagmsg',['tagid'=>Request()->all()['tagid']]);
    }
    /*
     * 执行推送标签群发消息
     * */
    public function do_push_tag_message()
    {
        $req = Request()->all();
        $url="https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token=".$this->tools->get_wechat_access_token();
        $data = [
            'filter'=>[
                'is_to_all'=>false,
                'tag_id'=>$req['tagid'],
            ],
            'text'=>[
                'content'=>$req['message'],
            ],
            'msgtype'=>'text',
        ];
        //dd(json_encode($data,JSON_UNESCAPED_UNICODE));
        $re = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
     // dd($re);
        $result = json_decode($re,1);
        dd($result);
    }
    /*
     * 用户下的标签列表
     * */
    public function uses_tag_list()
    {
        $req = Request()->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/getidlist?access_token='.$this->tools->get_wechat_access_token();
        $data =[
          'openid'=>$req['openid']
        ];
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        $urls="https://api.weixin.qq.com/cgi-bin/tags/get?access_token=".$this->tools->get_wechat_access_token();
        $re=file_get_contents($urls);
        $re=json_decode($re,1);
       // dd($re);
        $tag_arr=[];
        foreach($re['tags'] as $v){
            $tag_arr[$v['id']] = $v['name'];
        }
//        dd($tag_arr);
        foreach ($result['tagid_list'] as $v){
            echo $v=$tag_arr[$v];
        }
    }

    /*
     * 为用户打标签
     * */
    public function tag_openid()
    {
        $req = Request()->all();
        //dd($req);
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'openid_list'=>$req['openid_list'],
            'tagid'=>$req['tagid']
        ];
        //dd($data);
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        dd($result);
    }
    //公众 标签管理列表
    public function tag_list()
    {
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/get?access_token='.$this->tools->get_wechat_access_token();
        $re = file_get_contents($url);
        $result = json_decode($re,1);
        return view('tag.tag_list',['info'=>$result['tags']]);
    }
    //标签添加
    public function tag_add()
    {
        return view('tag.tag_add');
    }
    //标签 添加执行页面
    public function tag_add_do()
    {
        $req = Request()->all();
        $data = [
            'tag'=>[
                'name'=>$req['tag_name']
            ]
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->tools->get_wechat_access_token();
        $re = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $result = json_decode($re);
        echo 'ok';
    }
    //粉丝 列表
    public function tag_openid_list()
    {
        $req = Request()->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/user/tag/get?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'tagid'=>$req['tagid'],
            'next_openid'=>''
        ];
        $re = $this->tools->curl_post($url,json_encode($data));
        $result = json_decode($re,1);
        dd($result);
    }
}
