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
            text-align: center;
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
    <div class="table">
        <table>
            <tr>
                <th colspan="3">ПОСТАВЩИКИ</th>
            </tr>
            <tr>
                <th>Поставщик</th>
                <th>Адрес</th>
                <th>Телефон</th>
            </tr>
            @foreach($data as $one)
                <tr>
                    <td><span class="name">{{$one['manufacturer']['name']}}</span></td>
                    <td>{{$one['manufacturer']['street']}}, {{$one['manufacturer']['numberContainer']}}</td>
                    <td>{{$one['manufacturer']['phone']}}</td>
                </tr>
            @endforeach
        </table>
    </div>
    <div class="page-break"></div>
    @foreach($data as $one)
        <div class="info" style="background: url(img/logo_black.png) center center no-repeat;  background-size: 480px;">
            <div class="contact">
                <div class="text">
                    <br/><br/><br/>
                    <br/><br/><br/>
                    <p> {{$one['date']}}</p>
                    <p>Поставщик: <span class="name">{{$one['manufacturer']['name']}}</span></p>
                    <p>Адрес:{{$one['manufacturer']['street']}}, {{$one['manufacturer']['numberContainer']}}</p>
                    <p>Тел:{{$one['manufacturer']['phone']}}</p>
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
        <div class="table">
            <table>
                <tr>
                    <th>Фото</th>
                    <th>Артикул</th>
                    <th>Размер</th>
                    <th>Пар в ящике</th>
                    <th>Цена закуп</th>
                    <th>Цена сайт</th>

                @foreach($one['products'] as $product)

                    <tr>
                        <td><img src="{{'images/products/'.$product[0]}}" style="width:100px; height: 100px;" ></td>
                        <td style="text-align: left;">{{$product[1]}}</td>
                        <td>{{$product[2]}}</td>
                        <td>{{$product[3]}}</td>
                        <td>{{$product[4]}}</td>
                        <td>{{$product[5]}}</td>
                    </tr>

                @endforeach
            </table>
        </div>

        <div class="page-break"></div>
    @endforeach
</body>
</html>
