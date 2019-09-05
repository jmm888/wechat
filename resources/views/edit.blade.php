<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
@if ($errors->any())
 <div class="alert alert-danger">
 <ul>
 @foreach ($errors->all() as $error)
 <li>{{ $error }}</li>
 @endforeach
 </ul>
 </div>
@endif
<form action="{{url('student/update/'.$data->stu_id)}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
    <p><input type="text" name="name" value="{{$data->name}}" placeholder="请输入姓名">@php echo $errors->first('name');@endphp</p>
    <p><input type="text" name="age" value="{{$data->age}}" placeholder="请输入年龄">@php echo $errors->first('age');@endphp</p>
    <input type="hidden" name="oldimg" value="{{$data->headimg}}">
    <p>性别：
        @if($data->sex==0)
    <input type="radio" name="sex" value="0" checked>男
    <input type="radio" name="sex" value="1">女
        @else
    <input type="radio" name="sex" value="0">男
    <input type="radio" name="sex" value="1" checked>女
        @endif
    </p>
    <p><input type="file" name="headimg" ><img src="{{env('UPLOAD_URL')}}{{$data->headimg}}" width="180" heigth="180"></p>
    <p><button>修改</button></p>
    </form>
</body>
</html>