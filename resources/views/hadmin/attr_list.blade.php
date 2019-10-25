@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>商品属性展示页面</h3>
    <table  class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>属性名称</th>
            <th>商品类型</th>
            <th>属性是否可选</th>
        </tr>
        @foreach ($data as $v)
            <tr>
                <td>{{$v->attr_id}}</td>
                <td>{{$v->attr_name}}</td>
                <td>{{$v->type_name}}</td>
                <td>{{$v->is_opt}}</td>
            </tr>
        @endforeach
    </table>
@endsection
