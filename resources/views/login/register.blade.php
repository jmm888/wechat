@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>注册</h3>
    <form action="" method="post">
        <div style="margin-top: 50px" >
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">用户名</label>
                <input type="text" class="form-control"  name="username" id="exampleInputEmail1" placeholder="用户名">
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Password</label>
                <input type="password" class="form-control" name="pwd" id="exampleInputPassword1" placeholder="Password">
            </div>
            <input type="button" class="btn btn-info" value="注册"></input>
        </div>
    </form>
    <script src="/js/jq.js"></script>
    <script>
        $(".btn").click(function(){
            var username = $('[name="username"]').val();
            var pwd = $('[name="pwd"]').val();
            var url = "http://www.jmm_wxlaravel.com/api/register";
            $.ajax({
                url:url,
                data:{username:username,pwd:pwd},
                dataType:"json",
                success:function(res){
                    if(res.ret==1)
                    {
                        alert(res.msg);
                        location.href= "http://www.jmm_wxlaravel.com/api/login";
                    }
                }
            })
        })

    </script>
@endsection



