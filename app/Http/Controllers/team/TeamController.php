<?php

namespace App\Http\Controllers\team;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class TeamController extends Controller
{
    //竞猜添加页面
    public function team_add(){
        return view('team/team_add');
    }
    //竞猜添加执行页面
    public function team_do()
    {
        $data = Request()->except(['_token']);
        if($data['team_one']==$data['team_two']){
        echo "<script>alert('名称不可相同');history.go(-1);</script>";exit;
        }
        $data['team_time'] = strtotime($data['team_time']);
        $res = DB::table('team')->insert($data);
       if($res){
           return redirect('team/team_list');
       }
    }
    //竞猜列表
    public function team_list()
    {
        $data = DB::table('team')->get();
        return view('team/team_list',['data'=>$data]);
    }
    //参与竞猜页面
    public function team_comp($id){
        $data = DB::table('team')->where('team_id',$id)->first();
        // dd($data);
        //dd($data['cai']);

        if($data->cai == null){
            return view('team/team_comp',['data'=>$data]);
        }else{
        echo "<script>alert('您已竞猜');history.go(-1);</script>";exit;
        }
        
    }
    public function comp_do($id)
    {
        $data= Request()->except(['_token']);
        $res = DB::table('team')->where(['team_id'=>$id])->update($data);
        if($res)
        {
            return redirect('team/team_list');
        }
    }
    //查看结果页面
    public function ending($id){
        $data = DB::table('team')->where('team_id',$id)->first();
        //dd($data);
        return view('team/ending',['data'=>$data]);
    }
    //竞猜结果页面
    public function jieguo($id)
    {
        $data = DB::table('team')->where('team_id',$id)->first();
        return view('team/jieguo',['data'=>$data]);
    }
}
