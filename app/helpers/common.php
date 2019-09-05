<?php
//文件上传方法
function upload($name)
 {
     if ( request()->file($name)->isValid()) {
         $photo = request()->file($name);
         //$extension = $photo->extension();
         //$store_result = $photo->store('photo');
         $store_result = $photo->store('', 'public');
         
         return $store_result;
         }
         exit('未获取到上传文件或上传过程出错');
 }
//无限极分类方法
function createtree($data,$parent_id=0,$level=1){
    //定义一个静态新数组
    static $new_arr=[];
    //2.遍历数据一条条显示 
    foreach($data as $k=>$v){
        //3判断parent_id==0
        if($v->parent_id==$parent_id){
            //添加level字段用来区分级别
            $v->level=$level;
            //4.找到之后放到新数组里
            $new_arr[]=$v;
            //调用程序自身找子集
            createtree($data,$v->cat_id,$level+1);
        }
    }
    return $new_arr;
}