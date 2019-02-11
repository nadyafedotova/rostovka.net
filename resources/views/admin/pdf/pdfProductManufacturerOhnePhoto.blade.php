<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Table</title>

</head>
<body>

<style>

    body { font-family: DejaVu Sans, sans-serif; }

    .page-break {
        page-break-after: always;
    }
</style>

@for($i = 0; $i < count($manufacturersNames); $i ++)
    <table  border="1" style="border-style: solid" >
        <tr>
            <td>{{$time}}</td>
            <td></td>
            <td>Заказчик: Rostovka.net<br/>Сергей тел: 0672533305</td>
            <td>Поставщик: {{$manufacturersNames[$i]}}<br/>{{$manufacturersInfos[$manufacturersNames[$i]]}}
            </td>
            <td colspan="3"><img src="{{asset('/images/viber_image.jpg')}}"></td>
            <td></td>
        </tr>
        <tr>
            <td>№</td>
            <td>Номер заказа</td>
            <td>Aртикул</td>
            <td>Ящ/рост</td>
            <td>Кол-во</td>
            <td>Пар</td>
            <td>Закуп</td>
            <td>Сумма</td>
        </tr>
        @foreach($orders as $order)
            @foreach($order -> details as $detail)
                @if($detail -> manufacturer_name == $manufacturersNames[$i])
                    <tr>
                        <td>хз</td>
                        <td>{{$order -> id}}</td>
                        <td>{{$detail -> article}}</td>
                        <td>@if($detail -> tip == "box") ящ @else рост @endif</td>
                        <td>{{$detail->tovar_in_order_count}}</td>
                        <td>@if($detail -> tip == "box") {{$detail->box_count}} @else {{$detail->rostovka_count}} @endif</td>
                        <td>{{$detail->prise_zakup}}</td>
                        <td>@if($detail -> tip == "box")
                                {{$detail->prise_zakup * $detail->tovar_in_order_count * $detail->box_count}}
                            @else {{$detail->prise_zakup * $detail->tovar_in_order_count * $detail->rostovka_count}}
                            @endif
                        </td>
                    </tr>
                @endif
            @endforeach
        @endforeach


    </table>
    @if($i + 1 != count($manufacturersNames))
        <div class="page-break"></div>
    @endif
@endfor
</body>
</html>