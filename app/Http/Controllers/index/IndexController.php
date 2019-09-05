<?php

namespace App\Http\Controllers\index;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Redis;
class IndexController extends Controller
{
    public function index()
    {
        //操作redis
        // Redis::set('name','123');
        // echo Redis::get('name');
        // die;
        //实例化memcache
        // $memcache = New \Memcache;
        // //链接服务器  第一个参数服务地址  第二个端口号 默认11211
        // $memcache->connect('127.0.0.1','11211');
        // //memcache赋值  set赋值  get取值 第一个参数 键，第二个 值，第三个默认0，第四个过期时间， 
        // $memcache->set('keys','qqq',0,10);
        // //memcache 取值
        // echo $memcache->get('keys');
        //缓存中取值
    //     $data = $memcache->get('IndexController_index_student');
    //     if(empty($data))
    //     {   //使用 可以缓存一小时
    //         $data = json_encode(DB::table('student')->get());
    //         //dd($data);
    //         //设置缓存
    //         $memcache->set('IndexController_index_student',$data,0,10);
    //     }
    //   print_r($data);

    //     die;
        //全局搜索
        $goods_name = Request()->goods_name;
        //搜索条件
        if($goods_name){
        $where[] = ['goods_name','like',$goods_name.'%'];
        }
        //判断有无搜索条件
        if($goods_name){
              //有则查询
            $is_recommend = DB::table('goods')->where($where)->get();
        }else{
             //无则查询商品
            $is_recommend = DB::table('goods')->where('is_recommend',1)->limit(8)->get();
        }
          //查询幻灯片
          $is_slide = DB::table('goods')->where('is_slide',1)->orderby('goods_id','desc')->limit(5)->get();
         // dd($is_slide);
        //查询全部商品
        $count  = DB::table('goods')->count();
         //查询一级分类
         $data = DB::table('cat')->where('parent_id',0)->get();
        return view('index/index',['is_slide'=>$is_slide,'is_recommend'=>$is_recommend,'data'=>$data,'count'=>$count]);
    }
    //全部商品列表
    public function prolist()
    {
        $data = DB::table('goods')->get();
        return view('index/prolist',['data'=>$data]);
    }
    //商品详情页
    public function proinfo($id)
    {
        $data = DB::table('goods')->where('goods_id',$id)->first();
        // dd($data);
        return view('index/proinfo',['data'=>$data]);
    }
    //分类列表
    public function prolist_one($id)
    {
        $res = DB::table('cat')->get();
        $res = createtree($res,$id);
        //dd($res);
        $where=[
            'cat_id'=>$id,
        ];
        //查询顶级分类
        $cates=DB::table('cat')->where($where)->get()->toarray();
        //dd($cates);die;
        //合并子分类和顶级分类
        $cat=array_merge($res,$cates);
        //dd($cat);
        //把合并的值转换为数组
        $cat = json_decode(json_encode($cat),true);
        //dd($cat);
        //取出所有的cta_id
        $column=array_column($cat,'cat_id');
       // dd($column);
        //根据cat_id查询商品表
        $data=DB::table('goods')->where(['goods.cat_id'=>$column])->get();
        //dd($data);
        return view('index/prolist_one',['data'=>$data]);
    }
   
}
