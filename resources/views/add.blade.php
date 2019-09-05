<meta name="csrf-token" content="{{ csrf_token() }}">
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
<form action="{{route('do')}}" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
    <p><input type="text" name="name" placeholder="请输入姓名">@php echo $errors->first('name');@endphp</p>
    <p><input type="text" name="age" placeholder="请输入年龄">@php echo $errors->first('age');@endphp</p>
    <p>性别：<input type="radio" name="sex" value="0">男
    <input type="radio" name="sex" value="1">女
    </p>
    <p><input type="file" name="headimg"></p>
    <p> <input type="button" value="提交"></p>
    </form>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
   $('input[name="name"]').blur(function(){
       var name = $(this).val();
       $(this).next().remove();
       //正则验证中文 字母 。
       var reg =/^[\u4e00-\u9fa5A-Za-z.]{2,12}$/;
       if(!reg.test(name)){
            $(this).after("<b style='color:red'>姓名必须是汉字字母和. 组成 长度为2-12位</b>");
            return;
       }
    //    if(!name)
    //    {
    //        $(this).after("<b style='color:red'>姓名不能为空</b>");
    //    }
    $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
       });
     //姓名唯一性验证
     $.ajax({
         method:'post',
         url:"/student/checkName",
         data:{name:name},
         success:function(msg){
            if( msg>0 )
            {
                $('input[name="name"]').after("<b style='color:red'>姓名已存在</b>");
            }
         }
     })
   });
    //验证年龄
    $('input[name="age"]').blur(function(){
        var age = $(this).val();
       var reg = /^\d{1,3}$/;
       $(this).next().remove();
       if(!reg.test(age))
       {
           $(this).after("<b style='color:red'>请输入正确的年龄</b>");
       }
     });

     
     //点击按钮时触发验证
     $('input[type="button"]').click(function(){
         var faly = false;
        var name = $('input[name="name"]').val();
       $('input[name="name"]').next().remove();
       //正则验证中文 字母 。
       var reg =/^[\u4e00-\u9fa5A-Za-z.]{2,12}$/;
       if(!reg.test(name)){
            $('input[name="name"]').after("<b style='color:red'>姓名必须是汉字字母和. 组成 长度为2-12位</b>");
            return;
            }
   
            $.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
       });
     
     
     //姓名唯一性验证
     $.ajax({
         method:'post',
         url:"/student/checkName",
         async:false,
         data:{name:name},
         success:function(msg){
            if( msg>0 )
            {
                flay = true;
            }
         }
     })
     if(flay)
     {
        $('input[name="name"]').after("<b style='color:red'>姓名已存在</b>");
        return;
     }
     //验证年龄
     var age = $('input[name="age"]').val();
       var reg = /^\d{1,3}$/;
       $('input[name="age"]').next().remove();
       if(!reg.test(age))
       {
           $('input[name="age"]').after("<b style='color:red'>请输入正确的年龄</b>");
           return;
       }
       $('form').submit();
   });
    
   
    
</script>