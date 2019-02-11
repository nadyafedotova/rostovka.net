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
    @php($sum = 0)
    @php($par = 0)
    <div class="blocks">
        <div class="bl1">
            <h1>{{$key}}</h1>
            <table cellpadding ="8" cellspacing="0" >
                <tr>
                    <th class="border_table">{{$value[0][0]}}</th>
                    <th class="border_table">{{$value[0][1]}}</th>
                    <th class="border_table">{{$value[0][2]}}</th>
                    <th cellpadding ="3" class="border_table">{{$value[0][3]}}</th>
                    <th cellpadding ="2" class="border_table"></th>
                </tr>

                <tr>
                    <th class="border_table">№ </th>
                    <th class="border_table">№ заказа</th>
                    <th class="border_table">Артикул</th>
                    <th class="border_table">Ящ/рост</th>
                    <th class="border_table">К-во</th>
                    <th class="border_table">Пар</th>
                    <th class="border_table">Закуп</th>
                    <th class="border_table">Сумма</th>
                </tr>
                @for($i = 1; $i < count($value); $i++) {
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
                    @php($sum = $sum + $value[$i][7])
                    @php($par = $par + $value[$i][5])
                @endfor
                <tr>
                    <td class="border_table"></td>
                    <td class="border_table"></td>
                    <td class="border_table"></td>
                    <td class="border_table"></td>
                    <td class="border_table"></td>
                    <td class="border_table">{{$par}}</td>
                    <td class="border_table"></td>
                    <td class="border_table">{{$sum}}</td>
                </tr>
            </table>
            <div class="page-break"></div>
        </div>
    </div>

@endforeach

</body>
</html>
******************************--}}
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        body { font-family: DejaVu Sans, sans-serif;
            font-size: x-small;
        }
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
            position: relative;
        }

        .info .contact .names ,.info .contact .text,.info .contact .img {
            display: inline-block;
            /* width: 20%; */
        }
        .info .contact .text{
            /* float: left; */
            margin-left: 0;
        }
        .info .contact .names{
            /* padding-left: 6%; */
            /* float: left; */
            float: right;
        }
        .info .contact .img{
            /* float: left; */
            /* width: 50%; */
            /* padding-left: 50px; */
            /* height: 100%; */
            top: 0;
            left: 50%;
            bottom: 0;
            transform: translateX(-50%);
            position:  absolute;
        }
        .info .contact .img img{
            /* width: 50%; */
            /* padding-left: 20%; */
            float: left;
            height: 100%;
            width: 60%;
            margin-left: -50px;
            margin-top: 15px;
        }
        .info .contact .image-containerNew{
            padding: 20px 0;
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
    </style>

    <title>Document</title>
</head>
<body>

@php($j = 0)
@foreach($data as $key => $value)
    @php ($i = 0)
    @php($sum = 0)
    @php($par = 0)

    <div class="info">
        <div class="contact">
            <div class="contact">
                <div class="text">

                    <br/><br/>
                    <p>{{$value[0][7]}}</p>
                    {{--<p> {{str_replace('-', '.', $value[0][0])}} - {{str_replace('-', '.', $value[0][1])}}</p>--}}
                    <p>Поставщик: <span class="name">{{$value[0][3]}}</span></p>
                    {!! (($value[0][4]!= null)&&($value[0][4] != '')&&($value[0][4] != ' '))? '<p>Адрес: '.$value[0][4].' </p>':'' !!}
                    {!! (($value[0][5]!= null)&&($value[0][5] != '')&&($value[0][5] != ' '))? '<p>Имя:'.$value[0][5].' </p>':'' !!}
                    {!! (($value[0][6]!= null)&&($value[0][6] != '')&&($value[0][6] != ' '))? '<p>Тел: '.$value[0][6].' </p>':'' !!}
                </div>
                <div class="img">
                    <img src="img/logo_black.png">
                </div>
                <div class="names">

                    <p>Заказчик:<span class="name"> Rostovka.net</span></p>
                     <p>Тел: 0672533305</p>
                </div>

            </div>
        </div>
    </div>
    <div class="table">
        <table>
            <tr>
                <th>№</th>
                <th>Номер заказа</th>
                <th>Размер</th>
                <th>Артикул</th>
                <th>Ящ/рост</th>
                <th>Кол-во</th>
                <th>Пар</th>
                <th>Закуп</th>
                <th>Сумма</th>
            </tr>
            @for($i = 1; $i < count($value); $i++) {
                <tr>
                    <td>{{$value[$i][0]}}</td>
                    <td>{{$value[$i][1]}}</td>
                    <td>{{$value[$i][2]}}</td>
                    <td>{{$value[$i][3]}}</td>
                    <td>{{$value[$i][4]}}</td>
                    <td>{{$value[$i][5]}}</td>
                    <td>{{$value[$i][6]}}</td>
                    <td>{{$value[$i][7]}}</td>
                    <td>{{$value[$i][8]}}</td>
                </tr>
                @php($sum = $sum + $value[$i][8])
            @endfor
        </table>
    </div>
    <div class="price">
        {{$sum}}
    </div>
    @php($j = $j+1)
    @if($j < count($data))
        <div class="page-break"></div>
    @endif
@endforeach
</body>
</html>
