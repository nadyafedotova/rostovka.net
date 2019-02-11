@extends('user.markup.markup')
@section('mainPage')

    <meta name="api_url" content="{!! url('api/news') !!}">
    <meta name="top_tovar_url" content="{!! url('api/topSales') !!}">

<div class="page-content-wraper">
    <!-- Intro -->
    <section id="intro" class="intro">
        <!-- Revolution Slider -->
        <div id="rev_slider_1078_1_wrapper" class="rev_slider_wrapper fullwidthbanner-container"
             data-source="gallery" style="background-color: transparent; padding: 0px;">
            <div id="rev_slider_1078_1" class="rev_slider fullwidthabanner" style="display: none;"
                 data-version="5.3.0.2">
                <ul>
                	<li class="dark-bg firstItem" data-index="rs-1" data-slotamount="7"
                        data-masterspeed="500" data-thumb="" data-saveperformance="off" data-title="01">
                        <!-- Main Image Layer 0-->
                        <img src="{{asset('img/1.png')}}"/>
                    </li>

                    <li class="lasttItem" data-index="rs-2" data-slotamount="7"
                        data-masterspeed="500" data-thumb=""" data-saveperformance="off" data-title="01">
                        <!-- Main Image Layer 0-->
                        <img src="{{asset('img/1929-760.png')}}"/>
                    </li>
                </ul>
            </div>            
        </div>
        <!-- End Revolution Slider -->
    </section>

    <!-- Page Content Wraper -->
    <div class="page-content-wraper">
        <!-- Product (Tab with Slider) -->
        <section class="section-padding-b mainpageGoodsBlock">
            <div class="container larger">
                <ul class="product-filter nav" role="tablist">
                    <li class="nav-item" onclick="defaultTab(event)">
                        <a class="nav-link active" href="#newest" role="tab" data-toggle="tab">
                            <h2 class="page-title">Новинки</h2>
                        </a>
                    </li>
                    <li class="nav-item last" onclick="topSalesTab(event)">
                        <a class="nav-link" href="#topSalles" role="tab" data-toggle="tab">
                            <h2 class="page-title">Топ продаж</h2>
                        </a>
                    </li>
                </ul>
                <div class="col-md-12 tab-content mainPage">
                    <ul id="newest" role="tabpanel" class="tab-pane fade in active pull-left"></ul>

                    <ul id="topSalles" role="tabpanel" class="tab-pane fade"></ul>
                </div>
            </div>
        </section>
        <!-- End Product (Tab with Slider) -->

        <section class="categories">
            <div class="section-padding container-fluid bg-image text-center overlay-light90"
                 data-background-img="img/bg_5.jpg" data-bg-position-x="center center">
                <div class="container">
                    <h2 class="page-title">категории</h2>
                </div>
            </div>
            <div class="container cat_block">
                <div class="row">
                    <!--Left Side-->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12 mb-30">
                                <!-- banner No.1 -->
                                <div class="promo-banner-wrap">
                                    <a href="{{url('/female')}}" class="promo-image-wrap">
                                        <img src="{{'img/promo-banner4.jpg'}}">
                                    </a>
                                </div>
                            </div>
                            <div class="col-12 mb-30">
                                <!-- banner No.3 -->
                                <div class="promo-banner-wrap">
                                    <a href="{{url('/kids')}}" class="promo-image-wrap">
                                        <img src="{{'img/promo-banner2.jpg'}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!--Right Side-->
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-12 mb-sm-30">
                                <!-- banner No.4 -->
                                <div class="promo-banner-wrap">
                                    <a href="{{url('/male')}}" class="promo-image-wrap">
                                        <img src="{{'img/promo-banner5.jpg'}}">
                                    </a>
                                </div>
                            </div>

                            <div class="col-12 mb-30">
                                <!-- banner No.3 -->
                                <div class="promo-banner-wrap" style="margin-top: 30px;">
                                    <a href="{{url('/sales')}}" class="promo-image-wrap">
                                        <img src="{{'img/saleBanner.jpg'}}">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </section>
    </div>
    <!-- End Page Content Wrapper -->

    <!-- End New Product -->
    <section class="section-padding bg-gray aboutText">
        <div class="container">
            <div class="like-share-inner overlay-black40">
                <h1 class="normal pull-left">Обувь оптом Украина</h1>
                <a class="btn btn-primary pull-left" data-toggle="collapse" href="#collapseInfo" aria-expanded="false" aria-controls="collapseExample">
                    Подробнее
                </a>

            </div>

            <div class="col-md-12">
                <div class="collapse" id="collapseInfo">
                    <div class="col-md-12 col-sm-12 mb-xs-12">
                        <p>
                            Окончание сезона – это время обновок. Больше всего это касается обуви, ведь старая уже
                            сносилась или просто надоела. Постает вопрос: где лучше выбрать и приобрести обувь? Это не
                            так просто как кажется на первый взгляд, нужно выбрать качественную, удобную, красивую
                            обувь, которая будет по карману среднестатистическому покупателю. Можно, конечно, поехать на
                            рынок, обходить все прилавки в поисках или поехать на выставку. Но всему этому есть
                            альтернатива, которая поможет сэкономить много вашего времени и сил – это купить обувь оптом
                            в интернете .
                            На сегодняшний день покупка в интернете стала уже привычным явлением. Учитывая загруженность
                            людей, не всегда получается выделить время на поход по магазинам и не всегда последние могут
                            удовлетворить требования покупателя. Плюсы приобретения обуви оптом онлайн велики: выгодная
                            цена, причиной этому является отсутствие дорогущей оплаты аренды помещения; широкий выбор
                            брендов; экономия времени и т.д.
                            На ряду с этим стоят так же и недостатки этой системы. Решившимся пойти на такой риск стоить
                            помнить о возможных проблемах, таких как: неподходящий размер; неудобная колодка; маленькие
                            дефекты, которых не видно на картинке; гарантия и возврат товара, что может возникнуть при
                            покупке товара через посредников.
                            Чтоб избежать таких неприятностей выбирайте официальные сайты, где можно купить обувь оптом,
                            где вам обязательно выдадут чек и гарантию, а так же уточняйте информацию о размерной сетке
                            выбранного бренда. Для надежности стоит так же указать полноту ноги, измеряв обхват своей
                            стопы, с помощью сантиметра, в наиболее широкой ее носочной части.
                            Приближающиеся теплые весенние деньки напоминают нам о том, что пора скинуть тяжелые сапоги
                            и порадовать себя изящными туфельками. Вышеизложенные советы помогут вам избежать неприятных
                            покупок и не испортить себе весеннее настроение.
                        </p>


                        <h5>Обувь оптом в Одессе</h5>
                        <p>
                            Психологи утверждают, что обувь может много рассказать о своем хозяине, наш характер,
                            амбиции и даже мечты может выдать стиль, цвет и даже высота каблука.
                            Благодаря сети Интернет мы можем спокойно посмотреть много брендовой обуви оптом на любой
                            цвет и вкус, а главное выбрать приемлемую для себе цену без особых физических затрат.
                            Так по каким же критерием покупатель выбирает себе обувь
                        </p>
                        <ul>
                            <li>1) Обувь должна быть удобной и красивой. Ведь все хотят носить обувь, которая им
                                нравится и подходит.
                            </li>
                            <li>2) Стоимость должна соответствовать качеству. Практичные люди всегда покупают
                                качественную продукцию с расчетом поносить ее не один сезон;
                            </li>
                            <li>3) Продукция должна быть качественной. Неровные, плохо пошитые швы портят обувь.</li>
                            <li>4) И самое главное что влияет на продаваемость, обувь должна быть актуальной и
                                желательно не один сезон.
                            </li>
                        </ul>

                        <p>
                            Реализатору выгоднее покупать обувь оптом, которая будет хорошо продавалась, а значит
                            соответствовать выше изложенным требованиям.
                            За качество чаще всего отвечает производитель. Например, турецкая продукция высоко ценится
                            на
                            мировом рынке. Примечательно, что Турция не занимается созданием копий, она создает свою,
                            уникальную обувь оптом. А авторские изделия, как известно, имеют особую ценность.
                            Но по качеству всемирно признанной остается Италия, которая использует самые совершенные
                            технологии, что позволяет создавать анатомически правильную обувь, которая долгое время
                            держит
                            свою форму.
                            Для примера можно взять еще одну страну Европы. Великобритания уже на протяжении 135 лет
                            изготовляет ботинки Loake ручной работы. Ни с чем не сравненная история о трех братьев,
                            которые
                            решили создать свою обувь, исключительной она была от других тем, что в 19 веке впервые
                            появилась долговечная обувь.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<script id="template" type="x-jquery-tmpl">
<li class="col-xl-3 col-lg-3 col-md-6 col-sm-6 col-xs-12 pull-left product-item" data-id=${real_id}>
<div class="prod--innerSide">
<div class="product-item-inner">
<div class="product-img-wrap">
<a href="/${product_url}">
<img class="img-responsive" src="${imgUrl}"alt="">
</a>
</div>
</div>
<div class="product-detail">
<p class="product-title"><a href="/${product_url}">${name}</a></p>
<div class="col-md-12 pull-left goodsCount_price">
<span class="col-md-12 pull-left goods_amount">
<span class="col-md-6 pull-left"><b>${box}</b> - в ящике</span>
<span class="col-md-6 pull-right" data-set="minimum"><b>${rostovka}</b> - минимум</span>
</span>
<span class="item-price col-md-6 pull-left">${size}</span>
<h5 class="item-price col-md-6 pull-right" data-set="prodPrice">${price} <span>грн</span></h5>
<div class="col-md-12 pull-left" style="margin-top: -10px;"  data-set="old--Price">
<h6 class="item-price col-md-6 pull-right old--price" style="color: #b2b2b2;text-decoration: line-through;margin-top: -7px; float: right">${old_prise} <span>грн</span></h6>
</div>
</div>

<div class="product-button">
<a href="#!" onclick="success('Товар добавлен в корзину')" data-set="buyButton">
Купить
</a>
</div>
</div>
</div>
</li>
</script>
@endsection

@section('mainPage_Lib')
    <script type="text/javascript" src="{{asset('js/mainPage_data.js?v=2')}}"></script>
@endsection

@section('sliderSizes')
    <script>

        $(document).ready(function() {
            $('.tp-bgimg.defaultimg').css('background-size', '100% 100%');
        });

    </script>
@endsection
