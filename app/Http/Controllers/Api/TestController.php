<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
class TestController extends Controller
{
    //模拟添加
    public function add(Request $request)
    {
        //接受数据
        $name = $request->input('name');
        $age = $request->input('age');
        if(empty($name)|| empty($age))
        {
            return json_encode(['ret'=>3,'msg'=>'参数不能为空']);
        }
        //接口添加入库
        $res = DB::table('test')->insert([
            'test_name'=>$name,
            'test_age'=>$age,
        ]);
        if($res)
        {
            return json_encode(['ret'=>1,'msg'=>'添加成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'异常']);
        }
    }
    //接口展示
    public function show()
    {
        //查询
        $data = DB::table('test')->get();
        return json_encode([
            'ret'=>1,
            'msg'=>'查询成功',
            'data'=>$data,
        ]);

    }
    //修改
    public function find(Request $request)
    {
        //接受数据
        $id = $request->id;
        $data = DB::table('test')->where(['test_id'=>$id])->first();
        if($data)
        {
            return json_encode(['ret'=>1,'msg'=>'查找成功','data'=>$data]);
        }else{
            return json_encode(['ret'=>0,'msg'=>'失败']);
        }
    }
    //修改执行页面
    public function upl(Request $request)
    {
        $name = $request->name;
        $age = $request->age;
        $id = $request->id;
        $res = DB::table('test')->where(['test_id'=>$id])->update(['test_name'=>$name,'test_age'=>$age]);
        if($res)
        {
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }
    public function del(Request $request)
    {
        //接受id
        $id = $request->id;
       $res = DB::table('test')->where(['test_id'=>$id])->delete();
        if($res)
        {
            return json_encode(['ret'=>1,'msg'=>'删除成功']);
        }
    }
}
