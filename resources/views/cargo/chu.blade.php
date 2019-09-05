<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{url('cargo/chu_do/'.$data->cargo_id)}}" method="post">
@csrf
    <h3>出库</h3>
        <h4>出库名称:{{$data->cargo_name}}</h4>
        <h4>出库图片:<img src="{{env('UPLOAD_URL')}}{{$data->cargo_img}}" width="80" height="80"></h4>
        <h4>出库货物库存:{{$data->cargo_num}}</h4>
        <h4>请输入要出库的数量</h4>
        <input type="text" name="cargo_num_chu"><br />
        <input type="submit" value="SUBMIT">
</form>
</body>
</html>