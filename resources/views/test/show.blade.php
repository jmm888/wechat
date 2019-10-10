@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>展示页面</h3>
    <table class="table table-bordered">
        <tr>
            <td>id</td>
            <td>用户名</td>
            <td>年龄</td>
            <td>操作</td>
        </tr>
        <tbody id="list">
        <tr>
        </tr>
        </tbody>
    </table>
    <script>
        $.ajax({
            url:'http://www.jmm_wxlaravel.com/api/test/show',
            dataType:'json',
            success:function(res){
                $.each(res.data,function(k,v){
                    var tr =$("<tr></tr>");
                    tr.append("<td>"+v.test_id+"</td>");
                    tr.append("<td>"+v.test_name+"</td>");
                    tr.append("<td>"+v.test_age+"</td>");
                    tr.append("<td><a href='http://www.jmm_wxlaravel.com/test/update?id="+v.test_id+"' class='btn btn-info'>编辑</a>  <a  class='btn btn-danger' pid='"+v.test_id+"'>删除</a></td>");
                    $("#list").append(tr);
                })
                    $('.btn-danger').click(function(){
                        var id = $(this).attr('pid');
                        // alert(id);
                        $.ajax({
                            url:'http://www.jmm_wxlaravel.com/api/test/del',
                            dataType:'json',
                            data:{id:id},
                            success:function(res){
                                if (res.ret==1){
                                    alert(res.msg);
                                    location.href="http://www.jmm_wxlaravel.com/test/show"
                                }
                            }
                        })
                    })
            }
        })

    </script>
@endsection


