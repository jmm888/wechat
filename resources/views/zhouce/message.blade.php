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
        <form action="{{url('zhouce/message_do')}}" method="post">
        <h2>留言</h2>
            <input type="hidden" name="openid" value="{{$openid}}">
        留言：<textarea name="menu" id="" cols="30" rows="10"></textarea><br />
        <input type="submit" value="提交">
        </form>
    </center>
</body>
</html>
