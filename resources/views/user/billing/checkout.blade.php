@extends('user.markup.markup')
@section('billing')
<!-- Page Content -->
<meta name="checkout_url" content="{!! url('/checkout') !!}">
<script>
    dataLayer = [];
    
    console.log(dataLayer);
</script>
<div class="logReg_page regPage checkoutPage">
    <section class="content-page">
    <div class="container mb-80">
        <div class="row">
            <div class="col-sm-12">
                <article class="post-8">
                    <form class="product-checkout mt-45" action="{{url('/checkout')}}" method="post" id="contact_form">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="_method" value="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>ПЛАТЕЖНЫЕ РЕКВИЗИТЫ</h3>
                                <h5>Оформление заказа</h5>
                                <div class="row">
                                    <fieldset>
                                        <div class="form-field-wrapper form-center col-sm-12 pull-left">
                                            <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                                @if ($errors->has('first_name'))
                                                    <p> {{$errors -> first('first_name')}} </p>
                                                @endif
                                                <label class="col-md-12 control-label">Ваше имя</label>
                                                <div class="col-md-12 inputGroupContainer">
                                                    <div class="input-group">
                                                        <input name="first_name"
                                                               placeholder="имя"
                                                               class="input-md form-full-width form-control"
                                                               type="text"
                                                               @if(Auth::user())
                                                                value="{{old('first_name',Auth::user()->first_name)}}"
                                                               @else
                                                               value="{{old('first_name')}}"
                                                                @endif>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Text input-->

                                            <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                                @if ($errors->has('last_name'))
                                                    <p> {{$errors -> first('last_name')}} </p>
                                                @endif
                                                <label class="col-md-12 control-label">Ваша фамилия</label>
                                                <div class="col-md-12 inputGroupContainer">

                                                    <div class="input-group">
                                                        <input name="last_name" placeholder="фамилия" class="form-control" type="text"
                                                               @if(Auth::user())
                                                                value="{{old('last_name',Auth::user()->last_name)}}"
                                                               @else
                                                                value="{{old('last_name')}}"
                                                               @endif>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Text input-->


                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            @if ($errors->has('email'))
                                                <p>  {{$errors -> first('email')}} </p>
                                            @endif
                                            <label class="col-md-12 control-label">Ваш E-Mail</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <input name="email" placeholder="e-mail" class="form-control" type="text"
                                                           @if(Auth::user())
                                                            value="{{old('email',Auth::user()->email)}}"
                                                           @else
                                                            value="{{old('email')}}"
                                                           @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="col-md-6 form-field-wrapper form-group has-feedback">
                                            @if ($errors->has('phone'))
                                                <p>   {{$errors -> first('phone')}} </p>
                                            @endif
                                            <label class="col-md-12 control-label">Ваш телефон</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <input name="phone" placeholder="063 111 11 11" class="form-control userPhone" type="text"
                                                           @if(Auth::user())
                                                           value="{{old('phone',Auth::user()->phone)}}"
                                                           @else
                                                           value="{{old('phone')}}"
                                                           @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 form-field-wrapper form-group has-feedback adress">
                                            @if ($errors->has('address'))
                                                <p>  {{$errors -> first('address')}} </p>
                                            @endif
                                            <label class="col-md-12 control-label">Адрес доставки (Город)</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <input name="address" placeholder="адрес" class="form-control" type="text"
                                                           @if(Auth::user())
                                                           value="{{old('address',Auth::user()->address)}}"
                                                           @else
                                                           value="{{old('address')}}"
                                                           @endif>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Text input-->
                                        <div class="col-md-12 form-field-wrapper form-group has-feedback secession">
                                            <label class="col-md-12 control-label">Информация по доставке (Номер отделения)</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <input placeholder="привезти в отделения №3" name="info" class="form-control" type="text">
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 form-field-wrapper form-group has-feedback">
                                            <label class="col-md-12 control-label">Комментарий</label>
                                            <div class="col-md-12 inputGroupContainer">

                                                <div class="input-group">
                                                    <textarea class="commentArea" name="komment"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </fieldset>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="checkout-order-review">
                                    <h3>Ваш заказ</h3>
                                    <div class="product-checkout-review-order">
                                        <div class="responsive-table">
                                            <table class="is--Desc">
                                                <tfoot>

                                                <div class="cards" id="checkCards"></div>
                                                <div id="cardsMore"></div>

                                                <tr class="shipping">
                                                    <th>Доставка</th>
                                                    <td>
                                                        <ul id="shipping_method">
                                                            <li>
                                                                <input name="shipping_method" data-index="0" id="new_post" value="new_post" class="shipping_method" checked="checked" type="radio">
                                                                <label for="new_post">Новая почта</label>
                                                            </li>
                                                            <li>
                                                                <input name="shipping_method" data-index="0" id="delivery_method" value="delivery_method" class="shipping_method" type="radio">
                                                                <label for="delivery_method">Delivery</label>
                                                            </li>
                                                            <li>
                                                                <input name="shipping_method" data-index="0" id="avtolux_method" value="avtolux_method" class="shipping_method" type="radio">
                                                                <label for="avtolux_method">Автолюкс</label>
                                                            </li>
                                                            <li>
                                                                <input name="shipping_method" data-index="0" id="intime_method" value="intime_method" class="shipping_method" type="radio">
                                                                <label for="intime_method">InTime</label>
                                                            </li>
                                                            <li>
                                                                <input name="shipping_method" data-index="0" id="bus_method" value="bus_method" class="shipping_method" type="radio">
                                                                <label for="bus_method">Подвести к автобусу</label>
                                                            </li>
                                                            <li>
                                                                <input name="shipping_method" data-index="0" id="self_pickup" value="self_pickup" class="pickup" type="radio">
                                                                <label for="self_pickup">Самовывоз</label>
                                                            </li>
                                                        </ul>
                                                    </td>
                                                </tr>

                                                <tr class="order-total">
                                                    <th>Сумма</th>
                                                    <td>
                                                        <span class="product-price-amount amount"></span>
                                                    </td>
                                                </tr>
                                                </tfoot>
                                            </table>
                                            
                                            <div class="is--Mobile">
                                                <div>
                                                    <span class="mTitle">Доставка</span>
                                                    <ul id="shipping_method">
                                                    <li>
                                                        <input name="shipping_method" data-index="0" id="mob_new_post" value="new_post" class="shipping_method" checked="checked" type="radio">
                                                        <label for="mob_new_post">Новая почта</label>
                                                    </li>
                                                    <li>
                                                        <input name="shipping_method" data-index="0" id="mob_delivery_method" value="delivery_method" class="shipping_method" type="radio">
                                                        <label for="mob_delivery_method">Delivery</label>
                                                    </li>
                                                    <li>
                                                        <input name="shipping_method" data-index="0" id="mob_avtolux_method" value="avtolux_method" class="shipping_method" type="radio">
                                                        <label for="mob_avtolux_method">Автолюкс</label>
                                                    </li>
                                                    <li>
                                                        <input name="shipping_method" data-index="0" id="mob_intime_method" value="intime_method" class="shipping_method" type="radio">
                                                        <label for="mob_intime_method">InTime</label>
                                                    </li>
                                                    <li>
                                                        <input name="shipping_method" data-index="0" id="mob_bus_method" value="bus_method" class="shipping_method" type="radio">
                                                        <label for="mob_bus_method">Подвести к автобусу</label>
                                                    </li>
                                                    <li>
                                                        <input name="shipping_method" data-index="0" id="mob_self_pickup" value="self_pickup" class="pickup_mob" type="radio">
                                                        <label for="mob_self_pickup">Самовывоз</label>
                                                    </li>
                                                </ul>
                                                </div>

                                                <div class="order-total">
                                                    <span class="mTitle">Сумма</span>
                                                    <div>
                                                        <span class="product-price-amount amount"></span>
                                                    </div>
                                                </div>                              
                                            </div>
                                        </div>

                                        <div class="product-checkout-payment">
                                            <span>Оплата</span>
                                            <ul>
                                                <li>
                                                    <input id="privatBank_cart" name="payment_method" value="privatBank_cart" checked="checked" type="radio" />
                                                    <label for="privatBank_cart">На карту "ПриватБанка"</label>
                                                </li>
                                                <li>
                                                    <input id="hand_in_cash" name="payment_method" value="hand_in_cash" type="radio" />
                                                    <label for="hand_in_cash">Наличными</label>
                                                </li>

                                                <li>
                                                    <input id="c_o_d" name="payment_method" value="c_o_d" type="radio" />
                                                    <label for="c_o_d">Наложенный платеж</label>
                                                </li>

                                            </ul>
                                            <div class="col-md-12 form-field-wrapper form-group has-feedback">
                                                <button type="submit" class="btn btn-warning submit btn btn-md btn-color" onclick="dataLayer.push({'event': 'zakaz'});" style="width: 300px">Оформить заказ</button>
                                            </div>
                                            @if(!Auth::user())
                                                <p class="checkout-info">
                                                    Вы наш клиент? <strong><a href="{{url('login')}}"> Нажмите сюда и авторизуйтесь</a></strong>
                                                </p>
                                            @endif
                                            
                                            <div class="col-md-12 form-field-wrapper form-group has-feedback" style="padding-top: 10px;">
                                                <a id="backtostore" class="btn btn-warning submit btn btn-md btn-color" style="width: 300px">Вернуться к покупкам</a>
                                            </div>

                                            <div class="col-md-12 form-field-wrapper form-group has-feedback" style="padding-top: 10px;">
                                                <a class="btn btn-warning submit btn btn-md btn-color" href="{{ url('/cart') }}" style="width: 300px">Посмотреть корзину</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </article>
            </div>
        </div>
    </div>

</section>
</div>
<!-- End Page Content -->
@endsection


<div class="successful_Buy modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header">
                <div class="icon-box">
                    <i class="fa fa-check-circle"></i>
                </div>
            </div>
            <div class="modal-body">
                <p class="text-center">Ваш заказ принят</p>
                <p class="text-center min--info">Наш менеджер свяжется с Вами в ближайшее время </p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-success btn-block" data-dismiss="modal">OK</button>
            </div>
        </div>
    </div>
</div>

@section('auth_reg')
    <script type="text/javascript" src="{{asset('js/checkout.js')}}"></script>
@endsection

