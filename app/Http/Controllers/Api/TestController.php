<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Support\Facades\Cache;
class TestController extends Controller
{
    //测试天气
    public function weather(Request $request)
    {
        $city = $request->input('city');
         if(!isset($city))
         {
             $city = "北京";
         }
        //有缓存 读缓存
        $cache_key = "weather_data_".$city;
        $data = Cache::get($cache_key);
        if(empty($data))
        {
            //没有缓存 调用k7800 存入缓存
            echo "调用";
            $url = "http://api.k780.com:88/?app=weather.future&weaid={$city}&&appkey=10003&sign=b59bc3ef6191eb9f747dd4e83c99f2a4&format=json";
            $data = file_get_contents($url);
            //获取当前的时间
            $date = date("Y-m-d");
            $time64 =strtotime($date)+86400;// 把格式化的时间转化为时间戳
            //获取当前时间
            $cacha_time = $time64 - time();
            Cache::put($cache_key,$data,$cacha_time);
            //只缓存到凌晨
        }
       return $data;
    }

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
    public function addww(Request $request)
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
