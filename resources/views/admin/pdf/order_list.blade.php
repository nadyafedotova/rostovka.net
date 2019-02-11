{{--<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Table</title>
</head>
<body>

<style>

    body { font-family: DejaVu Sans, sans-serif;
           font-size: x-small;
    }
    .page-break {
        page-break-after: always;
    }
    .blocks{ top: 0; left: 0;}
    .bl1{width: 100%; min-height: 50%;}
    .bl2{width: 100%; height: 50%; padding-top: 200px;}
    .bl3{width: 100%; height: 100%;}

    .border_table{
        border: 1px solid black;
    }
    .col1 { vertical-align: top; }

</style>

@foreach($data as $key => $value)
    @php ($i = 0)
    @php ($headValue = '')

    @if($key == "dataFrom")
        @php($dataFrom = $value)
    @endif
    @if($key == "dataTo")
        @php($dataTo = $value)
    @endif
    @if($key == "new_post")
        @php($headValue = "Новая почта")
    @endif
    @if($key == "delivery_method")
        @php($headValue = "Delivery")
    @endif
    @if($key == "avtolux_method")
        @php($headValue = "Автолюкс")
    @endif
    @if($key == "intime_method")
        @php($headValue = "InTime")
    @endif
    @if($key == "bus_method")
        @php($headValue = "Подвести к автобусу")
    @endif
    @if($key == "")
        @php($headValue = "Самовывоз")
    @endif
    <div class="blocks">
        <div class="bl1">

            <h1>{{$headValue}}</h1>
            <table cellpadding ="8" cellspacing="0" >
                <tr>
                    <th class="border_table">№</th>
                    <th class="border_table">ФИО</th>
                    <th class="border_table">Адрес доставки, Номер отделения</th>
                    <th class="border_table">Телефон</th>
                    <th class="border_table">Вид платежа</th>
                    <th class="border_table">Сумма</th>
                    <th class="border_table">К-во мест</th>
                    <th class="border_table">Гал</th>
                </tr>
                @for($i = 0; $i < count($value); $i++) {
                    <tr>
                        <td class="border_table">{{$value[$i][0]}}</td>
                        <td class="border_table">{{$value[$i][1]}}</td>
                        <td class="border_table">{{$value[$i][2]}}</td>
                        <td class="border_table">{{$value[$i][3]}}</td>
                        <td class="border_table">{{$value[$i][4]}}</td>
                        <td class="border_table">{{$value[$i][5]}}</td>
                        <td class="border_table">{{$value[$i][6]}}</td>
                        <td class="border_table">{{$value[$i][7]}}</td>

                    </tr>
                @endfor
            </table>
            <div class="page-break"></div>
        </div>
    </div>

@endforeach

</body>
</html>
--}}






<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Table</title>
</head>
<body>
<style>
        .page-break {
            page-break-after: always;
        }
        .price .title{
            text-align: center;
            font-size: 25px;
            border-bottom: 1px solid black;
        }
        .info{
            border: 1px solid black;
            border-bottom: none;
            padding-bottom: 10px;
            font-size: 20px;

        }
        .info .contact{
        }

        .info .contact .names ,.info .contact .text,.info .contact .img {
            display: inline-block;
            width: 30%;

        }
        .info .contact .names{
            padding-left: 6%;

        }
        .info .contact .img{
            width: 50%;
            padding-left: 50px;

        }
        .info .contact .img img{
            width: 50%;
            padding-left: 20%;

        }
        .info .contact .image-containerNew{
            font-size: 50px;
            display: inline-block;
        }
        .info .name{
            font-size: 30px
        }
        table{
            border-spacing: 0;
        }
        .table table{
            width: 100%;
        }
        .table table,td {
            border: 1px solid black;
            border-right: 0;
            border-collapse: collapse;
        }
        td:first-child{
            border-left: 0;
        }
        td:last-child{
            border-right: 1px solid black;
        }
        .table th{
            background: #e4e4e4;
            border: 1px solid black;
        }
        .table td {
            text-align: center;
            padding: 10px 0;
        }
        .cost{
            float: right;
            padding: 0 0 0 25px;
        }
        .info p{
            margin: 10px 20px 0 0;
        }
        .info .price{
            font-size: 25px;
        }
        .price{
            font-size: 27px;
            float: right;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: x-small;
        }

    </style>
@php($j = 0)
@foreach($data as $key => $value)
    @php ($i = 0)

    @php ($headValue = '')

    @if($key == "dataFrom")
        @php($dataFrom = date('d.m.Y',($value+86400*1)))
    @endif
    @if($key == "dataTo")
        @php($dataTo = date('d.m.Y',($value+86400*1)))
    @endif
    @if($key == "new_post")
        @php($headValue = "Новая почта")
    @endif
    @if($key == "delivery_method")
        @php($headValue = "Delivery")
    @endif
    @if($key == "avtolux_method")
        @php($headValue = "Автолюкс")
    @endif
    @if($key == "intime_method")
        @php($headValue = "InTime")
    @endif
    @if($key == "bus_method")
        @php($headValue = "Подвести к автобусу")
    @endif
    @if($key == "")
        @php($headValue = "Самовывоз")
    @endif
    <div class="info">
        <div class="contact">
            <div class="text">
                <p>{{$value[0][10]}}</p>
                {{--<p> {{$value[0][8]}} - {{$value[0][9]}}</p>--}}
            </div>
            <div class="image-containerNew">
                <p>{{$headValue}}</p>
            </div>
            <div class="names">

            </div>

        </div>

    </div>
    <div class="table">
        <table>
            <tr>
                <th>№</th>
                <th>ФИО</th>
                <th>Город, Номер отделения</th>
                <th>Номер телефона</th>
                <th>Вид платежа</th>
                <th>Сумма</th>
                <th>Кол-во</th>
                <th>гал</th>
            </tr>
            @for($i = 0; $i < count($value); $i++) {
                <tr @if($value[$i][4] == "c_o_d") style="color:red" @endif>
                    <td>{{$value[$i][0]}}</td>
                    <td>{{$value[$i][1]}}</td>
                    <td>{{$value[$i][2]}}</td>
                    <td>{{$value[$i][3]}}</td>
                    @if($value[$i][4] == "privatBank_cart")
                        <td>Карта Приват</td>
                    @endif
                    @if($value[$i][4] == "hand_in_cash")
                        <td>Наличные</td>
                    @endif
                    @if($value[$i][4] == "c_o_d")
                        <td>Наложенный</td>
                    @endif
                    <td>{{$value[$i][5]}}</td>
                    <td>{{$value[$i][6]}}</td>
                    <td>{{$value[$i][7]}}</td>
                </tr>
            @endfor
        </table>
    </div>
    @php($j = $j+1)
    @if($j < count($data))
        <div class="page-break"></div>
    @endif

@endforeach

</body>
</html>
