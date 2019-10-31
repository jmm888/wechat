@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>设置域名页面</h3>
    <form action="{{url('api/wechat_do')}}" method="post">
        <div style="margin-top: 50px" >
            <h4>APPID:{{$data['appid']}}</h4>
            <h4>APPSECRET:{{$data['secret']}}</h4>
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">请设置域名</label>
                <input type="hidden" name="user_id" value="{{$data['user_id']}}">
                <input type="text" class="form-control"  name="api_url" id="exampleInputEmail1" placeholder="域名">
            </div>

            <input type="submit" class="btn btn-info" value="SUBMIT"></input>
        </div>
    </form>
@endsection

