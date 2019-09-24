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
    <h3>添加标签</h3>
    <form action="{{url('wechat/add_do')}}" method="post">
        @csrf
        标签名称：<input type="text" name="cront_name"><br />
        <input type="submit" value="添加标签">
    </form>
</center>
</body>
</html>
