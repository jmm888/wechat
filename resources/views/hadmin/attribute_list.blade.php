@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>商品属性展示页面</h3>
    <h4>请根据商品类型搜索</h4>
    <select name="name" id="">
        <option value="">请选择...</option>
        @foreach ($typeData as $v)
        <option value="{{$v['type_id']}}">{{$v['type_name']}}</option>
        @endforeach
    </select>
    <input type="button" value="搜索" class="search">
    <table  class="table table-bordered">
        <tr>
            <th><input type="checkbox" id="checkbox">ID</th>
            <th>属性名称</th>
            <th>商品类型</th>
            <th>属性是否可选</th>
        </tr>
        <tbody id="list">
        @foreach ($data as $v)
            <tr>
                <td><input type="checkbox" name="checkboxes[]" value="{{$v->attr_id}}">{{$v->attr_id}}</td>
                <td>{{$v->attr_name}}</td>
                <td>{{$v->type_name}}</td>
                <td>@if ($v->is_opt ==1) 参数 @else 规格 @endif </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <input type="button" class="btn btn-danger" value="批量删除">
    <script>
      $('[name="name"]').on('change',function(){
          var name = $('[name="name"]').val();
          $.ajax({
            url:"{{url('admin/attribute_list')}}",
              data:{name:name},
              dataType:"json",
              success:function(res)
              {
                  console.log(res);
                  $("#list").empty();
                 $.each(res,function(k,v){
                     var tr = "<tr>\n" +
                         "                <td><input type='checkbox' name='checkboxes[]' value="+v.attr_id+">"+v.attr_id+"</td>\n" +
                         "                <td>"+v.attr_name+"</td>\n" +
                         "                <td>"+v.type_name+"</td>\n" +
                         "                <td>@if ("+v.is_opt+" ==1) 参数 @else 规格 @endif </td>\n" +
                         "            </tr>"
                     $("#list").append(tr);
                 })
              }
          });
      })
      //全选
        $("#checkbox").click(function(){
            $('[name="checkboxes[]"]').prop('checked',$(this).prop('checked'));
        })
        //批量删除
       $(document).on('click','.btn',function(){
           //获取 带默认选中的input框
           var obj = $('[name="checkboxes[]"]:checked');
           //定义新数组
            var arr = new Array();
            //获取 选中的id 循环至数组里
            $.each(obj,function(){
                var id = $(this).val();
                arr.push(id);
            })
           var _this = $(this);
           //发送Ajax请求
           $.ajax({
               url:"{{url('admin/del')}}",
               data:{id:arr},
               dataType:"json",
               success:function(res)
               {
                   if(res.ret==1)
                   {
                       alert(res.msg);
                       window.location.reload();
                   }else{
                       alert('异常');
                   }
               }
           })
       })
    </script>
@endsection
