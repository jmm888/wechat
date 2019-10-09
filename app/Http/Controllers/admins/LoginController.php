<?php

namespace App\Http\Controllers\admins;

use App\Tools\Tools;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\Model\Code;
class LoginController extends Controller
{
    public $tools;
    public function __construct(Tools $tools)
    {
        $this->tools = $tools;
    }
    //扫码登录
    public function wechat()
    {
        //二维码识别后的唯一标识
        $id = time().rand(1000,9999);//生成一个 不重复的随机数
        $redirect_url = "http://www.jiamengmeng.cn/admin/mobileScan?id=".$id;//跳转地址
        return view('login/wechat',[
        'redirect_url'=>$redirect_url,
            'id'=>$id,
        ]);
    }
    //扫码登录跳转页面
    public function mobileScan()
    {
        //接受二维码唯一标识
        $id = Request()->all();
        //通过网页授权获取openID
        $openid = Tools::getOpenid();
        //进行储存
        $this->tools->set('wechatlogin_'.$id,$openid,10);
        return '扫码登录成功,请稍等';
    }
    //登录页面
    public function login()
    {
        return view('login/login');
    }
    //登录执行页面
    public function login_do()
    {
        $req = Request()->all();
        $code = $this->tools->redis->get('code');
        if($req['code'] !=$code){
            echo "<script>alert('验证码错误');history.go(-1);</script>";
        }else{
            return redirect('admin/index');
        }
    }
    //绑定账号
    public function bang()
    {
        return view('login/bang');
    }
    //绑定执行页面
    public function bang_do()
    {
        $req = Request()->all();
        //dd($req);
        $openid = Tools::getOpenid();
      $login_db = DB::table('logins')->where(['username'=>$req['username'],'pwd'=>$req['pwd']])->first();
      //dd($login_db);
      if(empty($login_db))
      {
          echo "<script>alert('用户名或密码错误');history.go(-1);</script>";
      }
          //检测是否绑定过
         else{
              $login_db = DB::table('logins')->where(['username'=>$req['username'],'pwd'=>$req['pwd']])->update(['openid'=>$openid]);
              echo "绑定成功";
          }

    }
    //点击按钮发送模板消息
    public function send()
    {
        //接受用户名 密码
        $data = Request()->all();
        //查询表
        $req = DB::table('logins')->where(['username'=>$data['username'],'pwd'=>$data['pwd']])->first();
        if(empty($req)) {
            dd('用户名或密码不存在');
        }
        $resData = get_object_vars($req);
        $openid = $resData['openid'];
        //dd($openid);
        $code = rand(1000, 9999);
        //储存验证码
        $this->tools->redis->set('code',$code);
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token='.$this->tools->get_wechat_access_token();
        //参数
        $data = [
            "touser" =>$openid,
            "template_id" => "TS54ISB0cTmp9LUn8ytQWPxWLysIuJA9jS_6TYdp0-k",
            'data' => [
                "keyword1" => [
                    "value" => $code,
                    "color" => "#173177"
                ],
                "keyword2" => [
                    "value" => $resData['username'],
                    "color" => "#173177"
                ],
                "keyword3" => [
                    "value" =>date('Y-m-d h:i:s', time()),
                    "color" => "#173177"
                ],
            ],
        ];
        $this->tools->curl_post($url,json_encode($data,JSON_UNESCAPED_UNICODE));
    }
}
