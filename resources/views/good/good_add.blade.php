<meta name="csrf-token" content="{{ csrf_token() }}">
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>话题添加-有点</title>
<link rel="stylesheet" type="text/css" href="../laravel/css/css.css" />
<script type="text/javascript" src="../laravel/js/jquery.min.js"></script>
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../laravel/img/coin02.png" /><span><a href="{{route('main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">商品管理</a>&nbsp;-</span>&nbsp;商品添加
			</div>
		</div>
		<div class="page ">
			<!-- 上传广告页面样式 -->
			<div class="banneradd bor">
				<div class="baTopNo">
					<span>商品添加</span>
				</div>
				<form action="{{route('good_do')}}" method="post" enctype="multipart/form-data">
				<div class="baBody">
					@csrf
					<div class="bbD">
						商品名称：<input type="text" name="goods_name" class="input3" />
					</div>
                    <div class="bbD">
						商品货号：<input type="text" name="goods_sn" class="input3" />
					</div>
                    <div class="bbD">
						商品分类：<select class="input3" name="cat_id">
									<option value="0">请选择分类</option>
                            @foreach ($cat as $v)
							<option value="{{$v->cat_id}}">{{str_repeat('--',$v->level-1).$v->cat_name}}</option>
                            @endforeach
								</select>
					</div>
                    <div class="bbD">
						商品品牌：<select class="input3" name="brand_id">
                        <option value="0">请选择品牌</option>
                        @foreach ($brand as $v)
									<option value="{{$v->brand_id}}">{{$v->brand_name}}</option>
                            @endforeach
								</select> 	
					</div>
					
					<div class="bbD">
						商品价格：<input type="text" name="goods_price" class="input3" />
					</div>
                    <div class="bbD">
						商品数量：<input type="text" name="goods_number" class="input3" />
					</div>
                    <div class="bbD">
						商品介绍：<input type="text" name="goods_desc" class="input3" />
					</div>
					
					<div class="bbD">
						是否上架：<label><input type="radio" checked="checked"
							name="is_on_sale" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_on_sale" value="0"/>&nbsp;否</label>
					</div>
					<div class="bbD">
						是否热卖：<label><input type="radio" checked="checked"
						name="is_hot" value="1" />&nbsp;是</label><label><input type="radio"
						name="is_hot" value="0" />&nbsp;否</label>
					</div>
					<div class="bbD">
						是否新品：<label><input type="radio" checked="checked"
							name="is_new" value="1"/>&nbsp;是</label><label><input type="radio"
							name="is_new" value="0"/>&nbsp;否</label>
					</div>
					<div class="bbD">
						商品图片：<input type="file" name="goods_img" />
					</div>
					<div class="bbD">
						<p class="bbDP">
						<input type="button" class="btn_ok btn_yes" value="提交"/>
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
//419表单令牌 配合头部的 令牌
$.ajaxSetup({
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
       });
	//商品名称 失焦验证
	$('input[name="goods_name"]').blur(function(){
		var goods_name = $(this).val();
		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		$(this).next().remove();
		if(!reg.test(goods_name)){
			$(this).after("<b style='color:red'>商品名称由汉字字母2至12位组成</b>");
			return;
		}
		$.ajax({
			method:'post',
			data:{goods_name:goods_name},
			url:"/good/goodName",
			async:false,
			success:function(msg){
				if(msg>0){
					$('input[name="goods_name"]').after("<b style='color:red'>商品名称已存在</b>");
				}
			}
		})
	})
	//商品价格 验证
	$('input[name="goods_price"]').blur(function(){
		var goods_price = $(this).val();
		var reg = /^\d{1,10}$/;
		$(this).next().remove();
		if(!reg.test(goods_price)){
			$(this).after("<b style='color:red'>商品价格必填须为数字 1到10位</b>");
			return;
		}
	})
	//商品数量验证
	$('input[name="goods_number"]').blur(function(){
		var goods_number = $(this).val();
		var reg = /^\d{1,10}$/;
		$(this).next().remove();
		if(!reg.test(goods_number)){
			$(this).after("<b style='color:red'>商品数量必填须为数字 1到10位</b>");
			return;
		}
	})

	//button 按钮提交验证
	$('input[type="button"]').click(function(){
		//商品名称验证
		var goods_name = $('input[name="goods_name"]').val();

		var reg = /^[\u4e00-\u9fa5A-Za-z]{2,12}$/;
		$('input[name="goods_name"]').next().remove();
		if(!reg.test(goods_name)){
			$('input[name="goods_name"]').after("<b style='color:red'>商品名称由汉字字母2至12位组成</b>");
			return;
		}
		var flag = false;
		$.ajax({
			method:'post',
			data:{goods_name:goods_name},
			url:"/good/goodName",
			async:false,
			success:function(msg){
				if(msg>0){
					$('input[name="goods_name"]').after("<b style='color:red'>商品名称已存在</b>");
					flag = true;
				}
			}
		})
		if(flag){
			return;
		}
	//商品价格验证
	var goods_price = $('input[name="goods_price"]').val();
		var reg = /^\d{1,10}$/;
		$('input[name="goods_price"]').next().remove();
		if(!reg.test(goods_price)){
			$('input[name="goods_price"]').after("<b style='color:red'>商品价格必填须为数字 1到10位</b>");
			return;
		}
	//商品数量验证
	var goods_number = $('input[name="goods_number"]').val();
		var reg = /^\d{1,10}$/;
		$('input[name="goods_number"]').next().remove();
		if(!reg.test(goods_number)){
			$('input[name="goods_number"]').after("<b style='color:red'>商品数量必填须为数字 1到10位</b>");
			return;
		}
		$('form').submit();
})
</script>