<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>详情页</h3>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>货物名称</th>
            <th>货物图片</th>
            <th>货物数量</th>
            <th>操作</th>
        </tr>
        @foreach ($data as $v)
        <tr>
            <td>{{$v->cargo_id}}</td>
            <td>{{$v->cargo_name}}</td>
            <td><img src="{{env('UPLOAD_URL')}}{{$v->cargo_img}}" width="80" height="80"></td>
            <td>{{$v->cargo_num}}</td>
            <td>    <a href="{{url('cargo/rizhi/'.$v->cargo_id)}}">查看日志</a>
                    <a href="{{url('cargo/chu/'.$v->cargo_id)}}">出库</a>
                    <a href="{{url('cargo/jilu/'.$v->cargo_id)}}">出入库记录</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>