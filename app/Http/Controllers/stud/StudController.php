<?php

namespace App\Http\Controllers\stud;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class StudController extends Controller
{
    public function add()
    {
        return view('stud/add');
    }
    public function add_do()
    {
        $res = Request()->except(['_token']);
       $data = DB::table('stud')->insert($res);
       if($data)
       {
           return redirect('stud/list');
       }
    }
    public function list()
    {
        $data = DB::table('stud')->where('status',1)->get();
        $datas = DB::table('stud')->where('status',0)->get();
        return view('stud/list',['data'=>$data,'datas'=>$datas]);
    }
    public function upl($id)
    {
        $data = DB::table('stud')->where('stu_id',$id)->first();
        return view('stud/upl',['data'=>$data]);
    }
    public function upl_do($id)
    {
       $data = request()->except(['_token']);
       $res = DB::table('stud')->where('stu_id',$id)->update($data);
      if($res)
      {
          return redirect('stud/list');
      }
    }
    public function del($id){
        $res = DB::table('stud')->where('stu_id',$id)->update(['status'=>0]);
       if($res)
       {
           return redirect('stud/list');
       }
    }
}