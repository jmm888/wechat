@extends('layouts.shop')
@section('content')
<header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>会员注册</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/images/head.jpg" />
     </div><!--head-top/-->
     <form action="{{route('reg_do')}}" method="post" class="reg-login">
      <h3>已经有账号了？点此<a class="orange" href="login">登陆</a></h3>
      <div class="lrBox">
      @csrf
       <div class="lrList"><input type="text" placeholder="输入手机号码或者邮箱号" name="useremail"/></div>
       <div class="lrList2"><input type="text" placeholder="输入短信验证码" name="mil"/> <button class="eamil">获取验证码</button></div>
       <div class="lrList"><input type="text" placeholder="设置新密码（6-18位数字或字母）" name="userpwd"/></div>
       <div class="lrList"><input type="text" placeholder="再次输入密码" name="userpwds"/></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即注册" />
      </div>
     </form><!--reg-login/-->
     <div class="height1"></div>
     <div class="footNav">
      <dl>
       <a href="index.html">
        <dt><span class="glyphicon glyphicon-home"></span></dt>
        <dd>微店</dd>
       </a>
      </dl>
      <dl>
       <a href="prolist.html">
        <dt><span class="glyphicon glyphicon-th"></span></dt>
        <dd>所有商品</dd>
       </a>
      </dl>
      <dl>
       <a href="car.html">
        <dt><span class="glyphicon glyphicon-shopping-cart"></span></dt>
        <dd>购物车 </dd>
       </a>
      </dl>
      <dl>
       <a href="user.html">
        <dt><span class="glyphicon glyphicon-user"></span></dt>
        <dd>我的</dd>
       </a>
      </dl>
      <div class="clearfix"></div>
     </div><!--footNav/-->
     <script src="/js/jq.js"></script>
     <script>
      $('.eamil').on('click',function(){
            event.preventDefault();
            var useremail = $('input[name="useremail"]').val();
            if(!useremail){
                  alert("邮箱或手机号不能为空");
                  // $('input[name="usereamil"]').after("<b style='color:red'>邮箱不能为空</b>");
                  return;
            }
            $.ajax({
                  url:"{{url('index/email')}}",
                  data:{useremail:useremail},
                  success:function(msg){
                         alert(msg);
                  }
            })
      })
     </script>
     @endsection