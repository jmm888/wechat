<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<center>
    <h3>周测登录</h3>
    <form action="">
        用户名：<input type="text"><br />
        密码：<input type="password"><br />
        <input type="submit" value="提交" class=""stu>
    </form>
</center>
</body>
</html>
<script src="/js/app.js"></script>
<script>
    $(function(){
        $('.stu').click(function(){
            window.location.href="{{url('wechat/login')}}";
        })
    })
</script>
