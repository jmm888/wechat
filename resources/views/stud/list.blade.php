<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>列表展示</h3>
    <table border="1">
        <tr>
            <td>编号</td>
            <td>姓名</td>
            <td>年龄</td>
            <td>地址</td>
            <td>操作</td>
        </tr>
        @foreach ($data as $v)
        <tr>
            <td>{{$v->stu_id}}</td>
            <td>{{$v->stu_name}}</td>
            <td>{{$v->stu_age}}</td>
            <td>@if($v->stu_address==1)北京市,昌平区 @else 北京市,房山区 @endif</td>
            <td><a href="{{url('stud/upl/'.$v->stu_id)}}">修改</a>
            <a href="{{url('stud/del/'.$v->stu_id)}}">删除</a> </td>
        </tr>
        @endforeach
    </table>
    <button>点击显示离校生</button>
</body>
</html> -->



<a href="javascript:;" class="show">显示离校学生</a>
<table align="center" width="700" border="1" class="a"> 
    <tr align="center">
        <td>ID</td>
        <td>姓名</td>
        <td>年龄</td>
        <td>住址</td>
        <td>学生状态</td>
        <td>操作</td>
    </tr>
    @foreach($data as $v)
    <tr align="center">
        <td>{{$v->stu_id}}</td>
        <td>{{$v->stu_name}}</td>
        <td>{{$v->stu_age}}</td>
        <td>@if($v->stu_address==1)北京市,昌平区 @else 北京市,房山区 @endif</td>
        <td>@if($v->status==1)在校 @else离校 @endif</td>
        <td><a href="{{url('stud/upl/'.$v->stu_id)}}">修改</a>
            <a href="{{url('stud/del/'.$v->stu_id)}}">删除</a> </td>
    </tr>
    @endforeach
</table>
<table align="center" width="700" border="1" class="b" style="display:none;"> 
    <tr align="center">
        <td>ID</td>
        <td>姓名</td>
        <td>年龄</td>
        <td>住址</td>
        <td>学生状态</td>
        <td>操作</td>
    </tr>
    @foreach($datas as $v)
    <tr align="center">
        <td>{{$v->stu_id}}</td>
        <td>{{$v->stu_name}}</td>
        <td>{{$v->stu_age}}</td>
        <td>@if($v->stu_address==1)北京市,昌平区 @else 北京市,房山区 @endif</td>
        <td>@if($v->status==1)在校 @else离校 @endif</td>
        <td></td>
    </tr>
    @endforeach
</table>


<script type="text/javascript" src="/js/shop/jquery.min.js"></script>
<script type="text/javascript">
    
    $('.show').click(function() {
        // alert(1)
        var a = $(this).text();
        if (a=='显示离校学生') {
            $(this).text('显示在校学生');
            $('.a').hide();
            $('.b').show();
        }else{
            $(this).text('显示离校学生');
            $('.b').hide();
            $('.a').show();
        }
    });
</script>