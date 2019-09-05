<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>出入库记录</h3>
    <table border="1">
        <tr>
            <td>用户ID:</td>
            <td>{{$res['user_id']}}</td>
        </tr>
        <tr>
            <td>货物ID:</td>
            <td>{{$data->cargo_id}}</td>
        </tr>    
         <tr>
            <td>操作入库时间：</td>
            <td>{{date("Y-m-d H:i:s",$data->add_time)}}</td>
        </tr>     
        <tr>
            <td>操作出库时间</td>
            <td>{{date("Y-m-d H:i:s",$data->chu_time)}}</td>
        </tr>        
    </table>
</body>
</html>