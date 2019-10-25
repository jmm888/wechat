{{--@extends('layouts.admin')--}}
{{--@section('title', '天气')--}}
{{--@section('content')--}}
{{--    <h3>天气</h3>--}}
{{--    <input type="text" name="city" placeholder="请输入要查询的城市">--}}
{{--    <input type="button" id="sub" value="查询">--}}
{{--    <table class="table table-striped">--}}
{{--        <tr>--}}
{{--            <th>城市</th>--}}
{{--            <th>日期</th>--}}
{{--            <th>星期</th>--}}
{{--            <th>温度</th>--}}
{{--            <th>天气详见</th>--}}
{{--            <th>风向</th>--}}
{{--            <th>风力</th>--}}
{{--            <th>最高温度</th>--}}
{{--            <th>最低温度</th>--}}
{{--        </tr>--}}
{{--        <tbody id="list">--}}
{{--        <tr>--}}

{{--        </tr>--}}
{{--        </tbody>--}}
{{--    </table>--}}
{{--    <script>--}}
{{--        $("#sub").click(function(){--}}
{{--            var city = $('[name="city"]').val();--}}
{{--            var url = "http://www.jmm_wxlaravel.com/api/test/weather";--}}
{{--          $.ajax({--}}
{{--              url:url,--}}
{{--              data:{city:city},--}}
{{--              dataType:"json",--}}
{{--              type:"GET",--}}
{{--              success:function(res)--}}
{{--              {--}}
{{--                  $("#list").empty();--}}
{{--                $.each(res.result,function(k,v){--}}
{{--                    var tr = $("<tr></tr>");--}}
{{--                    tr.append("<td>"+v.citynm+"</td>");--}}
{{--                    tr.append("<td>"+v.days+"</td>");--}}
{{--                    tr.append("<td>"+v.week+"</td>");--}}
{{--                    tr.append("<td>"+v.temperature+"</td>");--}}
{{--                    tr.append("<td>"+v.weather+"</td>");--}}
{{--                    tr.append("<td>"+v.wind+"</td>");--}}
{{--                    tr.append("<td>"+v.winp+"</td>");--}}
{{--                    tr.append("<td>"+v.temp_high+"</td>");--}}
{{--                    tr.append("<td>"+v.temp_low+"</td>");--}}
{{--                    $("#list").append(tr);--}}
{{--                })--}}
{{--              }--}}
{{--          });--}}
{{--        })--}}

{{--    </script>--}}
{{--@endsection--}}
@extends('layouts.admin')

@section('content')
    <h4>一周气温展示</h4>

    城市：<input type="text" name="city">
    <input type="button" value='搜索' id='search'> (城市名可以为拼音和汉字)
    <!-- highcharts 天气图标容器 -->
    <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto">

    </div>
    <!-- highcharts 天气图标插件 -->
    <script src="https://code.highcharts.com.cn/highcharts/highcharts.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/highcharts-more.js"></script>
    <script src="https://code.highcharts.com.cn/highcharts/modules/exporting.js"></script>
    <script src="https://img.hcharts.cn/highcharts-plugins/highcharts-zh_CN.js"></script>
    <script type="text/javascript">

        //一进入当前页 默认展示北京气温
        var url = "http://www.jmm_wxlaravel.com/api/test/weather";
        $.ajax({
            url:url,
            data:{city:"北京"},
            dataType:"json",
            success:function(res){
                //展示天气图标
                weather(res.result);
            }
        })

        //点击搜索按钮
        $("#search").on('click',function(){
            //城市名
            var city = $('[name="city"]').val();
            if(city == ""){
                alert("请填写城市");
                return;
            }
            //正则校验 只能是汉字或者拼音
            var reg = /^[a-zA-Z]+$|^[\u4e00-\u9fa5]+$/;
            var res = reg.test(city);
            if(!res){
                alert('城市名只能为拼音和汉字 ');
                return;
            }
            var url = "http://www.jmm_wxlaravel.com/api/test/weather";
            var city = $('[name="city"]').val();
            $.ajax({
                url:url,
                data:{city:city},
                dataType:"json",
                success:function(res){
                    //展示天气图标
                    weather(res.result);
                }
            })
        })

        function weather(weatherData)
        {
            console.log(weatherData);
            var categories = []; //x轴日期
            var data = []; //x轴日期对应的最高最低气温
            $.each(weatherData,function(i,v){
                categories.push(v.days);
                var arr = [parseInt(v.temp_low),parseInt(v.temp_high)];
                data.push(arr)
            })
            // console.log(data);
            // console.log(categories);return;
            //['一月', '二月', '三月', '四月', '五月', '六月', '七月', '八月', '九月', '十月', '十一月', '十二月']
            // [
            //           [-9.7, 9.4],
            //           [-8.7, 6.5],
            //           [-3.5, 9.4],
            //           [-1.4, 19.9],
            //           [0.0, 22.6],
            //           [2.9, 29.5],
            //           [9.2, 30.7],
            //           [7.3, 26.5],
            //           [4.4, 18.0],
            //           [-3.1, 11.4],
            //           [-5.2, 10.4],
            //           [-13.5, 9.8]
            //       ]


            var chart = Highcharts.chart('container', {
                chart: {
                    type: 'columnrange', // columnrange 依赖 highcharts-more.js
                    inverted: true
                },
                title: {
                    text: '一周天气气温'
                },
                subtitle: {
                    text: weatherData[0]['citynm']
                },
                xAxis: {
                    categories:categories
                },
                yAxis: {
                    title: {
                        text: '温度 ( °C )'
                    }
                },
                tooltip: {
                    valueSuffix: '°C'
                },
                plotOptions: {
                    columnrange: {
                        dataLabels: {
                            enabled: true,
                            formatter: function () {
                                return this.y + '°C';
                            }
                        }
                    }
                },
                legend: {
                    enabled: false
                },
                series: [{
                    name: '温度',
                    data: data
                }]
            });
        }


    </script>


@endsection

