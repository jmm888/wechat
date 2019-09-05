<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>行家-有点</title>
<link rel="stylesheet" type="text/css" href="../laravel/css/css.css" />
<script type="text/javascript" src="../laravel/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../laravel/img/coin02.png" /><span><a href="{{route ('main')}}">首页</a>&nbsp;-&nbsp;<a
					href="#">公共管理</a>&nbsp;-</span>&nbsp;意见管理
			</div>
		</div>

		<div class="page">
			<!-- banner页面样式 -->
			<div class="connoisseur">
				<div class="conform">
					<form>
						<!-- <div class="cfD">
							工作年限：<select><option>1年以内</option></select> 审核状态：<label><input
								type="radio" checked="checked" name="styleshoice1" />&nbsp;未审核</label> <label><input
								type="radio" name="styleshoice1" />&nbsp;已通过</label> <label class="lar"><input
								type="radio" name="styleshoice1" />&nbsp;不通过</label> 推荐状态：<label><input
								type="radio" checked="checked" name="styleshoice2" />&nbsp;是</label><label><input
								type="radio" name="styleshoice2" />&nbsp;否</label>
						</div> -->
						<div class="cfD">
                            <input class="addUser" type="text" name="brand_name" placeholder="请输入要搜索的品牌" />
                            是否显示：<label><input
								type="radio" checked="checked" name="is_show" value="1" />&nbsp;是</label><label><input
								type="radio" name="is_show" value="0"/>&nbsp;否</label>               
							<button class="button">搜索</button>
							<a class="addA addA1" href="connoisseuradd.html">添加行家+</a>
						</div>
					</form>
				</div>
				<!-- banner 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="88px" class="tdColor tdC">序号</td>
							<td width="190px" class="tdColor">头像</td>
							<td width="190px" class="tdColor">品牌名称</td>
                            <td width="190px" class="tdColor">商品网址</td>
                            <td width="180px" class="tdColor">排序</td>
							<td width="180px" class="tdColor">品牌描述</td>
							<td width="180px" class="tdColor">是否显示</td>
							<td width="150px" class="tdColor">操作</td>
                        </tr>
                        @foreach ($data as $v)
						<tr>
							<td>{{$v->brand_id}}</td>
							<td><div class="onsImg">
                            <img src="http://www.jmm_laupload.com/{{$v->brand_logo}}">
								</div></td>
							<td>{{$v->brand_name}}</td>
							<td>{{$v->brand_url}}</td>
							<td>{{$v->brand_order}}</td>
							<td>{{$v->brand_desc}}</td>
							<td>@if($v->is_show==1)是@else否@endif</td>
							<td><a href="{{url('brand_update/'.$v->brand_id)}}"><img class="operation"
									src="../laravel/img/update.png"></a> 
									<img class="operation delban" brand_id={{$v->brand_id}}
								src="../laravel/img/delete.png"></td>
                        </tr>
                        @endforeach
					</table>
                    <div class="paging">此处是分页</div>
                    {{ $data->appends(['brand_name'=>$brand_name,'is_show'=>$is_show])->links() }}
				</div>
				<!-- banner 表格 显示 end-->
			</div>
			<!-- banner页面样式end -->
		</div>

	</div>


	<!-- 删除弹出框 -->
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="img/shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
			<input type="hidden" id=brand_id value="" >
				<a href="#" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
// 广告弹出框
$(".delban").click(function(){
	var brand_id = $(this).attr('brand_id');
	$('#brand_id').val(brand_id);
  $(".banDel").show();
});
$(".close").click(function(){
  $(".banDel").hide();
});
$(".no").click(function(){
  $(".banDel").hide();
});
// 广告弹出框 end
$('.yes').click(function(){
	var brand_id = $('#brand_id').val();
	$.ajax({
		url:"{{url('brand/brand_del')}}",
		data:{brand_id:brand_id},
		success:function(msg){
			if(msg.reg==00000){
				$(".banDel").hide();
				alert(msg.msg);
			}
			window.location.reload();
		}
	})
})
</script>
</html>
