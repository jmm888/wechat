<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>竞猜列表</h3>
    <table>
    @foreach ($data as $v)
        <tr>
            <td>{{$v->team_one}} vs {{$v->team_two}}</td>
            <td>@if( time()> $v->team_time)
                <button><a href="{{url('team/ending/'.$v->team_id)}}">查看结果</a></button> 
               <button><a href="{{url('team/jieguo/'.$v->team_id)}}">竞猜结果</a></button> 
            @else
            <button><a href="{{url('team/team_comp/'.$v->team_id)}}">竞猜</a></button> 
            @endif
           </td>
        </tr>
        @endforeach
    </table>
</body>
</html>