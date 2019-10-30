@extends('layouts.admin')
@section('title', '数据处理班级列表')
@section('content')
    <h3>班级列表展示</h3>
    <table  class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>班级名称</th>
            <th>班级人数</th>
            <th>操作</th>
        </tr>
        @foreach ($classData as $v)
            <tr>
                <td>{{$v['class_id']}}</td>
                <td>{{$v['class_name']}}</td>
                <td>{{$v['stucount']}}</td>
                <td><a href="">删除</a></td>
            </tr>
        @endforeach
    </table>
@endsection
