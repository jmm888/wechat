<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="">
    <input type="text" name="name" placeholder="请输入搜索的姓名">
    <input type="text" name="age" placeholder="请输入搜索的姓名">
    <button>搜索</button>
    </form>
    <table border="1" width="500" height="500">
        <tr>
            <th>id</th>
            <th>姓名</th>
            <th>年龄</th>
            <th>性别</th>
            <th>图片</th>
            <th>操作</th>
        </tr>
        @foreach ($data as $v)
        <tr>
            <td>{{$v->stu_id}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->age}}</td>
            <td>@if($v->sex==1)女 @else 男 @endif</td>
            <td><img src="http://www.jmm_laupload.com/{{$v->headimg}}" width="180" heigth="180"></td>
            <td><a href="{{url('student/edit/'.$v->stu_id)}}">编辑</a>
                <a href="{{url('student/del/'.$v->stu_id)}}">删除</a>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $data->appends(['name'=>$name,'age'=>$age])->links() }}
</body>
</html>