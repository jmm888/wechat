<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <h3>列表</h3>
    <table border="1"  width="500" height="300">
        <tr>
            <th>ID</th>
            <th>标题</th>
            <th>点赞数</th>
            <th>点赞</th>
        </tr>
        @foreach ($data as $v)
        <tr>
            <td>{{$v['t_id'] }}</td>
            <td><a href="{{url('title/content/'.$v['t_id'])}}">{{$v['t_title'] }}</a></td>
            <td class="num{{$v['t_id']}}">{{$v['dian']}}</td>
            <td>
            <a href="javascript:void(0) " class="dian" data-id="{{ $v['t_id'] }}">{{$v['flag']}}</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
<script src="/js/jq.js"></script>
<script>
    $('.dian').click(function(){
        obj = $(this);
        id = obj.data('id');
        flag = obj.html();
        $.ajax({
            url:'list_num',
            data:{'id':id,'flag':flag},
            success:function(msg){
                $('.num' + id).html(msg)
                if(flag == '点赞'){
                    obj.html('取消点赞')
                }else{
                    obj.html('点赞')
                }
            }
        })
    })
</script>