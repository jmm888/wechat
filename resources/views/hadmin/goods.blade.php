@extends('layouts.admin')
@section('title', '货品添加')
@section('content')
    <h3>货品添加</h3>
    <form action="{{url('admin/product_do')}}" method="post">
        @csrf
    <table width="100%" id="table_list" class='table table-bordered'>
        <tbody>
        <tr>
            <input type="hidden" name="goods_id" value="{{$goodsData['goods_id']}}">
            <th colspan="20" scope="col">商品名称：{{$goodsData['goods_name']}}&nbsp;&nbsp;&nbsp;&nbsp;货号：{{$goodsData['goods_sn']}}</th>
        </tr>
        <tr>
            <!-- start for specifications -->
            @foreach($data as $k=>$v)
            <td scope="col"><div align="center"><strong>{{$k}}</strong></div></td>
            @endforeach
{{--            <td scope="col"><div align="center"><strong>颜色</strong></div></td>--}}
            <!-- end for specifications -->
            <td class="label_2">货号</td>
            <td class="label_2">库存</td>
            <td class="label_2">&nbsp;</td>
        </tr>
        <tr id="attr_row">
        @foreach ($data as $key=>$value)
            <!-- start for specifications_value -->
            <td align="center" style="background-color: rgb(255, 255, 255);">
                <select name="goods_attr[]">
                    <option value="" selected="">请选择...</option>
                    @foreach ($value as $k=>$v)
                    <option value="{{$v['goodsattr_id']}}">{{$v['attr_value_list']}}</option>
                    @endforeach
                </select>
            </td>
        @endforeach
            <!-- end for specifications_value -->
            <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_sn[]" value="" size="20"></td>
            <td class="label_2" style="background-color: rgb(255, 255, 255);"><input type="text" name="product_number[]" value="1" size="10"></td>
            <td style="background-color: rgb(255, 255, 255);"><input type="button" class="but" value=" + "></td>
        </tr>
        <tr>
            <td align="center" colspan="5" style="background-color: rgb(255, 255, 255);">
                <input type="submit" class="button" value=" 保存 ">
            </td>
        </tr>
        </tbody>
    </table>
    </form>
    <script>
        $(document).on('click','.but',function(){
            //判断button的值是加号还是减号 加号则添加
            if($(this).val() == " + ")
            {
                //加号则加
                var but = $(this).val(" - ");
                var but_clone = $(this).parent().parent().clone();
                $(this).val(" + ");
                $(this).parent().parent().after(but_clone);
            }else{
                //减号就减
                $(this).parent().parent().remove();
            }


        })
    </script>
@endsection
