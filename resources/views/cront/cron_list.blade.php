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
        <h3>标签管理</h3>
        <a href="{{url('wechat/user_list')}}">粉丝列表</a>
        <a href="{{url('wechat/cront_add')}}">添加标签</a>
        <form action="">
            <table border="1">
                <tr>
                    <th>ID</th>
                    <th>NAME</th>
                    <th>NUMBER</th>
                    <th>操作</th>
                </tr>
                @foreach ($info as $v)
                <tr>
                    <td>{{$v['id']}}</td>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['count']}}</td>
                    <td>
                        <a href="{{url('wechat/quefa')}}?tagid={{$v['id']}}">通过标签 给用户群发消息</a>||
                        <a href="{{url('wechat/user_list')}}?tagid={{$v['id']}}">给用户打标签</a>
                    </td>
                </tr>
                @endforeach
            </table>
        </form>
    </center>
</body>
</html>
