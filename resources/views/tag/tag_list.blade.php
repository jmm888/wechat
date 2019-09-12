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
    <h1>公众标签管理</h1>
    <a href="{{url('wechat/tag_add')}}">添加标签</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{url('wechat/get_user_list')}}">粉丝列表</a>
    <table border="1">
        <tr>
            <td>tag_id</td>
            <td>tag_name</td>
            <td>标签 粉丝数</td>
            <td>操作</td>
        </tr>
        @foreach ($info as $v)
        <tr>
            <td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <td>{{$v['count']}}</td>
            <td><a href="">删除</a> <a href="">编辑</a>
                <a href="{{url('wechat/tag_openid_list')}}?tagid={{$v['id']}}">粉丝列表</a>
                <a href="{{url('wechat/get_user_list')}}?tagid={{$v['id']}}">粉丝打标签</a>
                <a href="{{url('wechat/push_tag_message')}}?tagid={{$v['id']}}">推送消息</a>
            </td>
        </tr>
        @endforeach
    </table>
</center>
</body>
</html>
