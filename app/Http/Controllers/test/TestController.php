<?php

namespace App\Http\Controllers\test;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Good;

class TestController extends Controller
{
    /**
     * 查询展示
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //判断有无搜索条件
        $name = Request()->name;
        $where = [];
        if(isset($name))
        {
            $where[] = ['good_name','like',"%$name%"];
        }
        $data = Good::where($where)->paginate(5);
        if($data)
        {
            return json_encode([
                'ret'=>1,
                'msg'=>'查询成功',
                'data'=>$data,
                ]);
        }else{
            return json_encode(['ret'=>0,'msg'=>'异常']);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *商品添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $good_name = $request->input("good_name");
        $good_price = $request->input("good_price");
        if(empty($good_name)|| empty($good_price))
        {
            return json_encode(['ret'=>3,'msg'=>'参数不能为空']);
        }
        //文件上传
        // if ($request->hasFile('photo')) {
        //     $file = $request->file('photo');
        //     $extension = $request->photo->extension();
        //     $path = $request->photo->store('photo');
        //    }
        if ($request->hasFile('photo') && $request->file('photo')->isValid()) {
            $photo = $request->file('photo');
            $extension = $photo->extension();
            $store_result = $photo->store('photo');
            }
        $data = Good::create([
            'good_name'=>$good_name,
            'good_price'=>$good_price,
            'photo'=>'/storage/'.$store_result,
        ]);
        if($data)
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
