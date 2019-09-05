<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>展示</h2>
    <table border="1"> 
        <tr>
            <th>序号</th>
            <th>昵称</th>
            <th>微信号</th>
            <th>操作</th>
        </tr>
        @foreach ($info as $k=>$v)
        <tr>
            <td>{{$k}}</td>
            <td>{{$v['nickname']}}</td>
            <td>{{$v['openid']}}</td>
            <td><a href="{{url('wechat/add_msg/'.$v['openid'])}}">详细信息</a></td>
        </tr>
        @endforeach
    </table>
</body>
</html>