@extends('layouts.admin')
@section('title', '数据处理班级列表')
@section('content')
    <h3>班级学生列表展示</h3>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>班级名称</th>
            <th>学生信息</th>
        </tr>
        @foreach ($classData as $key=>$val)
        <tr>
            <td>{{$val['class_id']}}</td>
            <td>{{$val['class_name']}}</td>
            <td>
                    <table class="table table-bordered">
                        <tr>
                            <td>id</td>
                            <td>name</td>
                            <td>age</td>
                        </tr>
                @foreach ($val['stu_list'] as $k=>$v)
                        <tr>
                            <td>{{$v['stu_id']}}</td>
                            <td>{{$v['stu_name']}}</td>
                            <td>{{$v['stu_age']}}</td>
                        </tr>
                @endforeach
                    </table>
            </td>
        </tr>
        @endforeach
    </table>
@endsection
