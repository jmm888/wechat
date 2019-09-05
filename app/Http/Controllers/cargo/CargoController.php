<?php

namespace App\Http\Controllers\cargo;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class CargoController extends Controller
{
    public function login()
    {
        return view('cargo/login');
    }
    public function login_do()
    {
        $data = Request()->except(['_token']);
        //dd($data);
        $user_name = $data['user_name'];
        $user_pwd = $data['user_pwd'];
        //  dd($user_pwd);
        //dd($user_name);
        $status = DB::table('newtitle')->where(['user_name'=>$user_name])->first();
        $status = json_decode(json_encode($status), true);
         //dd($status);
       if(!$status)
       {
        echo "<script>alert('用户名不存在');history.go(-1);</script>";exit;
       }else{
           session(['login'=>$status]);
           return redirect('cargo/cargo_list');
       }
    
    }
    //货物添加
    public function cargo_add()
    {
        if(!session('login')){
            return redirect('cargo/login');
        }
        return view('cargo/cargo_add');
    }
    public function cargo_do()
    {
        if(!session('login')){
            return redirect('cargo/login');
        }
        $post = Request()->except(['_token']);
       // dd($data);
       $post['add_time'] = time();
        //判断是否有文件上传
        if(request()->hasFile('cargo_img'))
        {
            $post['cargo_img'] = upload('cargo_img');
        }
        $res = DB::table('cargo')->insert($post);
        if($res)
        {
            return redirect('cargo/cargo_list');
        }
    }
    public function cargo_list()
    {
        if(!session('login')){
            return redirect('cargo/login');
        }
        $data = DB::table('cargo')->get();
        //dd($data);
        return view('cargo/cargo_list',['data'=>$data]);
    }
    //出库
    public function chu($id)
    {
        $data = DB::table('cargo')->where('cargo_id',$id)->first();
        //dd($data);
       return view('cargo/chu',['data'=>$data]);
    }
    public function chu_do($id)
    {
        $res = DB::table('cargo')->where('cargo_id',$id)->first();
        //dd($res);
        $res = json_decode(json_encode($res), true);
        $data  = Request()->except(['_token']);
        $data['chu_time'] = time();
        // dd($data);
        if($data['cargo_num_chu'] > $res['cargo_num'])
        {
        echo "<script>alert('出库数量不能超过库存数量');history.go(-1);</script>";exit;
        }else{
            $res['cargo_num'] = $res['cargo_num'] - $data['cargo_num_chu'];
            $res['cargo_num_chu'] = $data['cargo_num_chu'];
            $res['chu_time'] =  $data['chu_time'];
            $res =  DB::table('cargo')->where('cargo_id',$id)->update($res);
            // dd($res);
            if($res)
            {
                return redirect('cargo/cargo_list');
            }
        }
    }
    // 查看日志
    public function rizhi($id)
    {
        $res['user_id'] = session('login')['user_name'];
        //dd($res);
        $data = DB::table('cargo')->where('cargo_id',$id)->first();
        // $data['user_id'] = session('login')['user_id'];
        // dd($data);
        return view('cargo/rizhi',['data'=>$data,'res'=>$res]);    
    }
    public function jilu($id)
    {
        $res['user_id'] = session('login')['user_id'];
        $data = DB::table('cargo')->where('cargo_id',$id)->first();
        return view('cargo/jilu',['data'=>$data,'res'=>$res]);    
    }
}
