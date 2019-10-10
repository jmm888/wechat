@extends('layouts.admin')
@section('title', 'LARAVEL')
@section('content')
    <h3>编辑页面</h3>

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
        <input type="button" class="btn btn-info" id="sub" value="编辑">
    </div>
    <script>
        function getQueryString(name){
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)return  unescape(r[2]); return null;
        }
        var id = getQueryString("id");
        $.ajax({
            url:'http://www.jmm_wxlaravel.com/api/test/find',
            data:{id:id},
            dataType:'json',
            success:function(res){
                var name = $('[name="name"]').val(res.data.test_name);
                var age = $('[name="age"]').val(res.data.test_age);
            }
        });
        $('#sub').click(function(){
           var name = $('[name="name"]').val();
            var age = $('[name="age"]').val();
            $.ajax({
                url:'http://www.jmm_wxlaravel.com/api/test/upl',
                data:{name:name,age:age,id:id},
                dataType:'json',
                success:function(res)
                {
                    if(res.ret==1){
                        alert(res.msg);
                        location.href = 'http://www.jmm_wxlaravel.com/test/show';
                    }
                }
            });
        })
    </script>
@endsection


