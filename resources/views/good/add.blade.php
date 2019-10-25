@extends('layouts.admin')
@section('title', '商品添加')
@section('content')
    <h3>添加页面</h3>

    <div style="margin-top: 50px" >
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">商品名称</label>
            <input type="text" class="form-control"  name="good_name" id="exampleInputEmail1" placeholder="商品名称">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">价格</label>
            <input type="age" class="form-control" name="good_price" id="exampleInputPassword1" placeholder="price">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">图片</label>
            <input type="file" class="form-control" name="photo" id="exampleInputPassword1" placeholder="请选择要上传的图片">
        </div>
        <input type="button" class="btn btn-info" id="sub" value="添加">
    </div>
    <script>
        $("#sub").click(function(){
            var good_name = $('[name="good_name"]').val();
            var good_price = $('[name="good_price"]').val();
            var fd = new FormData();
            fd.append("good_name",good_name);
            fd.append("good_price",good_price);
            var file = $('[name="photo"]')[0].files[0];
            fd.append("photo",file);
            var url = "http://www.jmm_wxlaravel.com/api/test";
            $.ajax({
                url:url,
                data:fd,
                dataType:"json",
                type:"POST",
                contentType:false,   //post数据类型  unlencode
                processData:false,   //处理数据
                success:function(res){
                    if(res.ret == 1){
                        alert(res.msg);
                        location.href = "http://www.jmm_wxlaravel.com/good/index";
                    }else{
                        alert("异常");
                    }
                }
            });
        })
    </script>
@endsection


