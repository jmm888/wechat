@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>扫描进行扫码登录</h3>
    <img src="http://qr.liantu.com/api.php?text={{$redirect_url}}"/>
@endsection
