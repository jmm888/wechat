<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Login;
use App\Model\ClassModel;
use App\Model\Stu;
use App\Tools\Aes;
use App\Tools\Rsa;
use function App\Tools\p;

class UserController extends Controller
{
    //10.28练习对称加密
    public function aes()
    {
        $obj = new Aes('1234567890123456');
        $data = "相信自己是最没用的";
        echo $eStr = $obj->encrypt($data);  //加密后的密文
        echo "<hr>";
        echo $obj->decrypt($eStr);
    }
//    //10.28非对称加密
//    public function rsa()
//    {
//        //举个粒子
//        $Rsa = new Rsa();
//        $keys = $Rsa->new_rsa_key(); //生成完key之后应该记录下key值，这里省略
//        p($keys);
//        die;
//        $privkey = file_get_contents("cert_private.pem");//$keys['privkey'];
//        $pubkey = file_get_contents("cert_public.pem");//$keys['pubkey'];
//        //echo $privkey;die;
//        //初始化rsaobject
//        $Rsa->init($privkey, $pubkey, TRUE);
//        //原文
//        $data = '学习PHP太开心了';
//        //私钥加密示例
//        $encode = $Rsa->priv_encode($data);
//        p($encode);
//        $ret = $Rsa->pub_decode($encode);
//        p($ret);
//
//        //公钥加密示例
//        $encode = $Rsa->pub_encode($data);
//
//        p($encode);
//        $ret = $Rsa->priv_decode($encode);
//        p($ret);
//        function p($str)
//        {
//            echo '<pre>';
//            print_r($str);
//            echo '</pre>';
//        }
//    }
    /*
        * 10.26练习处理数据
        * */
    public function class_show(Request $request)
    {
        //查询班级表
        $classData = ClassModel::get()->toArray();
        foreach($classData as $k=>$v)
        {
            //查询学生表里的classid等于循环里的class_id 获得个数
            $stunum = Stu::where(['class_id'=>$v['class_id']])->count();
            $classData[$k]['stucount'] = $stunum;
        }
        return view('stud/class_show',['classData'=>$classData]);
    }
    public function stu_show(Request $request)
    {
        //查询班级表
     $classData = ClassModel::get()->toArray();
     foreach($classData as $key=>$val)
     {
        $stuData = Stu::where(['class_id'=>$val['class_id']])->get()->toArray();
         $classData[$key]['stu_list'] = $stuData;
     }
        //dd($classData);
        return view('stud/class_list',['classData'=>$classData]);
    }
    /**
     * 用户登录接口
     */
    public function login(Request $request)
    {
        //接受用户名，密码
        $username = $request->input('username');
        $userpwd = $request->input('userpwd');
        //查询数据库，进行校验
        $res = Login::where(['user_name'=>$username,'user_pwd'=>$userpwd])->first();
        //验证
        if(empty($res))
        {
             echo "用户名或密码错误";die;
        }
        //用户登录成功
        //生成token令牌
        $token = md5('login_id'.time());//生成一个不重复的token令牌
        //修改数据库
        $res->token = $token;
        $res->expire_time = time()+7200;//过期时间
        $res->save();
        //把token返回给客户端
        return json_encode(['ret'=>1,'msg'=>'查询成功','token'=>$token]);
    }
    /*
     * 接受token进行验证
     * */
    public function getUser(Request $request)
    {
        $token = $request->input('token');
        //验证如果token不存在
        if(empty($token))
        {
           return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //验证token是否正确
        $userData = Login::where(['token'=>$token])->first();
        if(!$userData)
        {
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //验证token是否过期
        if(time() > $userData['expire_time'])
        {
            return json_encode(['ret'=>201,'msg'=>'请先登录']);
        }
        //延长token有效期
        $userData->expire_time = time()+7200;
        $userData->save();
        //具体业务逻辑
    }
}
