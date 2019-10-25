<?php

namespace App\Http\Controllers\admins;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Model\Type;
use App\Model\Attribute;
use App\Model\Apigoods;
use App\Model\Goodsattr;
use App\Model\Product;
use App\Model\Login;
use App\Model\Cart;
class AdminController extends Controller
{
    //10.25接口调用
    public function sign(Request $request)
    {
        $name = $request->input('name');
        $age = $request->input('age');
        $sign = $request->input('sign');
        if(empty($name) ||empty($age))
        {
            return json_encode(['ret'=>201,'msg'=>'参数不能为空']);
        }
        if(empty($sign))
        {
            return json_encode(['ret'=>202,'msg'=>'sign不能为空']);
        }
        $mysign = md5("1902A".$name.$age);
        if($mysign != $sign)
        {
            return json_encode(['ret'=>203,'msg'=>'sign不对']);
        }
    }
    //新品查询展示
    public function news()
    {
        $data = Apigoods::orderBy('goods_id','DESC')->limit(4)->get()->toArray();

        foreach($data as $k=>$v)
        {
            $path ='/storage/goods_img/b0m9WR2RPr2nJ8MuUYn3dSqOI0fbVKaLs0nar33N.jpeg';
            if(!empty($data[$k]['goods_img']))
            {
                $data[$k]['goods_img']= env('HOST_URL').$v['goods_img'];
            }else{
                $data[$k]['goods_img']  = env('HOST_URL').$path;
            }
        }
        return json_encode(['ret'=>1,'msg'=>'xxx','data'=>$data]);
    }
    /*
     * 新品详情展示
     * */
    public function detail(Request $request)
    {
        //接受前台传过来的id  根据id查询商品详情  和商品属性关系表
        $goods_id = $request->input('goods_id');
        //查询商品详情
        $goodsData  = Apigoods::where(['apigoods.goods_id'=>$goods_id])->first()->toarray();
        $goodsData['goods_img'] = env('HOST_URL').$goodsData['goods_img'];
        //根据商品id查询商品属性关系表
        $goodsattrData = Goodsattr::join('attribute','attribute.attr_id','=','goodsattr.attr_id')->where(['goods_id'=>$goods_id])->get()->toArray();
        $array = [];//可选规格数组
        $argsData = [];//普通展示属性
        foreach($goodsattrData as $k=>$v)
        {
            if($v['is_opt']==1)
            {
                //可选规格
                $status = $v['attr_name'];
                $array[$status][] = $v;
            }else{
                $argsData[] = $v;
            }
        }
        return json_encode(['ret'=>1,'msg'=>'查询成功',
            'goodsData'=>$goodsData,
            'data'=>$array,
            'argsData'=>$argsData,
            ]);
    }
    /*
    * 商品列表查询
    * */
    public function listing()
    {
        $data = Apigoods::get()->toArray();
        foreach($data as $k=>$v)
        {
            $data[$k]['goods_img']= env('HOST_URL').$v['goods_img'];
        }
       return json_encode(['ret'=>1,'msg'=>'查询成功','data'=>$data]);
    }
    //商品分类查询
    public function cate(Request $request)
    {
        $id = $request->input('id');
        if(isset($id))
        {
            $data = Apigoods::where(['cate_id'=>$id])->get()->toArray();
            foreach($data as $k=>$v)
            {
                $data[$k]['goods_img']= env('HOST_URL').$v['goods_img'];
            }
            return json_encode(['data'=>$data]);
        }
        $cateData = Category::get()->toArray();
        return json_encode(['ret'=>1,'msg'=>'分类查询成功','cateData'=>$cateData]);
    }
    /*
     * 加入购物车
     * */
    public function shopping(Request $request)
    {
        $userData = $request->get('userData');//中间件产生的参数
        //接收数据
        $goods_id = $request->input('goods_id');//接受商品id
        $attr_id = implode(',',$request->input('attrid')) ;//接受属性id
        $user_id = $userData['login_id'];//用户id
        $buy_number = 1;//购买数量
        //判断库存量
		//利用goods_id 属性id组合查询货品表 库存
        $productData = Product::where(['goods_id'=>$goods_id,'value_list'=>$attr_id])->first();
        $product_num = $productData['product_num'];//商品的库存量
        //判断购买的数量是否大于商品的库存量
        if($buy_number >= $product_num)
        {
            //没货
            $is_have_num = 0;
        }else{
            //有货
            $is_have_num = 1;
        }
        //判断加入购物车商品 是否已存在？？
        $cartData = Cart::where(['goods_id'=>$goods_id,'user_id'=>$user_id,'goods_attr_id'=>$attr_id])->first();
        if(!empty($cartData))
        {
            //如果存在 修改数据 =》 数量+1
            $cartData->buy_number = $cartData->buy_number+$buy_number;
            $cartData->save();
        }else{
            //如果数据不存在 添加数据
            $res = Cart::create([
                'goods_id'=>$goods_id,
                'user_id'=>$user_id,
                'goods_attr_id'=>$attr_id,
                'product_id'=>$productData['product_id'],
                'buy_number'=>$buy_number,
                'is_have_num'=>$is_have_num,
            ]);
        }
        return json_encode(['ret'=>1,'msg'=>'成功']);
    }
    /*
     * 购物车列表
     * */
    public function cart_list(Request $request)
    {
        //查询商品信息和 商品属性信息
        //调用中间件 判断token是否有效 从中获取user_id
        $userData = $request->get('userData')->toArray();
        //获取用户id
        $user_id = $userData['login_id'];
        //根据用户id查询购物车和商品表
        $cartData = Cart::join('apigoods','apigoods.goods_id','=','cart.goods_id')->where(['user_id'=>$user_id])->get()->toArray();
        foreach($cartData as $key=>$val)
        {
            $cartData[$key]['goods_img']= env('HOST_URL').$val['goods_img'];//给图片加路径
            //根据属性id查询 属性表
            $goods_attr_list = explode(',',$val['goods_attr_id']);
            $attrData = Goodsattr::join('attribute','attribute.attr_id','=','goodsattr.attr_id')->whereIn('goodsattr_id',$goods_attr_list)->get()->toArray();
           //dd($cartData);
            //组装字符串
            $attr_show_list = '';//颜色：  内存。。
            $count_price = $val['goods_price'];//商品基本价格
            //商品基本价格 + 商品每个属性的价格
            foreach($attrData as $k=>$v)
            {
                $attr_show_list .= $v['attr_name'].":".$v['attr_value_list'].",";
                //价格的计算加上每个属性的价格
                $count_price += $v['attr_price_list'];
            }
            //重新给元素赋值
            $cartData[$key]['attr_show_list'] = rtrim($attr_show_list,",");
            $cartData[$key]['goods_price'] = $count_price;
        }
        //dd($cartData);
        return json_encode(['ret'=>1,'msg'=>'查询成功','cartData'=>$cartData]);
    }
}
