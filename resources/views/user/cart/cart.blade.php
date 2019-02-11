@extends('user.markup.markup')
@section('billing')
    <!-- Page Content -->
<section class="content-page cart-container cart--page">
    
    <div class="container mb-80">
        <div class="row">
            <div class="col-sm-12">
                <article class="post-8 is--desc">
                    <form class="cart-form" action="#" method="post">
                        <div class="cart-product-table-wrap responsive-table">
                            <table>
                                <thead>
                                <tr>
                                    <th>Товар</th>
                                    <th>Количество</th>
                                    <th>Тип</th>
                                    <th>Цена</br> за пару</th>
                                    <th>Цена </br>(рост./ящ.)</th>
                                    <th>Размер</th>
                                    <th>Итого</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody id="cartTableInner" data-set="tableCart"></tbody>
                            </table>
                        </div>
                    </form>
                </article>
                <article class="mobile-post is-mobile">
                    <div id="mobile--goods">

                    </div>
                </article>

                <div class="col-md-7 col-md-push-7 pull-right tableFooter">
                    <span class="col-md-12 pull-left totalcoseTitle">Итоговая стоимость: </span>
                    <span class="col-md-12 pull-left" data-set="totalCost"></span>

                    <div class="row cart-actions col-md-12 pull-right">
                        <div class="col-md-12">
                            <a class="col-md-5 col-sm pull-right btn btn-lg btn-color" href="{{url('checkout')}}" style="margin: 5px 5px 0 0">Оформить заказ</a>
                            <a id="redirectback" class="col-md-6 col-sm btn btn-lg btn-color" style="margin: 5px 5px 0 0">Вернуться к покупкам</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</section>
@endsection

@section('cartLib')
    <script type="text/javascript" src="{{asset('js/cartpage.js')}}"></script>
@endsection