@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>商品展示页面</h3>
    <form action="">
    <select name="cate_id" id="" selected="{{$cate_id}}">
        <option value="">请选择...</option>
        @foreach($cateData as $v)
        <option value="{{$v->cate_id}}">{{$v->category_name}}</option>
        @endforeach
    </select>
    <input type="text" name="name" placeholder="请输入要搜索的商品名称" value="{{$name}}">
    <input type="submit" value="搜索"  class="btn btn-info">
    </form>
    <table class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>商品名称</th>
            <th>所属分类</th>
            <th>商品货号</th>
            <th>商品价格</th>
            <th>商品图片</th>
            <th>商品详情</th>
            <th>商品类型</th>
        </tr>
        @foreach ($data as $v)
        <tr id="{{$v->goods_id}}">
            <td>{{$v->goods_id}}</td>
            <td id="names">
                <span>{{$v->goods_name}}</span>
                <input type="text" name="" style="display: none">
            </td>
            <td>{{$v->category_name}}</td>
            <td>{{$v->goods_sn}}</td>
            <td>{{$v->goods_price}}</td>
            <td><img src="{{$v->goods_img}}" alt="" width="120" height="120"></td>
            <td>{{$v->goods_desc}}</td>
            <td>{{$v->type_name}}</td>
        </tr>
        @endforeach
    </table>
    <script>
        $(document).on('click','#names span',function(){
            var span = $(this);
            var input = span.next();
            span.hide();
            input.show();
            var val = span.text();
            input.val(val);
            //input失去焦点
            input.focus();
        })
        $(document).on('blur','#names input',function()
        {
            var input = $(this);
            var span = input.prev();
            input.hide();
            span.show();
            var val = input.val();
            span.text(val);
            var id = input.parent().parent().attr('id');
            $.ajax({
                url:"{{url('admin/clickhere')}}",
                data:{id:id,val:val},
                dataType:"json",
                success:function(res)
                {
                }
            });
        })
    </script>
@endsection
