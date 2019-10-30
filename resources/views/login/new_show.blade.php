@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>新闻类表展示页面</h3>
    <table  class="table table-bordered">
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>内容</th>
            <th>发生时间</th>
            <th>SCR</th>
            <th>图片</th>
            <th>更新时间</th>
        </tr>
        <tbody class="list">
        <tr>
        </tr>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <li><a href='javascript:;'>1</a></li>
        </ul>
    </nav>
    <script src="/js/jq.js"></script>
    <script>
        var url="http://www.jmm_wxlaravel.com/api/show";
        //发送Ajax请求渲染数据
        $.ajax({
            url:url,
            dataType:"json",
            success:function(res){
                if(res.ret==201)
                {
                    alert(res.msg);
                }
                showData(res);
            }
        })
        //分页
        $(document).on('click','.pagination a',function(){
            var page = $(this).text();
            $.ajax({
                url:url,
                data:{page:page},
                dataType:"JSON",
                type:"GET",
                success:function(res)
                {
                    showData(res);
                }
            });
        })
        //封装渲染页面
        function showData(res)
        {
            $(".list").empty();
            $.each(res.data.data,function(i,v){
                var tr = $("<tr></tr>");
                tr.append("<td>"+v.news_id+"</td>");
                tr.append("<td>"+v.title+"</td>");
                tr.append("<td>"+v.content+"</td>");
                tr.append("<td>"+v.pdate+"</td>");
                tr.append("<td>"+v.src+"</td>");
                tr.append("<td><img src="+v.img+" width='80' height='80'></td>");
                tr.append("<td>"+v.pdate_src+"</td>");
                $(".list").append(tr);
            })
            //分页渲染
            $(".pagination").empty();
            var max_page = res.data.last_page;
            for(i=1;i<=max_page;i++){
                var li = "<li><a href='javascript:;'>"+i+"</a></li>";
                $(".pagination").append(li);
            }
        }
    </script>
@endsection
