<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Validator;
class BrandController extends Controller
{
    public function brand_add()
    {
        return view('brand/brand_add');
    }
    //添加执行页面
    public function brand_do()
    {   
        $post = Request()->except(['_token']);

          //第三种验证
          $validator = Validator::make($post, [
            'brand_name' => 'required|unique:brand',
            'brand_url' => 'required',
         ],[
            'brand_name.required'=>'品牌名称不能为空',
             'brand_name.unique'=>'品牌名称已存在',
             'brand_url.required'=>'品牌网址不能为空'
            ]);
            if ($validator->fails()) {
            return redirect('brand/brand_add')
            ->withErrors($validator)
           ->withInput();
            }

         //调用文件上传方法
           // dd(request()->hasFile('brand_logo'));
            if(request()->hasFile('brand_logo'))
            {
             $post['brand_logo'] = upload('brand_logo');
            }
        $res = DB::table('brand')->insert($post);
       if($res)
       {
           return redirect('brand/brand_list');
       }
    }
    //品牌列表
    public function brand_list()
    {
        $query = Request()->input();
        $brand_name = $query['brand_name']??'';
        $is_show = $query['is_show']??'';
        $where = [];
        if($brand_name)
        {
            $where[] = ['brand_name','like',$brand_name.'%'];
        }
        if($is_show||$is_show==='0')
        {
            $where[] = ['is_show','=',$is_show];
        }
        $pagesize = config('app.pagesize');
        $data = DB::table('brand')->where($where)->paginate($pagesize);
        return view('brand/brand_list',compact(['data','brand_name','is_show']));
    }
    //品牌验证
    public function brandName(){
        $brand_name = Request()->brand_name;
        $brand_id = Request()->brand_id??"";
        // dd($brand_id);
        if($brand_id){
            $where[]=['brand_id','!=',$brand_id];
        }
        if($brand_name){
            $where[]=['brand_name','=',$brand_name];
        }
        $count = DB::table('brand')->where($where)->count();
        echo $count;
    }
    //品牌修改
    public function brand_update($id)
    {
        $data = DB::table('brand')->where('brand_id',$id)->first();
       return view('brand/brand_update',['data'=>$data]);
    }
    //品牌修改执行页面
    public function brand_upd_do($id)
    {
        $data = Request()->except(['_token']);
         //判断有否文件上传
         if(request()->hasFile('brand_logo'))
         {
          //调用文件上传方法
          $data['brand_logo'] = upload('brand_logo');
          //获取修改之前的图片
          $filename = storage_path('app/public').'/'.$data['oldimg'];
          //判断旧的文件是否存在 
          if(file_exists($filename)){
          //如存在 删除旧的图片
          unlink($filename);}
         }
         //删除隐藏域传过来的字段
         unset($data['oldimg']);
        $res = DB::table('brand')->where('brand_id',$id)->update($data);
        if($res){
            return redirect('brand/brand_list');
        }
    }
    //品牌删除
    public function brand_del(){
        $brand_id = Request()->brand_id;
        $res = DB::table('brand')->where('brand_id',$brand_id)->delete();
        if($res){
            return['reg'=>00000,'msg'=>'删除成功'];
        }
    }
}
