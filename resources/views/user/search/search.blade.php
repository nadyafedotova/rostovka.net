@extends('user.markup.markup')
@section('search_result')
    <div class="categoryPage searchPage">
        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 product--block" style="min-height: 700px">
                        <h3 style="text-align: center; padding-top: 20px; padding-bottom: 20px">Результат поиска {{$name}}</h3>
                        <div class="row product-list-item product-list-view">

                            @if($products ->  count() ==  0)
                                <h4 style="text-align: center; width: 100%; color: red;">Ничего не найденно</h4>
                            @else
                                <ul class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left productLine">
                                    @foreach($products as $product)

                                        <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-left product-item"  data-id="{{$product -> id}}">
                                            <div class="prod--innerSide" style="transition: 0.5s !important;     height: 355px;">
                                                <div class="badge badge--new">{{ $product -> prodNew }}</div>
                                                <div class="badge badge--sale">{{ $product -> prodSale }}</div>
                                                <div class="product-item-inner">
                                                    <div class="product-img-wrap">
                                                        <a href="{{url($product -> category() -> first() -> link . '/' . $product -> name)}}">
                                                            <img class="img-responsive" src="{{asset('images/products/'.$product -> photo -> photo_url)}}" alt="">
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="product-detail">
                                                    <p class="product-title"><a href="{{url($product -> category() -> first() -> link . '/' . $product -> name)}}" title="{{$product -> name}}">{{$product -> name}}</a></p>
                                                    <!-- <div class="col-md-12 pull-left">

                                                    </div> -->
                                                    <div class="col-md-12 pull-left goodsCount_price" style="padding-bottom:10px;">
                                                        <span class="col-md-12 pull-left goods_amount mt" style="/*margin-top:3px;*/">
                                                            <span class="item-price col-md-6 pull-left" style="text-align:left;">{{$product -> size -> name}}</span>
                                                            <h6 class="item-price  old--price zakprice" data-set="old--Price" style="    color: #b2b2b2;
                                                                                    text-decoration: line-through;
                                                                                    position: absolute;
                                                                                    ">@if ($product -> prise_default > $product -> prise) {{ $product -> prise_default }} @endif</h6>
                                                            <h5 class="item-price col-md-6 pull-right {{ $product -> specsale }}" data-set="prodPrice">{{ $product -> prise }} <span>грн</span></h5>
                                                        </span>
                                                        <span class="col-md-12 pull-left goods_amount sp2" style="margin-top:30px;">
                                                            <span class="col-md-6 pull-left boxCount sp3"><b>{{$product -> box_count}}</b> - в ящике</span>
                                                            @if($product -> rostovka_count != 0 && $product -> rostovka_count != $product -> box_count)
                                                                <span class="col-md-6 pull-right minCount sp4" data-set="minimum"><b>{{$product -> rostovka_count}}</b> - минимум</span>
                                                            @endif
                                                        </span>
                                                    </div>

                                                    <div class="product-button but">
                                                        <a href="#!" onclick="success('Товар добавлен в корзину')" data-set="buyButton">
                                                            Купить
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>


{{--//sfsadfdsfsdfsdfssfsddfss//--}}
                        <div class="pagination-wraper">
                            <div id="pagination" onselectstart="return false" onmousedown="return false"></div>
                        </div>
                    </div>
                    {{$products -> links()}}
                </div>

            </div>
        </section>
    </div>
@endsection

@section('searchPageLib')
    <script type="text/javascript" src="{{asset('js/searchPage.js')}}"></script>
@endsection