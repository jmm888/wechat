<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>管理员管理-有点</title>
<link rel="stylesheet" type="text/css" href="../laravel/css/css.css" />
<script type="text/javascript" src="../laravel/js/jquery.min.js"></script>
<!-- <script type="text/javascript" src="js/page.js" ></script> -->
</head>

<body>
	<div id="pageAll">
		<div class="pageTop">
			<div class="page">
				<img src="../laravel/img/coin02.png" /><span><a href="{{route ('main')}}">首页</a>&nbsp;-&nbsp;-</span>&nbsp;管理员管理
			</div>
		</div>

		<div class="page">
			<!-- user页面样式 -->
			<div class="connoisseur">
				<div class="conform"> 
					<form action="{{route('add_do')}}" method="post" class="form">
					@csrf
						<div class="cfD">
							<input class="userinput" name="user_name" type="text" placeholder="输入用户名" />&nbsp;&nbsp;&nbsp;-&nbsp;&nbsp;&nbsp;
							<input class="userinput vpr"  name="user_pwd" type="text" placeholder="输入用户密码" />&nbsp;&nbsp;-&nbsp;&nbsp;
							<input class="userinput"  name="credit" type="text" placeholder="输入会员等级" />
							<button class="userbtn">添加</button>
						</div>
					</form>
				</div>
				<!-- user 表格 显示 -->
				<div class="conShow">
					<table border="1" cellspacing="0" cellpadding="0">
						<tr>
							<td width="66px" class="tdColor tdC">序号</td>
							<td width="435px" class="tdColor">会员等级</td>
							<td width="400px" class="tdColor">用户名</td>
							<td width="630px" class="tdColor">添加时间</td>
							<td width="130px" class="tdColor">操作</td>
						</tr>
						@foreach ($data as $v)
						<tr height="40px">
							<td>{{$v->user_id}}</td>
							<td>{{$v->credit}}</td>
							<td>{{$v->user_name}}</td>
							<td>{{date('Y-m-d H:i:s'),$v->add_time}}</td>
							<td><a href="../laravel/connoisseuradd.html"><img class="operation"
									src="../laravel/img/update.png"></a> <img class="operation delban"
								src="../laravel/img/delete.png"></td>
						</tr>
						@endforeach
					</table>
					<div class="paging">此处是分页</div>
				</div>
				<!-- user 表格 显示 end-->
			</div>
			<!-- user页面样式end -->
		</div>
	</div>
	<!-- 删除弹出框 -->
	<div class="banDel">
		<div class="delete">
			<div class="close">
				<a><img src="../laravel/img/shanchu.png" /></a>
			</div>
			<p class="delP1">你确定要删除此条记录吗？</p>
			<p class="delP2">
				<a href="#" class="ok yes">确定</a><a class="ok no">取消</a>
			</p>
		</div>
	</div>
	<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
//ajax添加
$('.userbtn').on('click',function(){
    //禁止跳转
        event.preventDefault();
        var form=$('.form').serialize();
        // alert(form);
		var user_name = $('[name="user_name"]').val();
		var user_pwd = $('[name="user_pwd"]').val();
		if(!user_name|| !user_pwd)
		{
			alert('用户名或密码不能为空');return;
		}
        $.ajax({
            url:"{{route('add_do')}}",
            data:form,
            type:"post",
            dataType:"json",
            success:function(msg){
                if(msg.ret==1){
                    alert(msg.msg);
                    window.location.reload();
                }
            }
        })
    })

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