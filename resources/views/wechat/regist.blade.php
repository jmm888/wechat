@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>注册</h3>
    <form action="{{url('api/regist_do')}}" method="post">
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
            <input type="submit" class="btn btn-info" value="注册"></input>
        </div>
    </form>
@endsection



