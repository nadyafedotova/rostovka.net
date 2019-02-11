@section('orderInfo_Css')
    <link href="{{url('css/admin/edit-user.css')}}" rel="stylesheet">
    <link href="{{url('css/admin/orderInfo.css')}}" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css" rel="stylesheet" />
@endsection

@extends('admin.main')
@section('orderInfo_content')


    <div class="content product--add" data-orderid="{{$order -> id}}">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="row">
                            <div class="content">
                                <form method="POST" action="{{url('orderUpdate')}}">

                                    {{csrf_field()}}
                                    <input type="hidden" name="id" value="{!! $order -> id !!}">
                                    <div class="col-md-5">
                                        <div class="header">
                                            <h4 class="title">Информация о заказе</h4>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Сумма</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    {{$order -> summ}}
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Статус</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <select class="form-control border-input" name="paid">
                                                        <option value="0" @if($order -> paid == 0) selected @endif>Новый</option>
                                                        <option value="1" @if($order -> paid == 1) selected @endif>Оплачен</option>
                                                        <option value="2" @if($order -> paid == 2) selected @endif>Отправлен</option>
                                                        <option value="3" @if($order -> paid == 3) selected @endif>В обработке</option>
                                                        <option value="4" @if($order -> paid == 4) selected @endif>Не собирать</option>
                                                        <option value="5" @if($order -> paid == 5) selected @endif>Отменить заказ</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Имя</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input class="form-control border-input" name="first_name" type="text" value="{{$order -> first_name}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Фамилия</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input class="form-control border-input" name="last_name" type="text" value="{{ $order -> last_name}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Телефон</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input class="form-control border-input" name="phone" type="text" value="{{$order ->  phone}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Email</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input class="form-control border-input" name="email" type="text" value="{{$order ->  email}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Способ доставки</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">

                                                    <select name="shipping_method" class="form-control border-input delivery--select">
                                                        <option value="new_post" @if($order ->shipping_method == "new_post") selected @endif>Новая почта</option>
                                                        <option value="delivery_method" @if($order ->shipping_method == "delivery_method")selected @endif>Delivery</option>
                                                        <option value="avtolux_method" @if($order ->shipping_method == "avtolux_method")selected @endif>Автолюкс</option>
                                                        <option value="intime_method" @if($order ->shipping_method == "intime_method")selected @endif>InTime</option>
                                                        <option value="bus_method" @if($order ->shipping_method == "bus_method")selected @endif>Подвести к автобусу</option>
                                                        <option value="self_pickup" @if($order ->shipping_method == "self_pickup")selected @endif>Самовывоз</option>
                                                        {{--"new_post"--}}
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Способ оплаты</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <select class="form-control border-input payment--select" name="payment_method">

                                                              <option value="privatBank_cart" @if($order -> payment_method == "privatBank_cart") selected @endif>На карту "ПриватБанка"</option>
                                                              <option value="hand_in_cash" @if($order -> payment_method == "hand_in_cash") selected @endif>Наличными</option>
                                                              <option value="c_o_d" @if($order -> payment_method == "c_o_d") selected @endif>Наложенный платеж</option>

                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Адрес доставки</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input class="form-control border-input" name="address" type="text" value="{{$order -> address}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Номер отделения компании перевозчика</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <input class="form-control border-input" name="info" type="text" value="{{$order -> info}}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 orderInfo__input">
                                            <div class="col-md-5">
                                                <label>Дополнительная информация</label>
                                            </div>
                                            <div class="col-md-7">
                                                <div class="form-group">
                                                    <textarea rows="5" class="form-control border-input" name="komment" type="text">{{$order -> komment}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-7">
                                        <div class="header col-md-12" style="margin-top: -14px; padding-right: 0">
                                            <div class="col-md-12" style="padding-left: 0; padding-right: 0;">
                                                <h4 class="title col-md-4" style="padding-left: 0">Продукты</h4>

                                                <div class="col-md-4 addProduct pull-right">
                                                    <i class="fa fa-plus-square pull-right" data-toggle="tooltip" data-target="#productsModal" title="Добавить товар"></i>

                                                    <a href="{{url('/pdfLoad/'.$order->id)}}"><i class="ti-printer pull-right" data-toggle="tooltip" data-target="printProducts" style="font-size: 16px;color: #fff;background: #63a2ff;padding: 0 3px 0 5px;font-weight: 100;margin-top: 1px;border-radius: 5px; cursor: pointer"></i></a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 product--list">

                                            <table class="table table-condensed">
                                                <tbody>

                                                    @foreach($order -> details as $detail)

                                                        <tr data-id="{{$detail -> id}}">
                                                            <td>@if($detail -> product != null) <a href="/{{$detail -> product -> category() -> first() -> link}}/{{$detail -> product -> name}}" target="_blank">  @endif<img style="max-width: 90px;" src="{{url('/images/products/'.$detail -> image)}}"></a></td>
                                                            <td>@if($detail -> product != null) <a href="/{{$detail -> product -> category() -> first() -> link}}/{{$detail -> product -> name}}" target="_blank"> @endif{{$detail -> tovar_name}}</a></td>
                                                            <td>{{$detail -> this_tovar_in_order_price}}<span> грн</span></td>
                                                            <td>
                                                                @if($detail -> tip == 'box')
                                                                    Ящик
                                                                @elseif($detail -> tip == 'minimum')
                                                                    Минимум
                                                                @elseif(($detail -> this_tovar_in_order_price / $detail -> tovar_in_order_count)/ $detail -> prise == $detail -> rostovka_count)
                                                                    Минимум
                                                                @else
                                                                    Ящик
                                                                @endif
                                                            </td>
                                                            <td>{{$detail -> tovar_in_order_count}}</td>
                                                            <td><i class="removePrudct table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></td>
                                                        </tr>

                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                    <input class="submit--save" type="submit" value="Сохранить">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<div class="modal fade" id="productsModal" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content col-md-12">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Добавить товар</h4>
            </div>
            <div class="modal-body">
                <div class="form-group col-md-5">
                    <input class="form-control border-input" type="text" placeholder="Введите артикул товара" data-set="searchProduct">
                </div>
                <div class="col-md-2">
                    <button class="search--good">Поиск</button>
                </div>

                <div class="col-md-12 founded--good">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th></th>
                            <th>Фото</th>
                            <th>Артикул</th>
                            <th>Название</th>
                            <th>Категория</th>
                            <th>Произвоитель</th>
                            <th>Тип</th>
                            <th>Колличество</th>
                            <th>Цена</th>
                        </tr>
                        </thead>
                        <tbody id="tmpl"></tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer col-md-12">
                <button type="button" class="btn btn-default add--product--in">Добавить</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Закрыть</button>
            </div>
        </div>

    </div>
</div>

@section('product_addLib')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
    <script src="{{url('js/admin/orderInfo.js?n=1')}}"></script>
@endsection
