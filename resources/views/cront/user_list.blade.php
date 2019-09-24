<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <center>
        <h3>粉丝列表</h3>
        <form action="{{url('wechat/cron_openid')}}" method="post">
            @csrf
            <input type="submit" value="SUBMIT">
            <table border="1">
                <tr>
                    <th></th>
                    <th>序号</th>
                    <th>NICKNAME</th>
                    <th>OPENID</th>
                </tr>
                @foreach ($info as $k=>$v)
                <tr>
                    <input type="hidden" value="{{$tagid}}" name="tagid">
                    <td><input type="checkbox" name="cront_list[]" value="{{$v['openid']}}"></td>
                    <td>{{$k}}</td>
                    <td>{{$v['nickname']}}</td>
                    <td>{{$v['openid']}}</td>
                </tr>
                @endforeach
            </table>
        </form>
    </center>
</body>
</html>
