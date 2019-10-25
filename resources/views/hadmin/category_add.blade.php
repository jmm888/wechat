@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
<h3>商品分类页面</h3>
<div style="margin-top: 50px" >
    <form action="{{url('admin/cate_do')}}" method="post">
    @csrf
    <div class="form-group">
        <label for="exampleInputEmail1">分类名称</label>
        <input type="text" class="form-control"  name="category_name" id="exampleInputEmail1" placeholder="请输入分类名称">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">排序</label>
        <input type="age" class="form-control" name="is_sort" id="exampleInputPassword1" placeholder="排序">
    </div>
    <div class="checkbox">
       是否显示： <label>
            <input type="checkbox" value="1" name="is_show">
           YES
        </label>
        <label>
            <input type="checkbox" value="0" name="is_show">
           NO
        </label>
    </div>
    <input type="button" class="btn btn-info" id="sub" value="添加">
    </form>
</div>
<script>
    var flag = false;
    //分类名称失焦 阻止提交事件
    $(".form-control").blur(function(){
        var name = $('[name="category_name"]').val();
        $.ajax({
            url:"{{url('admin/Only')}}",
            data:{name:name},
            dataType:"json",
            success:function(res)
            {
                if(res.ret==1)
                {
                    alert(res.msg);
                    flag = fasle;
                }else{
                    flag = true;
                }
            }
        });
    })
    //Ajax添加
    $("#sub").click(function(){
        if(flag == true)
        {
            $("form").submit();
        }else{
            return flase;
        }
    })

</script>
@endsection


