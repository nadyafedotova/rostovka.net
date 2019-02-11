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
                            <h4 class="title">Информация о заказах</h4>
                        </div>

                        <div class="content table-responsive table-full-width">


                            <table class="table table-striped">
                                <thead>
                                <tr>
                                    <th style="width: 30%">Поставщик</th>
                                    <th>Заказы</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($orderManufacturersUrl as $key => $value)
                                    <tr> <td>{{$key}}</td>
                                        <td><input type="text" class="href" value="{{$value}}" readonly></td>
                                        <td class="options">
                                            <a class="copy__order" href="#">
                                                <i class="ti-clipboard" data-toggle="tooltip" title="Копировать ссылку"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('ordersLib')
    {{--<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>--}}
    <script src="{{url('js/admin/ordersInf.js?n=1')}}"></script>
    {{--<script src="{{url('js/admin/datepicker-ru.js')}}"></script>--}}
@endsection
