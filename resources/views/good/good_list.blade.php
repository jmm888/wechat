<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>行家-有点</title>
<link rel="stylesheet" type="text/css" href="../laravel/css/css.css" />
<script type="text/javascript" src="../laravel/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="../admin/js/page.js" ></script> -->
</head>
<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../laravel/img/coin02.png" /><span><a href="{{route('main')}}">首页</a>&nbsp;-&nbsp;<a
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
							<input class="addUser" type="text" name="goods_name" placeholder="输入商品名" />
                            是否上架：<label><input
								type="radio" checked="checked" name="is_on_sale" value="1"/>&nbsp;是</label><label><input
								type="radio" name="is_on_sale" value="0"/>&nbsp;否</label>
							<button class="button">搜索</button>
							<a class="addA addA1" href="connoisseuradd.html">添加行家+</a>
						</div>
					</form>
				</div>
				<!-- banner 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="170px" class="tdColor">商品图片</td>
							<td width="135px" class="tdColor">商品名称</td>
							<td width="145px" class="tdColor">商品货号</td>
							<td width="140px" class="tdColor">商品分类</td>
							<td width="140px" class="tdColor">商品品牌</td>
							<td width="145px" class="tdColor">商品价格</td>
							<td width="150px" class="tdColor">商品数量</td>
							<td width="140px" class="tdColor">商品详情</td>
							<td width="140px" class="tdColor">是否上架</td>
							<td width="150px" class="tdColor">是否热销</td>
							<td width="150px" class="tdColor">是否新品</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
                        @foreach($data as $v)
						<tr>
							<td>{{$v->goods_id}}</td>
							<td><div class="onsImg">
									<img src="{{env('UPLOAD_URL')}}{{$v->goods_img}}">
								</div></td>
							<td>{{$v->goods_name}}</td>
							<td>{{$v->goods_sn}}</td>
							<td>{{$v->cat_name}}</td>
							<td>{{$v->brand_name}}</td>
							<td>{{$v->goods_price}}</td>
							<td>{{$v->goods_number}}</td>
							<td>{{$v->goods_desc}}</td>
							<td>@if($v->is_on_sale)上架 @else 下架 @endif</td>
							<td>@if($v->is_hot)热销 @else 不热销 @endif</td>
							<td>@if($v->is_new)新品 @else 不是新品 @endif</td>
							<td><a href="connoisseuradd.html"><img class="operation"
									src="../laravel/img/update.png"></a> 
                                    <img class="operation delban"
								src="../laravel/img/delete.png"></td>
						</tr>
                        @endforeach
					</table>
					<div class="paging">{{ $data->appends(['goods_name'=>$goods_name,'is_on_sale'=>$is_on_sale])->links() }}</div>
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
				<a><img src="../admin/img/shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="{{url('good/del')}}" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>
<script type="text/javascript">
// 广告弹出框
$(".delban").click(function(){
  $(".banDel").show();
});
$(".close").click(function(){
  $(".banDel").hide();
});
$(".no").click(function(){
  $(".banDel").hide();
});
// 广告弹出框 end
</script>
</html>