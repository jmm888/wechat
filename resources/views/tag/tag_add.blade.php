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
<form action="{{url('wechat/tag_add_do')}}" method="post">
    @csrf
    <center>
        <h1>添加标签</h1>
        <table border="1">
            标签 名称:<input type="text" name="tag_name">
            <br />
            <input type="submit" value="提交">
        </table>
    </center>
</form>
</body>
</html>
