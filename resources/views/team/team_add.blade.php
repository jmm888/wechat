<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{route('team_do')}}" method="post">
@csrf
    <h3>添加竞猜球队</h3>
   <input type="text" name="team_one">VS<input type="text" name="team_two"><br />
   结束竞猜时间<input type="text" name="team_time"><br />
   <input type="submit" value="Submit">
</form>
</body>
</html>