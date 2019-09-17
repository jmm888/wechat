<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h2>详情页</h2>
    <h4>序号:{{$info['subscribe']}}</h4>
    <h4>昵称:{{$info['nickname']}}</h4>
    <h4>微信号:{{$info['openid']}}</h4>
    <h4>性别:   @if($info['sex']==1)男 @else 女 @endif </h4>
    <h4>头像:<img src="{{$info['headimgurl']}}" alt=""> </h4>
    <h4>城市:{{$info['country']}}{{$info['province']}}{{$info['city']}}</h4>
    <h4>关注时间:{{date("Y-m-d H:i:s",$info['subscribe_time'])}}</h4>
</body>
</html>
