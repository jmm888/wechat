<?php

namespace App\Http\Controllers\title;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Redis;
class TitleController extends Controller
{
    public function login()
    {
        return view('title/login');
    }
    public function login_do()
    {
        $data = Request()->except(['_token']);
        //dd($data);
        $user_name = $data['user_name'];
       // $user_pwd = $data['user_pwd'];
        // dd($user_pwd);
        //dd($user_name);
        $status = DB::table('newtitle')->where(['user_name'=>$user_name])->first();
        $status = json_decode(json_encode($status), true);
         //dd($status);
       if(!$status)
       {
        echo "<script>alert('用户名不存在');history.go(-1);</script>";exit;
       }else{
           session(['login'=>$status]);
           return redirect('title/list');
       }
    
    }
   public function add()
   {
       return view('title/add');
   }
   public function add_do()
   {
       $res = Request()->except(['_token']);
       $res['add_time'] = time();
    //    dd($res);
       $data = DB::table('title')->insert($res);
      if($data)
      {
          return redirect('title/list');
      }
   }
   public function list()
   {
       if(!session('login'))
       {
           return redirect('title/login');
       }
       $data = DB::table('title')->get();
       $data = json_decode(json_encode($data), true);
    //    dd($data);
       $rela = DB::table('relation')->where(['user_id'=>session('login')['user_id']])->get();
    //    $rela = json_decode(json_encode($rela), true);
        //dd($rela);
       $rela = json_decode(json_encode($rela), true);
       $dianzan = array_column($rela,'t_id');
       //foreach循环 Redis传过来的点赞数
       foreach($data as $k=>$v)
       {
           $dian = Redis::get('dianzan'.$v['t_id']);
           $data[$k]['dian'] = $dian;
           $data[$k]['flag'] = in_array($v['t_id'],$dianzan)?'取消点赞':'点赞';

       }
       //dd($data);
       return view('title/list',['data'=>$data]);
   }
   public function content($id)
   {
       $res = DB::table('title')->where('t_id',$id)->first();
    //    dd($data);
    return view('title/content',['res'=>$res]);
   }
   //点赞数量
   public function list_num()
   {
        $id = Request()->get('id');
        $flag = Request()->get('flag');
        if($flag=='点赞')
        {
            Redis::incr('dianzan' . $id);
            DB::table('relation')->insert(['user_id'=>session('login')['user_id'],'t_id'=>$id]);
        }else{
            Redis::decr('dianzan' . $id);
            DB::table('relation')->where(['user_id'=>session('login')['user_id'],'t_id'=>$id])->delete();
        }
        
       echo Redis::get('dianzan' . $id);
   }
}
