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
class IndexController extends Controller
{
    //后台首页
    public function index()
    {
        return view('hadmin/index');
    }
    //后台模块添加
    public function category_add()
    {
        return view('hadmin/category_add');
    }
    //后台模块添加接口
    public function cate_do(Request $request)
    {
        $res = $request->all();
        $data = Category::create([
            'category_name'=>$res['category_name'],
            'is_sort'=>$res['is_sort'],
            'is_show'=>$res['is_show'],
        ]);
        if($data)
        {
            return redirect("admin/category_list");
        }else{
            dd("异常");
        }
    }
    //分类添加唯一性验证
    public function Only()
    {
        $name = Request()->name;
        $res = Category::where(['category_name'=>$name])->count();
        if($res > 0 ){
            return json_encode(['ret'=>1,'msg'=>'分类名称已存在']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'可添加']);
        }
    }
    //模块列表
    public function category_list()
    {
        $data = Category::get();
        return view('hadmin/category_list',['data'=>$data]);
    }
    //类型添加
    public function type_add()
    {
        return view('hadmin/type_add');
    }
    //类型添加执行页面
    public function type_do()
    {
        $res = Request()->all();
        $data = Type::create([
            'type_name'=>$res['type_name'],
        ]);
        if($data)
        {
            return redirect("admin/type_list");
        }else{
            dd("异常");
        }
    }
    //类型列表
    public function type_list()
    {
       $data = Type::get()->toArray();
       foreach($data as $k=>$v)
       {
           //查询类型下的属性数
           $attr_num = Attribute::where(['type_id'=>$v['type_id']])->count();
           $data[$k]['attr_num'] = $attr_num;
       }
        return view('hadmin/type_list',['data'=>$data]);
    }
    //属性添加
    public function attribute_add()
    {
        $data = Type::get();
        return view("hadmin/attribute_add",['data'=>$data]);
    }
    //属性执行添加
    public function attr_do()
    {
        $res= Request()->all();
        $data = Attribute::create([
            'attr_name'=>$res['attr_name'],
            'type_id'=>$res['type_id'],
            'is_opt'=>$res['is_opt'],
        ]);
        if($data)
        {
            return redirect("admin/attribute_list");
        }else{
            dd("异常");
        }
    }
    //属性列表
    public function attribute_list()
    {
        //获取属性表的类型数据
        $typeData = Type::get()->toarray();
        //根据类型模块传过来的ID进行查询类型下的属性
        $id = Request('id');
        $where = [];
        if(!empty($id))
        {
            //查询属性表的ID数据等于 传过来的类型表的主键ID
            $where = ['attribute.type_id'=>$id];
        }
        //接受根据类型搜索传过来的name
        $name = Request()->input('name');
        if(!empty($name))
        {
            //查询属性表的ID 等于传过来的类型的主键ID
            $where = ['attribute.type_id'=>$name];
            //根据where条件进行两表查询
            $data = Attribute::where($where)->join('type','type.type_id','=','attribute.type_id')->get();
            return json_encode($data);
        }
        $data = Attribute::where($where)->join('type','type.type_id','=','attribute.type_id')->get();
        return view("hadmin/attribute_list",['data'=>$data,'typeData'=>$typeData]);
    }
    /*
     * 属性列表批量删除
     * */
    public function del(Request $request)
    {
        $id = $request->id;
        foreach($id as $v)
        {
            $res = Attribute::where('attr_id','=',$v)->delete();
        }

        if($res){
            return json_encode(['ret'=>1,'msg'=>'删除成功']);
        }else{
            return json_encode(['ret'=>0,'msg'=>'删除失败']);
        }
    }
    //根据类型获取属性
    public function attrData()
    {
        $type_id = Request()->input('type_id');
        $attrData = Attribute::where(['type_id'=>$type_id])->get();
        return json_encode($attrData);
    }

    //类型到属性跳转
    public function attr_list()
    {
        $id = Request('id');
        $res = Attribute::where('type_id','=',$id)->get();
        return view('hadmin/attr_list',['data'=>$res]);
    }
    //商品添加页面
    public function comm_add()
    {
        //查询分类数据
        $cateData = Category::get()->toarray();
        //查询所有类型
        $typeData = Type::get()->toarray();
        return view('hadmin/comm_add',[
            'cateData'=>$cateData,
            'typeData'=>$typeData
        ]);
    }

     //商品添加执行页面
     public function add(Request $request)
     {
        $postData = $request->input();
        //文件上传
        if ($request->hasFile('goods_img') && $request->file('goods_img')->isValid()) {
            $photo = $request->file('goods_img');
            $extension = $photo->extension();
            $store_result = $photo->store('goods_img');
        }
        //1.商品基本信息入库
        $goodsModel = Apigoods::create([
            'goods_name'=>$postData['goods_name'],
            'cate_id'=>$postData['cate_id'],
            'goods_sn'=>$postData['goods_sn'],
            'goods_price'=>$postData['goods_price'],
            'goods_desc'=>$postData['goods_desc'],
            'type_id'=>$postData['type_id'],
            'goods_img'=>'/storage/'.$store_result,
        ]);
        //获取商品主键ID
        $goods_id = $goodsModel->goods_id;
        //2.商品属性信息入库 商品属性关系表
        $inserData = [];//定义要添加的数据
        foreach($postData['attr_value_list'] as $k=>$v)
        {
            $insertData[] = [
                'goods_id'=>$goods_id,
                'attr_id'=>$postData['attr_id_list'][$k],
                'attr_value_list'=>$v,
                'attr_price_list'=>$postData['attr_price_list'][$k],
            ];
        }
        //批量入库
        $res = Goodsattr::insert($insertData);
        if(!empty($res)){
            return redirect("admin/goods?goods_id=".$goods_id);//跳转至货品添加页
        }
    }
    /*
     * 商品展示页面
     * */
    public function comm_list(Request $request)
    {
        $cateData = Category::get();
        $cate_id  = $request->input('cate_id');
        $name = $request->input('name');
        $where = [];
        if(isset($cate_id))
        {
            $where[] = ['category.cate_id','=',$cate_id];
        }
        if(isset($name)){
            $where[] = ['goods_name','like',"%$name%"];
        }
        $data = Apigoods::join('category','category.cate_id','=','apigoods.cate_id')->join('type','type.type_id','=','apigoods.type_id')->where($where)->get();
        return view('hadmin/comm_list',['data'=>$data,'name'=>$name,'cateData'=>$cateData,'cate_id'=>$cate_id]);
    }
    /*
     * 商品名即点击该
     * */
    public function clickhere(Request $request)
    {
//        $id = $request->id;
//        $val = $request->val;
        $res = $request->input();
        $data = Apigoods::where(['goods_id'=>$res['id']])->update(['goods_name'=>$res['val']]);

    }
    //货品添加页
    public function goods()
    {
        //查询商品表
        $goods_id = Request()->input('goods_id');
        //根据商品id查询商品基本信息
        $goodsData  = Apigoods::where(['goods_id'=>$goods_id])->first();
        //根据商品id 查询商品属性关联表(属性值)
        $goodsattrData = Goodsattr::join('attribute','attribute.attr_id','=','goodsattr.attr_id')->where(['goods_id'=>$goods_id,'is_opt'=>1])->get()->toarray();
        $array = [];
        foreach($goodsattrData as $k=>$v)
        {
            $status = $v['attr_name'];
            $array[$status][] = $v;
        }
        // echo "<pre>";
        //var_dump($array);
        return view("hadmin/goods",['data'=>$array,'goodsData'=>$goodsData]);
    }
    /*
     * 货品添加执行页面
     * */
    public function product_do(Request $request)
    {
        //接受货品表传过来的所有数据
        $postData = $request->input();
        //属性值处理数据
        $size = count($postData['goods_attr']) / count($postData['product_number']);
        //把数组分割
        $goodsAttr =array_chunk($postData['goods_attr'],$size);
        //循环入库
        foreach($goodsAttr as $k=>$v)
        {
           $res =  Product::create([
                'goods_id'=>$postData['goods_id'],
                'value_list'=>implode(",",$v),
                'product_num'=>$postData['product_number'][$k],
            ]);
        }
        if($res)
        {
            return redirect("admin/comm_list");//跳转至商品展示页
        }
    }
}
