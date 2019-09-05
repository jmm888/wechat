<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;

class GoodsController extends Controller
{
    public function index()
    {
        return view('goods/index');
    }
    //头部
    public function head()
    {
        return view('goods/head');
    }
    public function left()
    {
        return view('goods/left');
    }
    public function main()
    {
        return view('goods/main');
    }
    //管理员管理
    public function user_add()
    {
        //return view('goods/user_add');
        $data = DB::table('user')->get();
        return view('goods/user_add',['data'=>$data]);
    }
    public function add_do()
    {
        $post = Request()->except(['_token']);
        $post['user_pwd'] = md5($post['user_pwd']);
        $post['add_time'] = time();

        //  //第一种验
        // $validator = Validator::make(request()->all(), [
        //     'user_name'=>'required|unique:student|max:30',
        //     'user_pwd'=>'required|numeric',
        // ],[
        //     'user_name.required'=>'用户不能为空',
        //     'user_pwd.required'=>'密码不能为空',
        // ]);
        // if ($validator->fails()) {
        //         echo json_encode(['ret'=>0,'msg'=>$validator->errors()]);
        // }

        $res = DB::table('user')->insert($post);
        //dd($res);
        if($res)
        {
            return json_encode(['ret'=>1,'msg'=>'添加成功']);die;
        }else{
            return json_encode(['ret'=>0,'msg'=>'添加失败']);die;
        }
    }
  
}
