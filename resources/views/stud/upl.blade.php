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
    <form action="{{url('stud/upl_do/'.$data->stu_id)}}" method="post">
    @csrf
        <table border="1">
            <tr>
                <td>学生姓名</td>
                <td> <input type="text" name="stu_name" value="{{$data->stu_name}}"> </td>
            </tr>
            <tr>
                <td>学生年龄</td>
                <td>
                <select name="stu_age">
                    <option value="">请选择</option>
                    @for($i=18;$i<=28;$i++){
                        <option @if($data->stu_age==$i)selected @endif value="{{$i}}">{{$i}}</option>
                    }
                    @endfor
                </select>
                </td>
            </tr>
            <tr>
                <td>学生地址</td>
                <td>
                 <select name="stu_address" id="">
                    <option value="0">请选择</option>
                    <option value="1" @if($data->stu_address==1) selected @endif>北京市昌平区</option>
                    <option value="2" @if($data->stu_address==2) selected @endif>北京市房山区</option>
                 </select>
                </td>
            </tr>
            <!-- <tr>
                <td>学生状态</td>
                <td><input type="radio" name="status" value="0">离校 
                <input type="radio" name="status" value="1" checked>在校
                </td>
            </tr> -->
            <tr>
                <td><input type="submit" value="修改"></td>
                <td></td>
            </tr>
        </table>
    </form>
</body>
</html>