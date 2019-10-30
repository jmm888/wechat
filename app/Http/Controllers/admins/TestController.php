<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\News;
use App\Model\Login;
use App\Tools\Curl;
class TestController extends Controller
{
    //获取新闻
    public function news()
    {
        set_time_limit(100);
        //调用时事热点接口
        $url = "http://api.avatardata.cn/ActNews/LookUp?key=03f559ae29d6499880f48609091b1143";
        $hotData = Curl::get($url);
        $result = json_decode($hotData,1);
        $keyword = [];
        //for 循环取出前十条
        for($i=0;$i<=9;$i++)
        {
            $keyword[] = $result['result'][$i];
        }
        //foreach循环热门关键字
        foreach($keyword as $k=>$v)
        {
            $url = 'http://api.avatardata.cn/ActNews/Query?key=03f559ae29d6499880f48609091b1143&keyword='.$v;
            $data =Curl::get($url);
            $res = json_decode($data,1);
            //如果获取的新闻数据不为空的情况下添加入库
            if(!empty($res['result']))
            {
                foreach($res['result'] as $key=>$val){
                    //查询数据库是否有相等的数据
                    $new = News::where(['title'=>$val['title']])->first();
                    if(!$new)
                    {
                        $newData = News::create([
                            'title'=>$val['title'],
                            'content'=>$val['content'],
                            'full_title'=>$val['full_title'],
                            'pdate'=>$val['pdate'],
                            'src'=>$val['src'],
                            'img'=>$val['img'],
                            'pdate_src'=>$val['pdate_src'],
                        ]);
                    }
                }
            }
        }
        if($newData)
        {
            return json_encode(['ret'=>1,'msg'=>'获取成功']);
        }
    }
    //注册
    public function register(Request $request)
    {
        //接收数据
        $username = $request->input('username');
        $pwd = $request->input('pwd');
        if(empty($username) || empty($pwd))
        {
            return json_encode(['ret'=>201,'msg'=>'参数不能为空']);
        }
        //查询数据库是否有此字段
        $res = Login::where(['user_name'=>$username])->first();
        if($res)
        {
            return json_encode(['ret'=>210,'msg'=>'数据库有此用户名']);
        }else{
            //入库
            $data = Login::create([
                'user_name'=>$username,
                'user_pwd'=>$pwd,
            ]);
        }
        if($data)
        {
            return json_encode(['ret'=>1,'msg'=>'添加成功']);
        }
    }
    /**
     *登录
     */
    public function login_do(Request $request)
    {
        $name = $request->input('name');
        $pwd = $request->input('pwd');
        $data = Login::where(['user_name'=>$name,'user_pwd'=>$pwd])->first();
        if(empty($data))
        {
            return json_encode(['ret'=>201,'msg'=>'用户名或密码错误']);
        }else{
            return json_encode(['ret'=>1,'msg'=>'登录成功']);
        }
    }
    /*
     * 实时新闻展示页面
     * */
    public function show()
    {
        $data =News::paginate(10)->toArray();
        return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$data]);
    }
}
