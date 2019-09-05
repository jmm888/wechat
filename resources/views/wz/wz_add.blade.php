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
    <h3>添加友情链接</h3> 
    <form action="{{route('wz_do')}}" method="post" enctype="multipart/form-data">
    @csrf
        <p>网站名称:<input type="text" name="wz_name">@php echo $errors->first('wz_name');@endphp</p>
        <p>网站网址:<input type="text" name="wz_wz">@php echo $errors->first('wz_wz');@endphp</p>
        <p>链接类型:<input type="radio" name="wz_lx" value="1" ckecked>LOGO链接
                    <input type="radio" name="wz_lx" value="0">文字链接
        </p>
        <p>图片LOGO:<input type="file" name="wz_img"></p>
        <p>网站联系人:<input type="text" name="wz_man"></p>
        <p>网站介绍:<textarea name="wz_desc" id="" cols="30" rows="10"></textarea></p>
        <p>是否显示:<input type="radio" name="is_show" value="1" ckecked>是
                    <input type="radio" name="is_show" value="0">否
        </p>
        <p><input type="submit" value="提交" class="but">
       
        <input type="reset" value="取消">
        </p>
    </form>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $(".but").on('click',function(){
        
        event.preventDefault();
        var wz_name = $('[name="wz_name"]').val();
        var wz_wz = $('[name="wz_wz"]').val();
        if(!wz_name)
        {
            alert('网站名称不能为空'); 
            return false;
        }
        if(!wz_wz)
        {
            alert('网站网址不能为空'); 
            return false;
        }
        //正则验证网站名称
		var rr =/^[\u4e00-\u9fa5A-Za-z0-9_]*$/;
		//判断正则
		if (!rr.test(wz_name)) {
			alert('网站名称为中文字母数字下划线');
			return false;
		};
        
        	//网址正则
		var r2 =/^((http):\/\/)/;
		if (!r2.test(wz_wz)) {
			alert('网址必须为http://开头');
			return false;
		};
        $('form').submit();
    })
    
</script>
