<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>竞猜结果</h3>
    <h4>对阵结果：{{$data->team_one}} VS {{$data->team_two}}</h4>
    <h4>您的竞猜: {{$data->team_one}} VS {{$data->team_two}}</h4>
    <h4>结果：@if($data->cai == $data->guo) 恭喜您 猜中了
        @else 很抱歉，没猜中
        @endif 
    
    </h4>
</body>
</html>