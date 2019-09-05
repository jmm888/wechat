<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>行家添加-有点</title>
<link rel="stylesheet" type="text/css" href="/laravel/css/css.css" />
<script type="text/javascript" src="/laravel/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../laravel/img/coin02.png" /><span><a href="{{route ('main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">商品分类分类管理</a>&nbsp;-</span>&nbsp;商品分类添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>商品分类添加</span>
				</div>
				<div class="baBody">
					<form action="{{route('cat_do')}}" method="post">
					<div class="bbD">
						@csrf
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分类名称：<input type="text" name="cat_name"
							class="input3" />
					</div>
					<!-- <div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;排序：<input type="text" name=""
							class="input3" />
					</div> -->
					<div class="bbD">
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;分&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;类：<select class="input3" name="parent_id">
						<option value="0">顶级分类</option>
							@foreach ($data as $k=>$v)
							<option value="{{$v->cat_id}}">@php echo str_repeat('--',$v->level-1).$v->cat_name @endphp</option>
							@endforeach
					</select>
					</div>
					<div class="bbD">
						<p class="bbDP">
						<input type="button" value="提交" class="btn_ok btn_yes">
							<!-- <button class="btn_ok btn_yes" href="#">提交</button> -->
						</p>
					</div>
				</div>
			</div>
			</form>
			<!-- 上传广告页面样式end -->
		</div>
	</div>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
//分类名称失去焦点事件验证
	$('input[name="cat_name"]').blur(function(){
		var cat_name = $(this).val();
		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		$(this).next().remove();
		if(!reg.test(cat_name)){
			$(this).after("<b style='color:red'>分类名称由汉字 字母 2至12位组成</b>");
			return;
		}
		$.ajax({
			mothod:'post',
			url:"/cat/catName",
			data:{cat_name:cat_name},
			async:false,
			success:function(msg)
			{
				if(msg>0){
					$('input[name="cat_name"]').after("<b style='color:red'>分类名称已存在</b>");
				return;
				}
			}
		})
	})
	//分类提交按钮 验证
	$('input[type="button"]').click(function(){
		var cat_name = $('input[name="cat_name"]').val();
		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		$('input[name="cat_name"]').next().remove();
		if(!reg.test(cat_name)){
			$('input[name="cat_name"]').after("<b style='color:red'>分类名称由汉字 字母 2至12位组成</b>");
			return;
		}
		var flag = false;
		$.ajax({
			mothod:'post',
			url:"/cat/catName",
			data:{cat_name:cat_name},
			async:false,
			success:function(msg)
			{
				if(msg>0){
					$('input[name="cat_name"]').after("<b style='color:red'>分类名称已存在</b>");
				flag=true;
				}
			}
		})
		if(flag){
			return;
		}
		$('form').submit();
	})
</script>