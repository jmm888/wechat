@extends('layouts.admin')
@section('title', 'Laravel 学院')
@section('content')
    <h3>实时新闻最新资讯</h3>
        <table  class="table table-bordered">
            <tr>
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
    <script src="/js/jq.js"></script>
    <script>
        var url = "http://www.jmm_wxlaravel.com/api/news_show";
        $.ajax({
            url:url,
            dataType:"JSON",
            success:function(res)
            {
                if(res.ret==201)
                {
                    alert(res.msg);
                }
                var tr = $("<tr></tr>");
                tr.append("<td>"+res.data.title+"</td>");
                tr.append("<td>"+res.data.content+"</td>");
                tr.append("<td>"+res.data.pdate+"</td>");
                tr.append("<td>"+res.data.src+"</td>");
                tr.append("<td><img src="+res.data.img+" alt=''></td>");
                tr.append("<td>"+res.pdate_src+"</td>");
                $(".list").append(tr);
            }
        });
    </script>
@endsection
