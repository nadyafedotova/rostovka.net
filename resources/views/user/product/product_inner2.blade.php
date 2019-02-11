@section('productLibCSS')
    <link href="{{asset('css/photoswipre/photoswipe.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/photoswipre/default-skin.css')}}" rel="stylesheet" type="text/css"/>
@endsection

@section('title')
    <title>{{ $product -> name }} купить оптом в магазине Ростовка</title>
@endsection

@section('description')
    <meta name="description" content="{{ $product -> name }} купить оптом в новом интернет магазине со складом в Одессе. Сезонные скидки и распродажи." />
@endsection

@section('canonical')
    <link rel="canonical" href="https://{{ $_SERVER['SERVER_NAME'] }}/{{ $product -> category -> link }}">
@endsection

@extends('user.markup.markup')
@section('product')
    <!-- Page Content -->
    <div class="productPage">
        <section id="productID" class="content-page single-product-content" data-prodid="{{$product -> id}}">

            <!-- Product -->
            <div id="product-detail" class="container one--product">
                <div class="row">
                    <div class="col-lg-12 col-md-12 product-content sidebar-position-right">
                        <div class="row">
                            <!-- Product Image -->
                            <div class="col-md-5">                          
                                <div class="slider1">
                                    @foreach( $product -> photos -> groupBy('photo_url') as $url => $photo)
                                        @if ($url != 'none')
                                            <input type="radio" name="slide_switch" id="id{{$url}}" @if ( $fphoto == $url) checked @endif/>
                                            <label for="id{{$url}}">
                                                <img src="{{asset('images/products/' . $url)}}" width="100"/>
                                                            
                                            </label>
                                            <img class="modalImg" src="{{asset('images/products/' . $url)}}"/>
                                        @endif
                                    @endforeach
                                </div>

                            </div>
                            <!-- End Product Image -->

                            <!-- Product Content -->
                            <div class="col-md-5">
                                <div class="product-page-content">
                                    <h1 class="product-title" style="font-size: 28px;line-height: 1.3;">{{$product -> name}}</h1>
                                    <div class="product-meta">
                                        <span>Производитель : <span class="sku"
                                                                    itemprop="sku">{{$product -> manufacturer -> name}}</span></span>
                                        <span>Категория : <span class="category" itemprop="category">
                                                                {{$product -> category -> name}}</span></span>
                                        <span>Пар в ростовке: <span class="sku"
                                                                    itemprop="sku">{{$product -> rostovka_count}}</span></span>
                                        <span>Пар в ящике : <span class="category"
                                                                  itemprop="category">{{$product -> box_count}}</span></span>
                                        <span>Тип : <span class="category"
                                                          itemprop="category">{{$product -> type -> name}}</span></span>
                                        <span>Сезон : <span class="category"
                                                            itemprop="category">{{$product -> season -> name}}</span></span>
                                        <span>Размеры : <span class="category"
                                                              itemprop="category">{{$product -> size -> name}}</span></span>



                                        @if($product ->material)
                                            <span>Материал верх : <span class="category"
                                                                        itemprop="category">{{$product -> material}}</span></span>
                                        @endif

                                        @if($product ->material_inside)
                                            <span>Материал внутри : <span class="category"
                                                                          itemprop="category">{{$product -> material_inside}}</span></span>

                                        @endif

                                        @if($product -> material_insoles)
                                            <span>Материал стельки : <span class="category"
                                                                           itemprop="category">{{$product -> material_insoles}}</span></span>

                                        @endif
                                        @if($product ->repeats)
                                            <span>Повторы : <span class="category"
                                                                  itemprop="category">{{$product -> repeats}}</span></span>

                                        @endif
                                        @if($product ->color)
                                            <span>Цвет : <span class="category"
                                                               itemprop="category">{{$product -> color}}</span></span>

                                        @endif

                                        @if($product ->manufacturer_country)
                                            <span>Страна произв. :
                                                <span class="category" itemprop="category">{{$product -> manufacturer_country}}</span></span>

                                        @endif

                                    </div>
                                </div>
                                <div class="single-variation-wrap">
                                    <div class="product-price">
                                        <span class="price">{{$product -> prise}} грн</span>
                                    </div>

                                    <div class="col-md-12 chooseItem">

                                        <div class="radio lft choosed" data-set="boxset">
                                            <label>
                                                <input type="radio" name="optradio" value="0" style="width:25px; height:40px;"
                                                       checked onclick="getSelect(event)" data-id="box">в ящике
                                                <span class="boxPrice"><span
                                                            class="iPrice">{{$product -> prise * $product -> box_count}}</span> <sup>грн</sup> <span
                                                            class="forBag">за 1 ящик</span></span>
                                            </label>
                                        </div>
                                        @if($product -> rostovka_count != 0)
                                            <div class="radio rth disable" data-set="rotovkaset">
                                                <label>
                                                    <input type="radio" name="optradio" value="1" style="width:25px; height:40px;"
                                                           onclick="getSelect(event)">
                                                    минимум
                                                    <span><span class="iPrice">{{$product -> prise * $product -> rostovka_count}}</span> <sup>грн</sup> <span
                                                                class="forBag">за 1 ростовку</span></span>
                                                </label>
                                            </div>
                                        @endif

                                        <div class="buttonPrice">
                                            <div class="product-quantity">
                                                <span data-value="+" class="quantity-btn quantityPlus"></span>
                                                <input class="quantity input-lg" step="1" min="1" name="quantity"
                                                       value="1" title="Quantity" type="number" disabled/>
                                                <span data-value="-" class="quantity-btn quantityMinus"></span>
                                            </div>
                                            <button class="btn btn-lg btn-black buyProduct_inner btn-success"
                                                    data-set="buyButton" onclick="success('Товар добавлен в корзину')">
                                                <i class="fa fa-shopping-bag" aria-hidden="true"></i>Купить
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- End Product -->

            <!-- Product Content Tab -->
            <div class="product-tabs-wrapper container">
                <h4>Популярные товары</h4>
                <div class="best--seller" id="newest"></div>
            </div>
            <!-- End Product Content Tab -->

        </section>
    </div>
    <!-- End Page Content -->

    <!-- The Modal -->
    <div id="myModal" class="modal">
        <span class="close">&times;</span>
        <img class="modal-content" id="img01">
    </div>
@endsection



@section('productLib')
    <script type="text/javascript" src="{{asset('js/photoswipe.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/photoswipe-ui-default.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/photoswipe-core.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/product.js')}}"></script>
@endsection

@section('scriptSlider')
    <script>
        jQuery(document).ready(function($) {
            let modal = $('#myModal');

            $('.modalImg').on('click', e => {
                var modalImg = $('#img01');

                console.log(modal);
                console.log(modalImg);

                modal.css('display', 'block');
                modalImg[0].src = e.target.src;
            }); 

            $('.close').on('click', () => { 
                modal.css('display', 'none');
            });
        });
    </script>
@endsection