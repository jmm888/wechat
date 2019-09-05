<meta name="csrf-token" content="{{ csrf_token() }}">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>商品品牌添加-有点</title>
<link rel="stylesheet" type="text/css" href="../laravel/css/css.css" />
<script type="text/javascript" src="../laravel/js/jquery.min.js"></script>
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
<form action="{{route('brand_do')}}" method="post" enctype="multipart/form-data">
	@csrf
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../laravel/img/coin02.png" /><span><a href="{{route ('main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">商品品牌管理</a>&nbsp;-</span>&nbsp;品牌添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>品牌添加</span>
				</div>
				<div class="baBody">
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌LOGO：
						<div class="vipHead vipHead1">
							<img src="../laravel/img/mmexport1555636770862.png" />
							<p class="vipP">上传LOGO</p>
							<input class="file1" type="file" name="brand_logo" />
							
						</div>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌名称：<input type="text"
							class="input3" name="brand_name" />@php echo $errors->first('brand_name');@endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌网址：<input type="text"
							class="input3" name="brand_url" />@php echo $errors->first('brand_url');@endphp
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input
							class="input3" type="text" name="brand_order" />
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;品牌描述：
						<div class="btext2">
							<textarea class="text2" name="brand_desc"></textarea>
						</div>
					</div>
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;是否显示：<label><input
							type="radio" checked="checked" name="is_show" value="1" />&nbsp;是</label><label><input
							type="radio" name="is_show" value="0" />&nbsp;否</label>
					</div>
					<div class="bbD">
						<p class="bbDP">
							<input type="button" value="提交" class="btn_ok btn_yes">
							<!-- <button class="btn_ok btn_yes" href="#">提交</button> -->
							<a class="btn_ok btn_no" href="#">取消</a>
						</p>
					</div>
				</div>
			</div>
			<!-- 上传广告页面样式end -->
		</div>
	</div>
	</form>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
//419表单令牌 配合头部的 令牌
$.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
       });
//验证品牌名称
$('input[name="brand_name"]').blur(function(){
	var brand_name = $(this).val();
	var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
	$(this).next().remove();
	if(!reg.test(brand_name)){
		$(this).after("<b style='color:red'>品牌名称有汉字 字母2-12位组成</b>");
		return;
		}
		//验证品牌唯一性
		$.ajax({
			method:"post",
			url:"/brand/brandName",
			data:{brand_name:brand_name},
			async:false,
			success:function(msg){
				if(msg>0)
				{
				  $('input[name="brand_name"]').after("<b style='color:red'>品牌名称已存在</b>");
				  return;
				}
			  }
			})
	})
	//品牌网址验证
	$('input[name="brand_url"]').blur(function(){
		var brand_url = $(this).val();
		var reg = /^((http):\/\/)/i;
		$(this).next().remove();
		if(!reg.test(brand_url))
		{
			$('input[name="brand_url"]').after("<b style='color:red'>品牌网址必须以http://组成</b>");
			return;
		}
	})
	//点击按钮 验证
	$('input[type="button"]').click(function(){
		//品牌名称验证
		var brand_name = $('input[name="brand_name"]').val();
		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		$('input[name="brand_name"]').next().remove();
		if(!reg.test(brand_name)){
		$('input[name="brand_name"]').after("<b style='color:red'>品牌名称有汉字 字母2-12位组成</b>");
		return;
		}
		var flag = false;
		//验证品牌唯一性
		$.ajax({
			method:"post",
			url:"/brand/brandName",
			data:{brand_name:brand_name},
			async:false,
			success:function(msg){
				if(msg>0)
				{
				  $('input[name="brand_name"]').after("<b style='color:red'>品牌名称已存在</b>");
				  flag = true;
				}
			  }
		})
		if(flag){
			return;
		}
	//品牌网址验证
	var brand_url = $('input[name="brand_url"]').val();
		var reg = /^((http):\/\/)/i;
		$('input[name="brand_url"]').next().remove();
		if(!reg.test(brand_url))
		{
			$('input[name="brand_url"]').after("<b style='color:red'>品牌网址必须以http://组成</b>");
			return;
		}
		$('form').submit();
	})
	
</script>