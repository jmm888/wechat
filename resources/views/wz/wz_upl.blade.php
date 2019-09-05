<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>添加友情链接</h3> 
    <form action="{{url('wz/update/'.$data->wz_id)}}" method="post" enctype="multipart/form-data">
    @csrf
        <p>网站名称:<input type="text" name="wz_name" value="{{$data->wz_name}}"></p>
        <p>网站网址:<input type="text" name="wz_wz" value="{{$data->wz_wz}}"></p>
        @if($data->wz_lx==1)
        
            <p>链接类型:<input type="radio" name="wz_lx" value="1" checked>LOGO链接
                    <input type="radio" name="wz_lx" value="0">文字链接
            </p>
        @else
            <p>链接类型:<input type="radio" name="wz_lx" value="1">LOGO链接
                    <input type="radio" name="wz_lx" value="0" checked>文字链接
            </p>
        
        @endif
        
        <p>图片LOGO:<input type="file" name="wz_img"><img src="{{env('UPLOAD_URL')}}{{$data->wz_img}}" width="120" height="120"></p>
        <input type="hidden" name="oldimg" value="{{$data->wz_img}}">
        <p>网站联系人:<input type="text" name="wz_man" value="{{$data->wz_man}}"></p>
        <p>网站介绍:<textarea name="wz_desc" id="" cols="30" rows="10">{{$data->wz_desc}}</textarea></p>
        @if($data->is_show==1)
        <p>是否显示:<input type="radio" name="is_show" value="1" checked>是
                    <input type="radio" name="is_show" value="0">否
        </p>
        @else
        <p>是否显示:<input type="radio" name="is_show" value="1">是
                    <input type="radio" name="is_show" value="0" checked>否
        </p>
        @endif
        <p><button>修改</button>
        <input type="reset" value="取消">
        </p>
    </form>
</body>
</html>