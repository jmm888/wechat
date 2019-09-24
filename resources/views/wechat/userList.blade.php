<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<center>
    <h3>粉丝列表</h3>
    <form action="{{url('wechat/tag_openid')}}" method="post">
        @csrf
        <input type="submit" value="提交">
        <table border="1">
            <tr>
                <th></th>
                <th>序号</th>
                <th>昵称</th>
                <th>微信号</th>
                <th>操作</th>
            </tr>
            @foreach ($info as $k=>$v)
                <tr>
                    <input type="hidden" value="{{$tagid}}" name="tagid">
                    <td><input type="checkbox" name="openid_list[]" value="{{$v['openid']}}"></td>
                    <td>{{$k}}</td>
                    <td>{{$v['nickname']}}</td>
                    <td>{{$v['openid']}}</td>
                    <td><a href="{{url('wechat/add_msg/'.$v['openid'])}}">详细信息</a>||
                        <a href="{{url('wechat/uses_tag_list')}}?openid={{$v['openid']}}">用户标签</a>
                    </td>
                </tr>
            @endforeach
        </table>
    </form>
</center>
</body>
</html>
