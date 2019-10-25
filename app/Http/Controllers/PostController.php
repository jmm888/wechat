<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Test;
class PostController extends Controller
{
    /**
     * 查询展示
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //查询有无搜索有则搜索
        $name = Request()->name;
        $where = [];
        if(isset($name)){
            $where[] = ['test_name','like',"%$name%"];
        }
        $data = Test::where($where)->paginate(3);
        return json_encode([
            'ret'=>1,
            'msg'=>'查询成功',
            'data'=>$data,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        echo 'create';
    }

    /**
     * Store a newly created resource in storage.
     *添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //接受数据
        $name = $request->input('name');
        $age = $request->input('age');
        if(empty($name)|| empty($age))
        {
            return json_encode(['ret'=>3,'msg'=>'参数不能为空']);
        }
        //接受图片
        if ($request->hasFile('photo')) {
            //
        }
        //接口添加入库
        $res = Test::create([
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        //接受数据
        $data = Test::where(['test_id'=>$id])->first();
        if($data)
        {
            return json_encode(['ret'=>1,'msg'=>'查找成功','data'=>$data]);
        }else{
            return json_encode(['ret'=>0,'msg'=>'失败']);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $name = $request->name;
        $age = $request->age;
        $res = Test::where(['test_id'=>$id])->update(['test_name'=>$name,'test_age'=>$age]);
        if($res)
        {
            return json_encode(['ret'=>1,'msg'=>'修改成功']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //接受id

        $res = Test::where(['test_id'=>$id])->delete();
        if($res)
        {
            return json_encode(['ret'=>1,'msg'=>'删除成功']);
        }
    }
}
