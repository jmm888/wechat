@extends('layouts.admin')
@section('title', '商品展示')
@section('content')
    <h3>展示</h3>
    <table class="table table-striped">
        <tr>
            <th>ID</th>
            <th>GOODNAME</th>
            <th>GOODPRICE</th>
            <th>img</th>
            <th>操作</th>
        </tr>
        <tbody class="list">
        <tr>
        </tr>
        </tbody>
    </table>
    <nav aria-label="Page navigation">
  <ul class="pagination">
  </ul>
</nav>
    <script>
        var url = "http://www.jmm_wxlaravel.com/api/test";
        $.ajax({
            url:url,
            type:"GET",
            dataType:"JSON",
          success:function(res)
          {
              //数据渲染
            showData(res);
          }
        });
        //分页
        $(document).on('click','.pagination a',function(){
            var page = $(this).text();
            $.ajax({
                url:url,
                data:{page:page},
                dataType:"JSON",
                type:'GET',
                success:function(res)
                {
                    showData(res);
                }
            });
        })
        function showData(res)
        {
            $(".list").empty();
            $.each(res.data.data,function(k,v){
            var tr =$("<tr></tr>");
            tr.append("<td>"+v.good_id+"</td>");
            tr.append("<td>"+v.good_name+"</td>");
            tr.append("<td>"+v.good_price+"</td>");
            tr.append('<td><img width="120"  src="'+v.photo+'"></td>');
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


