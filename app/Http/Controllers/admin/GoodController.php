<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class GoodController extends Controller
{
   public function good_add()
   {
       $brand = DB::table('brand')->get();
       //dd($data);
       $cat = DB::table('cat')->get();
       $cat=$this->createTree($cat);
       return view('good/good_add',['brand'=>$brand],['cat'=>$cat]);
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
     //添加执行页面
     public function good_do()
     {
         $post = Request()->except(['_token']);
         $post['goods_sn'] = 'laravel'.'1902'.rand(1000,9999).date('Ymd');
         //判断是否有文件上传
        if(request()->hasFile('goods_img'))
        {
            $post['goods_img'] = upload('goods_img');
        }
        $res = DB::table('goods')->insert($post);
        if($res)
        {
            return redirect('good/good_list');
        }
     }
     //商品展示列表
     public function good_list()
     {
         $query = Request()->input();
         $goods_name = $query['goods_name']??'';
         $is_on_sale = $query['is_on_sale']??'';
         $where = [];
        if($goods_name)
        {
            $where[] =['goods_name','like','%'.$goods_name.'%'];
        }
        if($is_on_sale||$is_on_sale==='0')
        {
            $where[] = ['is_on_sale','=',$is_on_sale];
        }
         $pagesize=config('app.pagesize');
         $data = DB::table('goods')->where($where)->join('cat','cat.cat_id','=','goods.cat_id')
         ->join('brand','brand.brand_id','=','goods.brand_id')->paginate($pagesize);
         $goods_id = $data['goods_id'];
         //dd($data);
        return view('good/good_list',compact(['data','goods_name','is_on_sale','goods_id']));
     }
     //商品名称唯一性验证
     public function goodName()
     {
         $goods_name = Request()->goods_name;
        $count  = DB::table('goods')->where('goods_name','=',$goods_name)->count();
        echo $count;
     }
}
