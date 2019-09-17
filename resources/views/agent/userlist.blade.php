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
    <h2>用户列表</h2>
    <table  border="1">
            <tr>
                <td>uid</td>
                <td>用户名</td>
                <td>分享码</td>
                <td>二维码</td>
                <td>操作</td>
            </tr>
            @foreach ($info as $v)
            <tr>
                <td>{{$v->user_id}}</td>
                <td>{{$v->useremail}}</td>
                <td>{{$v->user_id}}</td>
                <td><img src="{{$v->qrcode_url}}" alt="" height="120"> </td>
                <td><a href="{{url('wechat/create_qrcode')}}?uid={{$v->user_id}}">生成专属二维码</a> </td>
            </tr>
            @endforeach
    </table>
</center>
</body>
</html>
