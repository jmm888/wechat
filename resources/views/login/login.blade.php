<!DOCTYPE html>
<html>

<head>
    <base href="/">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <link rel="shortcut icon" href="favicon.ico"> <link href="css/bootstrap.min.css?v=3.3.6" rel="stylesheet">
    <link href="css/font-awesome.css?v=4.4.0" rel="stylesheet">

    <link href="css/animate.css" rel="stylesheet">
    <link href="css/style.css?v=4.1.0" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>

            <h1 class="logo-name">h</h1>

        </div>
        <h3>欢迎使用 hAdmin</h3>

        <form class="m-t" role="form" action="admin/login_do" method="post">
            @csrf
            <div class="form-group">
                <input type="text" class="form-control" name="username" placeholder="用户名" required="">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" name="pwd" placeholder="密码" required="">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" name="code" placeholder="点击获取验证码" required="">
                <input type="button" class="send" value="点击获取验证码">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>
           <h4>扫描进行绑定账号</h4>
            <img src="{{asset('/hadmin/0 (1).jpg')}}" alt="" height="200" width="200">
            <p class="text-muted text-center"> <a href="login.html#"><small>忘记密码了？</small></a> | <a href="register.html">注册一个新账号</a>
            </p>

        </form>
    </div>
</div>
<!-- 全局js -->
<script src="js/jquery.min.js?v=2.1.4"></script>
<script src="js/bootstrap.min.js?v=3.3.6"></script>
</body>
</html>
<script src="js/jq.js"></script>
<script>
    //点击获取验证码
    $('.send').click(function(){
        //获取用户名
        var name = $('[name="username"]').val();
        //获取密码
        var pwd = $('[name="pwd"]').val();
        $.ajax({
            url:"{{url('admin/send')}}",
            data:{username:name,pwd:pwd},
        })
    })
</script>
