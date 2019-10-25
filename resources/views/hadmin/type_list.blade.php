@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>商品类型展示页面</h3>
    <table  class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>类型名称</th>
            <th>属性数</th>
            <th>操作</th>
        </tr>
        @foreach ($data as $v)
            <tr>
                <td>{{$v['type_id']}}</td>
                <td>{{$v['type_name']}}</td>
                <td>{{$v['attr_num']}}</td>
                <td><a href="{{url('admin/attribute_list')}}?id={{$v['type_id']}}">属性列表</a></td>
            </tr>
        @endforeach
    </table>
@endsection
