<?php

namespace App\Http\Controllers\wechat;

use App\Tools\Tools;
use http\Header;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;

class CrontController extends Controller
{
    public $tools;

    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }

    public function cront_login()
    {
        return view('cront/cront_login');
    }

    public function cront_login_do()
    {
        $redirect_url = 'http://www.jmm_wxlaravel.com/wechat/cront_code';
        $url = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=' . env('WECHAT_APPID') . '&redirect_uri=' . urlencode($redirect_url) . '&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect';
        header('Location:' . $url);
    }

    public function cront_code(Request $request)
    {
        $req = $request->all();
        //通过授权码 获取 access_token
        $result = file_get_contents('https://api.weixin.qq.com/sns/oauth2/access_token?appid=' . env('WECHAT_APPID') . '&secret=' . env('WECHAT_APPSECRET') . '&code=' . $req['code'] . '&grant_type=authorization_code');
        $res = json_decode($result, 1);
        //拉取用户信息(需scope为 snsapi_userinfo)
        $user_info = file_get_contents('https://api.weixin.qq.com/sns/userinfo?access_token=' . $res['access_token'] . '&openid=' . env('WECHAT_APPID') . '&lang=zh_CN');
        $cront_user_info = json_decode($user_info, 1);
        //取出openID查询一条
        $openid = $cront_user_info['openid'];
        $user_id = DB::table('regist')->where(['openid' => $openid])->first();
        //如 不为空则登录
        if (!empty($user_id)) {
            $cront_session = $request->session('user_id', $user_id->user_id);
            echo '成功';
        } else {
            //为空注册登录
            $user_id = DB::table('regist')->insertGetiD([
                'useremail' => $cront_user_info['nickname'],
                'userpwd' => '',
                'openid' => $openid,
            ]);
            $result = DB::table('wechat_user')->insert([
                'user_id' => $user_id,
                'openid' => $openid,
            ]);
            $cront_session = $request->session('user_id', $user_id->user_id);
            echo 'ok';
        }
    }

    //标签管理
    public function cron_list()
    {
        $url = file_get_contents('https://api.weixin.qq.com/cgi-bin/tags/get?access_token=' . $this->tools->get_wechat_access_token());
        //dd($url);
        $re = json_decode($url, 1);
        return view('cront.cron_list',['info'=>$re['tags']]);
    }
    //粉丝列表
    public function user_list(Request $request)
    {
        $req = $request->all();
        //dd($req);
        $url = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/get?access_token=".$this->tools->get_wechat_access_token()."&next_openid=");
        $res = json_decode($url,1);
        $lase_info = [];
        foreach($res['data']['openid'] as $k=>$v){
            //获取用户详细信息
            $user_info = file_get_contents("https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$this->tools->get_wechat_access_token()."&openid=".$v."&lang=zh_CN");
            $re = json_decode($user_info,1);
            $lase_info[$k]['nickname'] = $re['nickname'];
            $lase_info[$k]['openid'] = $re['openid'];
        }
        //dd($lase_info);
        return view('cront.user_list',['info'=>$lase_info,'tagid'=>isset($req['tagid'])?$req['tagid']:'']);
    }
    // 添加标签
    public function cront_add()
    {
        return view('cront.cront_add');
    }
    //添加标签执行页面
    public function add_do(Request $request)
    {
        $req = $request->all();
        $data = [
            'tag'=>[
                'name'=>$req['cront_name'],
            ]
        ];
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/create?access_token='.$this->tools->get_wechat_access_token();
        $result = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        $re = json_decode($result);
        //dd($re);
        echo'添加成功';
    }
    //批量为用户打标签
    public function cron_openid()
    {
        $req = Request()->all();
        //dd($req);
        $url = 'https://api.weixin.qq.com/cgi-bin/tags/members/batchtagging?access_token='.$this->tools->get_wechat_access_token();
        $data = [
            'openid_list' =>$req['cront_list'],
            'tagid'=>$req['tagid'],
        ];
       // dd($data);
        $re = $this->tools->curl_post($url,json_encode($data));
//    dd($re);
        $result = json_decode($re,1);
        dd($result);
    }
    //通过标签群发消息
    public function quefa()
    {
        return view('cront.quefa',['tagid'=>Request()->all()['tagid']]);
    }
    public function quefa_do()
    {
        $req = Request()->all();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/mass/sendall?access_token='.$this->tools->get_wechat_access_token();
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
        $re = $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
        //存redis
        $this->tools->redis->set('name',json_encode($data));
        $result = json_decode($re,1);
        dd($result);
    }
}
