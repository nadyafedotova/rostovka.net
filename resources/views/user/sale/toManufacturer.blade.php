<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="{{url('css/admin/manufacturer/style.css')}}" rel="stylesheet">

    <title>Document</title>
</head>
<body>
<div class="info">
    <p>Заказчик: Rostovka.net(Сергей)</p>
    <p>Телефон: 067-25-33-305</p>
    <p>Поставщик : {{$manufacturerName}} </p>
    <p>Общая Сумма: <span class="price">{{$finalPrise}} грн</span></p>

</div>
<div class="table">
    <table>
        <tr>
            <th>Номер заказа</th>
            <th>Артукул</th>
            <th>Ящ/рост</th>
            <th>Кол-во</th>
            <th>Пар</th>
            <th>Закуп</th>
            <th>Сумма</th>
        </tr>
        @foreach($manufacturersOrders as $manufacturersOrder)
            <tr>
                <td>{{$manufacturersOrder->order_id}}</td>
                <td>{{$manufacturersOrder->article}}</td>
                <td>@if($manufacturersOrder -> tip == "box") ящ @else рост @endif</td>
                <td>{{$manufacturersOrder->tovar_in_order_count}}</td>
                <td>@if($manufacturersOrder -> tip == "box") {{$manufacturersOrder->box_count}} @else {{$manufacturersOrder->rostovka_count}} @endif</td>
                <td>{{$manufacturersOrder->prise_zakup}}</td>
                <td>@if($manufacturersOrder -> tip == "box") {{$manufacturersOrder->tovar_in_order_count * $manufacturersOrder->prise_zakup * $manufacturersOrder->box_count}}
                    @else{{$manufacturersOrder->tovar_in_order_count * $manufacturersOrder->prise_zakup * $manufacturersOrder->rostovka_count}} @endif</td>
            </tr>
            @endforeach
    </table>
</div>

</body>
</html>