@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>类型添加</h3>
    <div style="margin-top: 50px" >
        <form action="{{url('admin/type_do')}}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1">类型名称</label>
                <input type="text" class="form-control"  name="type_name" id="exampleInputEmail1" placeholder="请输入类型名称">
            </div>
            <input type="submit" class="btn btn-info" id="sub" value="添加">
        </form>
    </div>
@endsection


