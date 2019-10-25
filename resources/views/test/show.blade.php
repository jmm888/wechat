@extends('layouts.admin')
@section('title', '接口添加')
@section('content')
    <h3>展示页面</h3>
    <input type="text" name="name" placeholder="请输入要搜索的用户名">
    <input type="button" id="search" value="搜索">
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
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
                <a href="#" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>

            <li>
                <a href="#" aria-label="Next">
                    <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    <script>
        var url = 'http://www.jmm_wxlaravel.com/api/usr';
        $.ajax({
            url:url,
            type:"GET",
            dataType:'json',
            success:function(res){
                //数据渲染
               showData(res);
                /*
                删除
                * */
                    $('.btn-danger').click(function(){
                        var id = $(this).attr('pid');
                        // alert(id);
                        var url = 'http://www.jmm_wxlaravel.com/api/usr';
                        $.ajax({
                            url:url+"/"+id,
                            dataType:'json',
                            type:"DELETE",
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
        //分页
        $(document).on('click','.pagination a',function(){
            var page = $(this).text();
            var name = $('[name="name"]').val();
            $.ajax({
                url:url,
                dataType:'json',
                data:{page:page,name:name},
                type:"GET",
                success:function(res){
                    //数据渲染
                  showData(res);
                }
            })
        })
    /*
    * s搜索
    * */
    $("#search").click(function(){
        var name = $('[name="name"]').val();
        $.ajax({
            url:url,
            dataType:'json',
            data:{name:name},
            type:"GET",
            success:function(res){
                //数据渲染
                showData(res);
            }
        })
    })
    //封装渲染页面
    function showData(res)
    {
        //数据渲染
        $('#list').empty()
        $.each(res.data.data,function(k,v){
            var tr =$("<tr></tr>");
            tr.append("<td>"+v.test_id+"</td>");
            tr.append("<td>"+v.test_name+"</td>");
            tr.append("<td>"+v.test_age+"</td>");
            tr.append("<td><a href='http://www.jmm_wxlaravel.com/test/update?id="+v.test_id+"' class='btn btn-info'>编辑</a>  <a  class='btn btn-danger' pid='"+v.test_id+"'>删除</a></td>");
            $("#list").append(tr);
        })
        //分页渲染
        $(".pagination").empty();
        var max_page =res.data.last_page;
        for (var i=1; i<=max_page; i++){
            var li = "<li><a href='javascript:;'>"+i+"</a></li>";
            $(".pagination").append(li);
        }
    }
    </script>
@endsection


