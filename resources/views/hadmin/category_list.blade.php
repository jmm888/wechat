@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>商品分类展示页面</h3>
    <table  class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>分类名称</th>
            <th>排序</th>
            <th>是否显示</th>
        </tr>
        @foreach ($data as $v)
        <tr>
            <td>{{$v->cate_id}}</td>
            <td>{{$v->category_name}}</td>
            <td>{{$v->is_sort}}</td>
            <td>{{$v->is_show}}</td>
        </tr>
            @endforeach
    </table>
@endsection
