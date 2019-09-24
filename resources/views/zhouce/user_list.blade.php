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
    <h2>留言</h2>
    <form action="{{url('zhouce/message')}}" method="post">
        @csrf
    <table border="1">
        <input type="submit" value="提交">
        <tr>
            <th>请勾选要留言的用户名</th>
            <th>OPENID</th>
        </tr>
        @foreach ($info as $k=>$v)
        <tr>
            <td><input type="checkbox" value="{{$v->openid}}" name="openid">{{$v->nickname}}</td>
            <td>{{$v->openid}}</td>
        </tr>
        @endforeach
    </table>
    </form>
</center>
</body>
</html>
