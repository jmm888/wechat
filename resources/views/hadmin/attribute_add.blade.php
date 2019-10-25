@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>属性添加</h3>
    <form action="{{url('admin/attr_do')}}" method="post">
        @csrf
        <div class="form-group">
            <label for="exampleInputEmail1">属性名称</label>
            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="请输入属性名称" name="attr_name">
        </div>
        <div class="form-group">
            <label for="exampleInputEmail1">所属商品类型</label>
            <select name="type_id" id="type_id">
                @foreach ($data as $v)
                <option value="{{$v->type_id}}">{{$v->type_name}}</option>
                    @endforeach
            </select>
        </div>
        <div class="checkbox">
            属性是否可选： <label>
                <input type="checkbox" value="1" name="is_opt">
                参数
            </label>
            <label>
                <input type="checkbox" value="2" name="is_opt">
                规格
            </label>
        </div>
        <button type="submit" class="btn btn-default">Submit</button>
    </form>
@endsection
