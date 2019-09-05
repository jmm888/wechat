<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>添加入库</h3>
    <form action="{{url('cargo/cargo_do')}}" method="post" enctype="multipart/form-data">
    @csrf
        <table border="1">
            <tr>
                <td>名称</td>
                <td> <input type="text" name="cargo_name"> </td>
            </tr>
            <tr>
                <td>图片</td>
                <td> <input type="file" name="cargo_img"> </td>
            </tr>
            <tr>
                <td>数量</td>
                <td> <input type="text" name="cargo_num"> </td>
            </tr>
            <tr>
                <td> <input type="submit" value="入库"> </td>
                <td></td>
            </tr>
        </table>
    </form>
</body>
</html>