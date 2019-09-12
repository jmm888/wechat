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
    <h2>标签群发消息</h2>
        <form action="{{url('wechat/do_push_tag_message')}}" method="post">
            <input type="hidden" name="tagid" value="{{$tagid}}">
            @csrf
            消息：
            <textarea name="message" id="" cols="30" rows="10"></textarea>
            <input type="submit" value="提交">
        </form>
    </center>
</body>
</html>
