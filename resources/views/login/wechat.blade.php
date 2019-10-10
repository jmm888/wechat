@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>扫描进行扫码登录</h3>
    <img src="http://qr.liantu.com/api.php?text={{$redirect_url}}"/>
    <script>
        //每隔几秒
        var t =setInterval("check();",2000);
        //settimeout
        var id = {$id};
        function check()
        {
            //js查询
            $.ajax({
                url:"{{url('admin/checkwechatlogin')}}",
                dataType:'json',
                data:{id:id},
                success:function(res)
                {
                    //返回提示
                    if(res.ret==1){
                        //关闭定时器
                        clearInterval(t);
                        //扫码登陆成功
                        alert(res.msg);
                        location.href = "{{url('admin/index')}}";
                    }
                }
            })
        }
    </script>
@endsection


