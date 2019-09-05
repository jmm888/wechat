<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Validator;
use DB;
use App\admin\WzModel;
class WzController extends Controller
{
    public function wz_add()
    {
        return view('wz/wz_add');
    }
    public function wz_do()
    {
        $post = Request()->except(['_token']);
        //dd($post);
         //第三种验证
         $validator = Validator::make($post, [
            'wz_name' => 'required',
            'wz_wz' => 'required',
        ],[
            'wz_name.required'=>'网站名称不能为空',
             'wz_wz.required'=>'请输入网址名称'
        ]);
            if ($validator->fails()) {
            return redirect('wz/wz_add')
            ->withErrors($validator)
           ->withInput();
            };

        //判断是否有文件上传
        if(request()->hasFile('wz_img'))
        {
            $post['wz_img'] = upload('wz_img');
        }  
       $res = DB::table('wz')->insert($post);
       if($res)
       {
           return redirect('wz/wz_list');
       }
    }
    public function wz_list()
    {
       $query = Request()->input();
       $wz_name = $query['wz_name']??'';
       $where=[];
       if($wz_name)
       {
           $where[]=['wz_name','like',$wz_name.'%'];
       }
        $pagesize = config('app.pagesize');
        $data = DB::table('wz')->where($where)->paginate($pagesize);
        return view('wz/wz_list',compact(['data','wz_name','query']));
    }
    public function wz_del($id)
    {
        $res = DB::table('wz')->where('wz_id',$id)->delete();
       if($res)
       {
        return ['ret'=>'00000','msg'=>'删除成功'];die;
       }
    }
    public function wz_upl($id)
    {
        $data = WzModel::find($id);
        //dd($data);
        return view('wz/wz_upl',['data'=>$data]);
    }
    public function update($id)
    {
        $data = Request()->except(['_token']);
        //判断是否有文件上传
        if(request()->hasFile('wz_img'))
        {
         //调用文件上传方法
         $data['wz_img'] = upload('wz_img');
         if($data['oldimg']){

                //获取修改之前的图片
                $filename = storage_path('app/public').'/'.$data['oldimg'];
                //判断旧的文件是否存在 
                if(file_exists($filename)){
                //如存在 删除旧的图片
                unlink($filename);}
                }
        }
        //删除隐藏域传过来的字段
        unset($data['oldimg']);
        $res = WzModel::where('wz_id',$id)->update($data);
        if($res)
        {
            echo "<script>alert('修改成功');history.go(-2);</script>";exit;
        }
    }
}
