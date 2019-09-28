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
    <h2>创建菜单</h2>
    <form action="{{url('wechat/menu_create')}}" method="post">
        @csrf
        一级菜单名称: <input type="text" name="name1"><br /><br />
        二级菜单名称: <input type="text" name="name2"><br /><br />
        菜单类型[click/view/pic_weixin]:
        <select name="type" id="">
            <option value="1">click</option>
            <option value="2">view</option>
            <opeion value="3">pic_weixin</opeion>
        </select><br/><br />
        事件值: <input type="text" name="event_value"><br /><br />
        <input type="submit" value="提交">
    </form>
    <h2>菜单列表</h2>
    <table border="1">
        <tr>
            <th>一级菜单名称</th>
            <th>二级菜单名称</th>
            <th>菜单类型</th>
            <th>事件值</th>
            <th>操作</th>
        </tr>
        @foreach ($info as $v)
        <tr>
            <td>{{$v->name1}}</td>
            <td>{{$v->name2}}</td>
            <td>@if($v->type==1)click @elseif($v->type==2) view @else pic_weixin @endif</td>
            <td>{{$v->event_value}}</td>
            <td><a href="{{url('wechat/menu_del')}}?id={{$v->id}}">删除</a> </td>
        </tr>
            @endforeach
    </table>
</center>
</body>
</html>
