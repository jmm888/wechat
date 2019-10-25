@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>添加页面</h3>

    <div style="margin-top: 50px" >
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">用户名</label>
            <input type="text" class="form-control"  name="name" id="exampleInputEmail1" placeholder="用户名">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">年龄</label>
            <input type="age" class="form-control" name="age" id="exampleInputPassword1" placeholder="Password">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">图片</label>
            <input type="file" class="form-control" name="photo" id="exampleInputPassword1" placeholder="请选择要上传的图片">
        </div>
        <input type="button" class="btn btn-info" id="sub" value="添加">
    </div>

    <script>
        var url = 'http://www.jmm_wxlaravel.com/api/usr';
        $('#sub').click(function(){
            var name = $('[name="name"]').val();
            var age = $('[name="age"]').val();
            var fd = new FormData();
            fd.append("name",name);
            fd.append("age",age);
            var file = $('[name="photo"]')[0].files[0];//获取到文件
            fd.append('file',file);//往表单里添加字段
            $.ajax({
                url:url,
                type:'POST',
                data:fd,
                dataType:'json',
                contentType:false,   //post数据类型  unlencode
                processData:false,   //处理数据
                success:function(res){
                    if(res.ret==1){
                        alert('添加成功');
                        location.href = 'http://www.jmm_wxlaravel.com/test/show';
                    }else{
                        alert('异常');
                    }
                }
            });
        })
    </script>
@endsection


