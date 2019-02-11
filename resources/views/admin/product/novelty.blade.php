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
                            <h4 class="title">Лог загрузок</h4>
                        </div>

                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Дата</th>
                                <th>Товаров загружено</th>
                                <th>Ссылка</th>
                                <th>Скопировать</th>
                                <th>Удалить</th>
                            </tr>
                            </thead>
                            <tbody style="text-align: center;">

                            @foreach($novelties as $novelty)
                                <tr id="parent{{$novelty -> nov_id}}">
                                    <td>{{$novelty -> nov_id}}</td>
                                    <td id="name{{$novelty -> nov_id}}">{{ $novelty -> created_at -> format('d-m-Y') }} @if ( $novelty -> num ) партия №{{ $novelty -> num }} @endif</td>
                                    <td>{{ $novelty->count }}</td>
                                    <td class="link"><a href="/novelty/{{$novelty -> nov_id}}">https://rostovka.net/novelty/{{$novelty -> nov_id}}</a></td>
                                    <td style="width: 60px;"><a class="copy_link" href="#!">
                                        <i class="table--icons ti-layers type-success"
                                           aria-label="Try me! Example: success modal" id="{{$novelty -> nov_id}}" data-toggle="tooltip"
                                           title="Скопировать"></i>
                                    </a></td>
                                    <td style="width: 60px;"><a class="remove_link" href="#!">
                                        <i class="table--icons ti-close type-success"
                                           aria-label="Try me! Example: success modal" id="{{$novelty -> nov_id}}" data-toggle="tooltip"
                                           title="Удалить"></i>
                                    </a></td>
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
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="{{url('js/admin/novelty.js')}}"></script>
@endsection