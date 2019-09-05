<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use App\admin\Catmodel;
class CatController extends Controller
{
    //添加页面
    public function cat_add()
    {
        $data=DB::table('cat')->get()->toArray();
        // dd($data);
        $data=$this->createTree($data);
        return view('cat/cat_add',['data'=>$data]);
       
    }
    //添加执行页面
    public function cat_do()
    {
        $data = Request()->except(['_token']);
        $res = DB::table('cat')->insert($data);
        if($res)
        {
            return redirect('cat/cat_list');
        }
    }
    //列表展示页面
    public function cat_list()
    {
        $data = DB::table('cat')->get()->toArray();
        //dd($data);
        $data=$this->createTree($data);
        return view('cat/cat_list',['data'=>$data]);
    }
    //递归
    public function createTree($data,$parent_id=0,$level=1)
    {
        //1.定义一个新容器
        static $new_arr=[];
        //2.便利数据一条条显示
        foreach($data as $k=>$v)
        {
        //3.parent_id等于0的
            if($v->parent_id==$parent_id)
            {
              //添加level 字段用来区别等级
              $v->level = $level;
        //4.找到之后放到新数组里
            $new_arr[] = $v;
            //调用程序自身找子集
            $this->createTree($data,$v->cat_id,$level+1);
            }
        }
        return $new_arr;
    }
    //分类删除
    public function cat_del($id)
    {
        $count = Catmodel::where(['parent_id'=>$id])->count();
        if($count){
           echo "<script>alert('分类下有子类，不能删除');history.go(-1);</script>";exit;
        }
        $res = Catmodel::destroy($id);
       if($res){
           return redirect("cat/cat_list");
       }
    }
    //分类唯一性验证
    public function catName(){
    $cat_name = Request()->cat_name;
    $count = Catmodel::where('cat_name','=',$cat_name)->count();
    echo $count;
    }
}
