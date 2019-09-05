<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="{{url('team/comp_do/'.$data->team_id)}}" method="post">
    @csrf
    <h3>我要竞猜</h3>
    {{$data->team_one}} VS  {{$data->team_two}}<br />
    <input type="radio" name="cai" value="1">胜
    <input type="radio" name="cai" value="2">平
    <input type="radio" name="cai" value="3">负 <br />
    <input type="submit" value="Submit">
    </form>
</body>
</html>