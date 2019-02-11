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
                                        <li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-left product-item" data-id={{$product -> id}}>
                                            <div class="prod--innerSide">
                                                <div class="product-item-inner">
                                                    <div class="product-img-wrap">
                                                        <a href="{{url($product -> category() -> first() -> link . '/' . $product -> name)}}">
                                                            @if($product -> photo)
                                                            <img class="img-responsive" src="{{asset('images/products/'.$product -> photo -> photo_url)}}" >
                                                                @endif
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="product-detail">
                                                    <p class="product-title"><a href="{{url($product -> category() -> first() -> link . '/' . $product -> name)}}">{{$product -> name}}</a></p>

                                                    <span class="col-md-12 pull-left goods_amount">
                                                        <span class="col-md-12 pull-left"><b>{{$product -> box_count}}</b> - в ящике</span>
                                                        @if($product -> rostovka_count != 0 && $product -> rostovka_count != $product -> box_count)
                                                            <span class="col-md-12 pull-left" data-set="minimum"><b>{{$product -> rostovka_count}}</b> - минимум</span>
                                                        @endif
                                                    </span>

                                                    <div class="col-md-12 pull-left goodsCount_price">
                                                        <span class="item-price col-md-6 pull-left">{{$product -> size -> name}}</span>
                                                        <h5 class="item-price col-md-6 pull-right">{{$product -> prise}} <span>грн</span></h5>
                                                    </div>
                                                    <div class="product-button" data-id={{$product -> id}}> <a href="#!" onclick="success('Товар добавлен в корзину')" data-set="buyButtonSearch"> Купить </a> </div>
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