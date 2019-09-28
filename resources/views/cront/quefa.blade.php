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
    <h3>群发消息</h3>
    <form action="{{url('wechat/quefa_do')}}" method="post">
        @csrf
        <input type="hidden" value="{{$tagid}}" name="tagid">
        <textarea name="message" id="" cols="30" rows="10"></textarea><br />
        <input type="submit" value="进行群发消息">
    </form>
</center>
</body>
</html>
