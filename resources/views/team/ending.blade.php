<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form action="" >
   
    <h3>比赛结果</h3>
    {{$data->team_one}} VS  {{$data->team_two}}<br />
    <input type="radio" name="guo" value="1" @if($data->guo==1) checked @endif>胜
    <input type="radio" name="guo" value="2" @if($data->guo==2) checked @endif>平
    <input type="radio" name="guo" value="3" @if($data->guo==3) checked @endif>负 <br />
    </form>

    
</body>
</html>