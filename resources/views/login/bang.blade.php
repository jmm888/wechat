@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
{{--    <form class="form-horizontal" action="{{url('admin/bang_do')}}" method="post">--}}
{{--        @csrf--}}
{{--        <div class="form-group">--}}
{{--            <label class="col-sm-3 control-label">用户名：</label>--}}
{{--            <div class="col-sm-8">--}}
{{--                <input type="text" placeholder="用户名" name="username" class="form-control">--}}
{{--                <span class="help-block m-b-none">请输入您注册所填的用户名</span>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <label class="col-sm-3 control-label">密码：</label>--}}
{{--            <div class="col-sm-8">--}}
{{--                <input type="password" placeholder="请输入密码" name="pwd" class="form-control">--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="form-group">--}}
{{--            <div class="col-sm-offset-3 col-sm-8">--}}
{{--                <button class="btn btn-sm btn-info" type="submit">绑 定</button>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </form>--}}
<h3>用户绑定</h3>
    <form action="{{url('admin/bang_do')}}" method="post">
        <div style="margin-top: 50px" >
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">用户名</label>
            <input type="text" class="form-control"  name="username" id="exampleInputEmail1" placeholder="用户名">
        </div>
        <div class="form-group">
            <label for="exampleInputPassword1">Password</label>
            <input type="password" class="form-control" name="pwd" id="exampleInputPassword1" placeholder="Password">
        </div>
        <input type="submit" class="btn btn-info" value="绑定"></input>
        </div>
    </form>
@endsection


