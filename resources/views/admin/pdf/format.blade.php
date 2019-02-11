<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Table</title>

</head>
<body>

<style>

    div.page
    {
        page-break-after: always;
        page-break-inside: avoid;
    }

    body { font-family: DejaVu Sans, sans-serif; }

    .blocks{position: absolute; top: 0; left: 0;}
    .bl1{width: 100%; min-height: 50%;}
    .bl2{width: 100%; height: 50%; padding-top: 200px;}
    .bl3{width: 100%; height: 100%;}

    .border_table{
        border: 1px solid black;
    }
    .col1 { vertical-align: top; }

</style>


<div class="blocks">
    <div class="bl1">
        <div align="center">
            <h2>№ заказа {{$order -> id}}</h2>
        </div>
        <table cellpadding ="4" cellspacing="0" >

            <tr>
                <td align="right" colspan="5">ФИО:</td>
                <td align="right" colspan="2">{{$order -> first_name}} {{$order -> last_name}}</td>
            </tr>
            <tr>
                <td align="right" colspan="5">Телефон:</td>
                <td align="right" colspan="2">{{$order -> phone}}</td>
            </tr>
            <tr>
                <td align="right" colspan="5">Адрес доставки:</td>
                <td align="right" colspan="2">{{$order -> address}}</td>
            </tr>
            <tr>
                <td align="right" colspan="5">Номер отделения компании перевозчика:</td>
                <td align="right" colspan="2">{{$order -> info}}</td>
            </tr>
            <tr>
                <td align="right" colspan="5">Способы доставки:</td>
                <td align="right" colspan="2">
                    @if($order ->shipping_method == "new_post") Новая почта
                    @elseif($order ->shipping_method == "delivery_method") Delivery
                    @elseif($order ->shipping_method == "avtolux_method") Автолюкс
                    @elseif($order ->shipping_method == "intime_method") InTime
                    @elseif($order ->shipping_method == "bus_method") Подвести к автобусу
                    @elseif($order ->shipping_method == "self_pickup") Самовывоз
                    @endif
                </td>
            </tr>
            <tr>
                <td align="right" colspan="5">Способы оплаты:</td>
                <td align="right" colspan="2">
                    @if($order -> payment_method == "privatBank_cart") На карту "ПриватБанка"
                    @elseif($order -> payment_method == "hand_in_cash") Наличными
                    @elseif($order -> payment_method == "c_o_d") Наложенный платеж
                    @endif
                </td>
            </tr>

            <tr>
                <th colspan="2" class="border_table">Товар</th>
                <th class="border_table">Тип</th>
                <th class="border_table">Кол-во.</th>
                <th class="border_table">Пар в ящ/рост.</th>
                <th class="border_table">Размер.</th>
                <th class="border_table">Цена за шт.</th>
                <th class="border_table">Общая цена</th>
            </tr>

            @foreach($order -> details as $detail)

                <br>
                <tr>
                    <td class="border_table" style="overflow: hidden;"><img src="{{public_path() .'/images/products/'.$detail -> image}}" width="70px" height="70px"></td>
                    <td class="border_table">{{$detail -> tovar_name}} ({{$detail -> size_name}})</td>
                    <td class="border_table">
                        @if(($detail -> this_tovar_in_order_price / $detail -> tovar_in_order_count)/ $detail -> prise == $detail -> box_count)
                            Ящик
                        @else
                            Ростовка
                        @endif
                    </td>
                    <td class="border_table">{{$detail -> tovar_in_order_count}}</td>
                    <td class="border_table">
                        @if(($detail -> this_tovar_in_order_price / $detail -> tovar_in_order_count)/ $detail -> prise == $detail -> box_count)
                            {{$detail -> box_count}}
                        @else
                            {{$detail -> rostovka_count}}
                        @endif
                    </td>
                    <td class="border_table">{{$detail ->size_name}}</td>
                    <td class="border_table">{{$detail ->prise}}</td>
                    <td class="border_table">{{$detail ->this_tovar_in_order_price}}</td>
                </tr>

            @endforeach



            <tr>
                <td colspan="8"><p>Всего к оплате:</p></td>

            </tr>
            <tr>

                <td colspan="2" class="col1"><h2>{{$order -> details -> sum('this_tovar_in_order_price')}} грн.</h2></td>
            </tr>

        </table>

    </div>
    {{--<div class="bl3">--}}
    {{--<p>Всего к оплате:</p>--}}
    {{--<p class="price"><h2> {{$order -> details -> sum('this_tovar_in_order_price')}}</h2> грн.</p>--}}
    {{--</div>--}}

</div>


{{--<div class="table-title">--}}
{{--<h1>№ заказа 3175</h1>--}}
{{--</div>--}}
{{--<div class="contacts">--}}



{{--</div>--}}

{{--<div class="bottom-content">--}}

{{--</div>--}}

</body>
</html>