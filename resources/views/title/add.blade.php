<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>添加</h3>
    <form action="{{route('add_do')}}" method="post">
    @csrf
        <table border="1">
            <tr>
                <td>标题</td>
                <td><input type="text" name="t_title"></td>
            </tr>
            <tr>
                <td>作者</td>
                <td><input type="text" name="t_man"></td>
            </tr>
            <tr>
                <td>内容</td>
                <td><textarea name="t_content" id="" cols="30" rows="10"></textarea> </td>
            </tr>
            <tr>
                <td> <input type="submit" value="提交"> </td>
                <td></td>
            </tr>
        </table>
    </form>
</body>
</html>