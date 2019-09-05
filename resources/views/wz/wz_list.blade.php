<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="/css/bootstrap.min.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>友情链接列表展示</h3>
    <form action="">
    <input type="text" name="wz_name" value="{{$wz_name}}" placeholder="请输入要查询网站的名称">
    <button>搜索</button>
    </form>
    <table border="1">
        <tr>
            <th>ID</th>
            <th>网站名称</th>
            <th>网站网址</th>
            <th>连接类型</th>
            <th>图片LOGO</th>
            <th>网站联系人</th>
            <th>网站介绍</th>
            <th>是否显示</th>
            <th>操作</th>
        </tr>
        @foreach($data as $v)
        <tr>
            <td>{{$v->wz_id}}</td>
            <td>{{$v->wz_name}}</td>
            <td>{{$v->wz_wz}}</td>
            <td>@if($v->wz_lx==1)LOGO链接@else文字链接@endif</td>
            <td><img src="{{env('UPLOAD_URL')}}{{$v->wz_img}}" width="120" height="120"></td>
            <td>{{$v->wz_man}}</td>
            <td>{{$v->wz_desc}}</td>
            <td>@if($v->is_show==1)是@else否@endif</td>
            <td>
            <!-- <a href="{{url('wz/wz_del/'.$v->wz_id)}}">删除</a> -->
            <a class="del" id="{{$v->wz_id}}">删除</a>

                <!-- <button class="del">删除</button> -->
                <a href="{{url('wz/wz_upl/'.$v->wz_id)}}">编辑</a>
            </td>
        </tr>
        @endforeach
    </table>
    {{ $data->appends($query)->links() }}
</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $(".del").on('click',function(){
        // var _this = $(this);
        event.preventDefault();
        var wz_id = $(this).attr('id');
        //alert(wz_id);
        $.ajax({
            data:'',
            url:"{{url('wz/wz_del')}}/"+wz_id,
            success:function(msg)
            {
                if(msg.ret=='00000'){
                    alert(msg.msg);
                }
              window.location.reload();
            }
        })
    })
    </script>
