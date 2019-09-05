<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>日志</h3>
    <h4>操作用户:{{$res['user_id']}}</h4>
    <h4>操作货物:{{$data->cargo_name}}</h4>
    <h4>操作类型:入库 
    时间:{{date("Y-m-d H:i:s",$data->add_time)}}</h4>
    <h4>操作类型:出库 
    时间:{{date("Y-m-d H:i:s",$data->chu_time)}}</h4>

</body>
</html>