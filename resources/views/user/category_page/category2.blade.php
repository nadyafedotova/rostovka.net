@extends('user.markup.markup2')

@if($category -> title) 
    @section('title')
        <title>{{$category -> title}}</title>
    @endsection
@endif

@if($category -> description) 
    @section('description')
        <title>{{$category -> description}}</title>
    @endsection
@endif

@section('category')
    <meta name="category_id" content="{{$category -> id}}">
    <div class="categoryPage" dataID="{{$category -> id}}">
        <section class="content-page">
            <div class="container">
                <div class="row">
                    <div class="col-md-10 push-md-2 product--block">
                        <!-- Title -->
                        <div class="list-page-title">
                            <h2 class="">{{$category -> name}}</h2>
                        </div>
                        <!-- End Title -->

                        <!-- Product Filter -->
                        <div class="product-filter-content">
                            <div class="product-filter-content-inner">

                                <!--Product Sort By-->
                                <form class="product-sort-by col-xl-5 col-md-12 col-sm-12 col-xs-12">
                                    <label for="short-by">Сортировка</label>
                                    <select name="short-by" id="short-by" class="nice-select-box">
                                        <option value="0" selected="selected">Последние поступления</option>
                                        <option value="1">от дешевого к дорогому</option>
                                        <option value="2">от дорогого к дешевому</option>
                                    </select>
                                </form>
                                <form class="product-sort-by pull-right col-xl-5 col-md-12 col-sm-12 col-xs-12" data-target="goodsCount">
                                    <label for="product-show">на странице по: </label>
                                    <select name="product-show" id="product-show" class="nice-select-box" data-set="selectCount">
                                        <option value="24" selected="selected">24</option>
                                        <option value="36">36</option>
                                        <option value="48">48</option>
                                    </select>
                                    <span>товаров</span>
                                </form>
                            </div>
                        </div>
                        <!-- End Product Filter -->

                        <div class="row product-list-item product-list-view">
                            <ul id="target" class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12 pull-left productLine"></ul>
                        </div>

                        <div class="pagination-wraper">
                            <div id="pagination" onselectstart="return false" onmousedown="return false"></div>
                        </div>
                    </div>

                    <div class="sidebar-container col-md-2 pull-md-10 category--Filters">
                        <div class="close-icon"><i class="fa fa-times-circle" aria-hidden="true"></i></div>
                        <div class="CFBlock">
                            <h6 class="widget-title" data-id="tip">Выбранные фильтры</h6>
                            <ul class="choosedFilter">

                            </ul>

                            <div class="removeallFilters">
                                <span>Сбросить <i class="fa fa-refresh" aria-hidden="true"></i></span>
                            </div>
                        </div>

                        @include('user.category_page.filters')

                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="overLay"></div>

<script id="template" type="x-jquery-tmpl">
<li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-left product-item"  data-id=${real_id}>
<div class="prod--innerSide" style="transition: 0.5s !important;     height: 355px;">
    <div class="badge badge--new">${prodNew}</div>
    <div class="badge badge--sale">${prodSale}</div>
<div class="product-item-inner">
<div class="product-img-wrap">
<a href="/${product_url}">
<img class="img-responsive" src="${imgUrl}"alt="">
</a>
</div>
</div>
<div class="product-detail">
<p class="product-title"><a href="/${product_url}" title="${name}">${name}</a></p>
<!-- <div class="col-md-12 pull-left">

</div> -->
<div class="col-md-12 pull-left goodsCount_price" style="padding-bottom:10px;">
<span class="col-md-12 pull-left goods_amount mt" style="/*margin-top:3px;*/">
    <span class="item-price col-md-6 pull-left" style="text-align:left;">${size}</span>
    <h6 class="item-price  old--price zakprice" data-set="old--Price" style="    color: #b2b2b2;
        text-decoration: line-through;
        position: absolute;
        ">${old_prise}</h6>
    <h5 class="item-price col-md-6 pull-right" data-set="prodPrice">${price} <span>грн</span></h5>
</span>
<span class="col-md-12 pull-left goods_amount sp2" style="margin-top:30px;">
<span class="col-md-6 pull-left boxCount sp3" style="/*margin-top:-17px;*/"><b>${box}</b> - в ящике</span>
<span class="col-md-6 pull-right minCount sp4" data-set="minimum" style="/*margin-top:-17px;*/"><b>${rostovka}</b> - минимум</span>
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
</script>
@endsection

@section('category__Lib')
    <script type="text/javascript" src="{{asset('js/categoryData.js?version=2.1.8')}}"></script>
@endsection
