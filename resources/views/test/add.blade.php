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
            <input type="button" class="btn btn-info" id="sub" value="添加">
        </div>

    <script>
        $('#sub').click(function(){
            var name = $('[name="name"]').val();
                var age = $('[name="age"]').val();
               $.ajax({
                  url:'http://www.jmm_wxlaravel.com/api/test/add',
                  data:{name:name,age:age},
                  dataType:'json',
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


