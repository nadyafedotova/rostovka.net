@section('ordersCss')
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="{{url('css/admin/products.css')}}" rel="stylesheet">
    <link href="{{url('css/admin/orders.css')}}" rel="stylesheet">
@endsection

@extends('admin.main')
@section('orders_container')
    <div class="content products--content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="header">
                            <h4 class="title">Список заказов</h4>
                        </div>

                        <div class="content table-responsive table-full-width">
                            <div class="col-md-12 pull-left datePicker">
                                @if($errors->any())
                                    <h4 class="back--error">{{$errors->first()}}</h4>
                                @endif
                                <span class="min--title pull-left col-md-12">Скачать список заказов за период (PDF)</span>

                                <div class="col-md-5 datePicker__Block col-xs-12 col-sm-12">
                                    <label for="from">с </label>
                                    <input type="text" id="from" name="from">
                                    <label for="to"> по </label>
                                    <input type="text" id="to" name="to">
                                </div>

                                <div class="col-md-12 col-xs-12 col-sm-12" style="padding: 0">
                                    <select class="sorting__Option" name="options" onchange="getSortItem(event)">
                                        <option value="1">Респределить по доставк</option>
                                        <option value="2">Респределить по производителю</option>
                                    </select>

                                    <select class="image__Option" name="options" style="display: none">
                                        <option value="1">Без фотографий</option>
                                        <option value="2">С фотографиями</option>
                                    </select>
                                </div>

                                <div class="col-md-1 downloadButton">
                                    <button class="pull-right">Скачать</button>
                                </div>
                                <div class="col-md-1 seeButton" >
                                    <button class="pull-downloadButtonPDF">Скачать PDF</button>
                                </div>
                                <div class="col-md-1 seeButton">
                                    <button class="pullSee" style="position: absolute; top: 0; left: 50px;">Посмотреть</button>
                                </div>
                            </div>

                        </div>
                        <div class="col-md-12 span12 pull-right searchbox">
                            <form id="custom-search-form" class="form-search form-horizontal pull-right">
                                <div class="input-append span12">
                                    <input type="text" class="search-query" placeholder="Поиск">
                                    <button type="submit" class="btn"><i class="ti-search"></i></button>
                                </div>
                            </form>
                        </div>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th class="identification">ID</th>
                                <th>ФИО</th>
                                <th>Способ доставки</th>
                                <th>Способ оплаты</th>
                                <th>К оплате</th>
                                <th>Статус</th>
                                <th>Дата
                                    <select style="width: 100px;font-size: small;">
                                        @foreach($countByMount as $count)
                                            <option>{{ $count['date']. ' => ' .$count['count']. ' заказов' }}</option>
                                        @endforeach
                                    </select>
                                </th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($orders as $order)
                                <tr @if ($fools -> contains ('name', $order->email) || $fools -> contains ('name', $order->phone)) style="color: red" @endif>
                                    <td class="articul"><input value="{{$order -> id}}" disabled></td>
                                    <td class="costomer--Info" style="width: 180px">{{$order -> first_name.' '.$order -> last_name}}</td>
                                    <td style="width: 120px">
                                        @if($order -> shipping_method == "new_post") Новая почта
                                        @elseif($order -> shipping_method == "delivery_method") Delivery
                                        @elseif($order -> shipping_method == "avtolux_method") Автолюкс
                                        @elseif($order -> shipping_method == "intime_method") InTime
                                        @elseif($order -> shipping_method == "bus_method")Подвести к автобусу
                                        @else Самовывоз
                                        @endif
                                    </td>
                                    <td>@if($order -> payment_method == "privatBank_cart")    На карту "ПриватБанка"
                                        @elseif($order -> payment_method == "c_o_d") Наложенный платеж
                                        @else Наличными @endif</td>
                                    <td>{{$order -> all_prise}}</td>

                                    <td> @if($order -> paid == 0)
                                            <div class="statusNew">Новый</div>
                                        @elseif($order -> paid == 1)
                                            <div class="statusPaid">Оплачен</div>
                                        @elseif($order -> paid == 2)
                                            <div class="statusSend">Отправлен</div>
                                        @elseif($order -> paid == 3)
                                            <div class="statusProcessing">В обработке</div>
                                        @elseif($order -> paid == 4)
                                            <div class="statusNotCollect">Не собирать</div>
                                        @else
                                            <div class="statusCancel">Отмена заказа</div>@endif

                                    </td>


                                    <td>{{$order -> created_at}}</td>
                                    <td class="options">
                                        <a href="{{url('/pdfLoad/'.$order->id)}}">
                                            <i class="ti-printer" data-toggle="tooltip" title="PDF"></i>
                                        </a>
                                        <a href="{{url('orderInfo/'.$order -> id)}}">
                                            <i class="table--icons ti-pencil-alt" data-toggle="tooltip"
                                               title="Редактировать"></i>
                                        </a>

                                        <a class="remove__order" href="#!">
                                            <i class="table--icons ti-trash type-success"
                                               aria-label="Try me! Example: success modal" data-toggle="tooltip"
                                               title="Удалить"></i>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                {{--<ul class="pagination">--}}
                {{--<li><a href="!#">&laquo;</a></li>--}}
                {{--@for($i = 1; $i < $pagination + 1; $i++)--}}

                {{--<li  @if($i == 0)class="active" @endif><a href="{{url('orders/'.$i)}}">{{$i}}</a></li>--}}
                {{--@endfor--}}
                {{--<li><a href="!#">&raquo;</a></li>--}}
                {{--</ul>--}}

                {{$orders -> links()}}
            </div>
        </div>
    </div>
    </div>
@endsection

@section('ordersLib')
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{url('js/admin/orders.js?n=1')}}"></script>
    <script src="{{url('js/admin/datepicker-ru.js?n=1')}}"></script>
@endsection