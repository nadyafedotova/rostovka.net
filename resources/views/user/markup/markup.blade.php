<!doctype html>
<html lang="UA">
<head>
    <!-- Google Tag Manager -->
    <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
                new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-52B7DR8');</script>
    <!-- End Google Tag Manager -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="root-site" content="{!!route('root')!!}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

	@hasSection('title') @yield('title')
    @else <title>Оптовая продажа женской, мужской и детской обуви в Украине</title>
	@endif

    @hasSection('keywords') @yield('keywords')
    @else <meta name="keywords" content="купить обувь оптом, обувь оптом, обувь оптом одесса, купить обувь оптом в украине, оптовая продажа обуви, 7 км обувь оптом, обувь оптом 7км" />
    @endif

	@hasSection('description') @yield('description')
    @else <meta name="description" content="✅ Качественная обувь 👟 оптом в Одессе доступна в нашем каталоге. Огромный выбор детской, женской, мужской обуви с доставкой по всей Украине. ☎ +380 (93) 350-43-82 (VIBER)" />
	@endif

    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- Favicone Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="/public/img/favicon.ico">
    <link rel="icon" type="img/png" href="/public/img/favicon.ico">
    <link rel="apple-touch-icon" href="/public/img/favicon.ico">

	@hasSection('canonical') @yield('canonical')
    @else <link rel="canonical" href="https://{{ $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] }}">
    @endif

    <!-- CSS -->
    <link href="/public/css/bootstrap.css" rel="stylesheet" type="text/css"/>
    <link href="/public/css/font-awesome.min.css" rel="stylesheet" type="text/css"/>
    <link href="/public/css/animate.css" rel="stylesheet" type="text/css"/>
    <link href="/public/css/def.css" rel="stylesheet" type="text/css"/>
    <link href="/public/css/main.css" rel="stylesheet" type="text/css"/>
    <link href="/public/css/bootstrap-slider.min.css" rel="stylesheet" type="text/css"/>
    @yield('productLibCSS')
    @yield('about_lib')
</head>
<body class="">
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-52B7DR8"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<div id="nlpopup_overlay"></div>

<div class="sidebar_overlay"></div>

<!--==========================================-->
<!-- wrapper -->
<!--==========================================-->
<div class="wraper mainPage--Container">
    <!-- Header -->
    <header class="header">
        <!--Topbar-->
        <div class="header-all">
            <div class="header-topbar">
                <div class="header-topbar-inner">
                    <!--Topbar Left-->
                    <div class="topbar-left desktopNumber">
                        <div class="phone pull-left">
                            <div class="text-left pull-left">
                                <i class="fa fa-phone left" aria-hidden="true"></i>
                                <b>(093) 350-43-82 (Viber)</b>
                            </div>
                        </div>
                    </div>
                    <div class="topbar-left mobileNumber">
                        <div class="phone pull-left">
                            <div class="text-left pull-left">
                                <i class="fa fa-phone left" aria-hidden="true"></i>
                                <b>(093) 350-43-82</b>
                            </div>
                        </div>
                    </div>
                    <!--End Topbar Left-->

                    <!--Topbar Right-->
                    <div class="topbar-right">
                        <ul class="list-none">
                            <li>
                                <a href="{{url('/about')}}">
                                    <span class="hidden-sm-down">О магазине</span>
                                </a>
                            </li>

                            @if(!Auth::user())
                                <li>
                                    <a href="/login"><i class="fa fa-lock left" aria-hidden="true"></i><span
                                                class="hidden-sm-down">Авторизация</span></a>
                                </li>
                            @endif
                            @if(Auth::user())
                                <li class="dropdown-nav">
                                    <a href="#!"><i class="fa fa-user left" aria-hidden="true"></i>
                                        <span class="hidden-sm-down">Кабинет</span>
                                    </a>
                                    <!--Dropdown-->
                                    <div class="dropdown-menu">
                                        <ul>
                                        	@if(Auth::user()->isAdmin())
                                        		<li><a href="{{url('/admin_index')}}">Админ панель</a></li>
                                        	@endif
                                            <li><a href="{{url('/userinfo')}}">Моя информация</a></li>
                                            <li>
                                                <a class="logOutButton" href="javascript:void(0)">
                                                    <span class="hidden-sm-down">Выход</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <!--End Dropdown-->
                                </li>
                            @endif
                        </ul>
                    </div>
                    <!-- End Topbar Right -->
                </div>
            </div>
            <!--End Topbart-->

            <!-- Header Container -->
            <div id="header-sticky2" class="header-main">
                <div class="header-main-inner">
                    <!-- Logo -->
                    <div class="logo">
                        <a href="{{url('/')}}">
                            <img src="/public/img/logo_black.png" alt="Rostovka"/>
                        </a>
                    </div>
                    <!-- End Logo -->


                    <!-- Right Sidebar Nav -->
                    <div class="header-rightside-nav">

                        <!-- Sidebar Icon -->
                        <div class="sidebar-icon-nav">
                            <ul class="list-none-ib">

                                <!-- Search-->
                                <li>
                                    <form class="navbar-form" role="search">
                                        <div class="input-group search--box">
                                            <input type="text" class="form-control" placeholder="Поиск" name="q">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default" type="submit"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </li>

                                <li class="f--button"><div class="filter--mobileButton"><i class="fa fa-filter" aria-hidden="true"></i>Фильтры</div></li>

                                <!-- Cart-->
                                <li class="cartBl">
                                    <a href="{{route('cart')}}">
                                        <div class="cart-icon">
                                            <i aria-hidden="true" class="fa fa-shopping-bag"></i>
                                        </div>

                                        <div class="cart-title">
                                            <span class="cart-count" data-set="cartCount"></span>
                                            /
                                            <span class="currency-sign" style="float: right">грн</span>
                                            <span class="cart-price closedSidebar strong" data-set="cart-summ" style="float: right"></span>
                                        </div>
                                    </a>

                                    <span class="dropdownCart">
                                    <div class="arrow-up"></div>

                                    <ul id="cartTemplate" data-set="cart-items"></ul>

                                    <span class="cartQuantity">
                                        <span class="summ">Сумма:</span>
                                        <span class="price" data-set="cart-inner-summ">0 <span class="Total--priceCde">грн</span></span>
                                    </span>

                                    <span class="cartButton">
                                        <a href="{{route('cart')}}" class="button movein--cart">Корзина</a>
                                        <a href="/checkout" class="button checkour_cart">Купить</a>
                                    </span>
                                </span>

                                </li>
                            </ul>
                        </div>
                        <!-- End Sidebar Icon -->
                    </div>
                    <nav class="navigation-menu">
                        @include('user.markup.header')
                    </nav>
                </div>
                <!-- End Right Sidebar Nav -->


                <!-- Navigation Menu -->

                <!-- End Navigation Menu -->
                <div class="mobileNav">
                    @include('user.markup.header')
                </div>
            </div>
        </div>
        <!-- End Header Container -->
    </header>
    <!-- End Header -->

    <!-- Page Content Wraper -->
    <!-- Page Content -->
@yield('register')
@yield('login')
@yield('category')
@yield('mainPage')
@yield('billing')
@yield('product')
@yield('search_result')
@yield('aboutPage')
<!-- End Page Content -->
    <!-- End Page Content Wraper -->


    <!-- Footer Section -------------->
    <footer class="footer section-padding" style="padding-top: 10px; padding-bottom: 10px;">
        <!-- Footer Info -->
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-sm-12 mb-sm-45 offset-md-0" style="margin-right: auto;">
                    <div class="footer-block about-us-block">
                        <img src="/public/img/logo_white.png" width="400" alt="">
                    </div>
                </div>

                <div class="copyrights">

                    <p class="copyright">2018 &copy; rostovka.net</p>
                </div>


                <div class="col-md-4 col-sm-12" style="float: left; margin-left: auto; color: #fff;">
                    <div class="footer-block contact-block" style="float: right; padding-top: 15px; padding-top: 20px;">
                        <span style="float: left; margin-right: 15px; color: #fff;"><i class="fa fa-phone" aria-hidden="true" style="margin-right: 10px;"></i>(067) 25-333-05</span>
                        <span style="float: left; margin-right: 15px; color: #fff;"><i class="fa fa-vimeo" aria-hidden="true" style="margin-right: 10px;"></i>(093) 350-43-82 (VIBER)</span>
                    </div>
                </div>

            </div>
        </div>
        <!-- End Footer Info -->
<a href="#" class="scrollup">Наверх</a>
    </footer>
</div>

{{--<script id="Cart_template" src="{{asset('cartTmpl/cart.html')}}" type="text/x-jquery-tmpl"></script>--}}
<script type="text/javascript" src="/public/js/jquery.min.js"></script>
<script type="text/javascript" src="/public/js/jquery-ui.js"></script>
<!-- jquery library js -->
<script type="text/javascript" src="/public/js/modernizr.js"></script>
<!--modernizr Js-->
<script type="text/javascript" src="/public/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="/public/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="/public/js/revolution.extension.navigation.min.js"></script>
<script type="text/javascript" src="/public/js/revolution.extension.parallax.min.js"></script>
<script type="text/javascript" src="/public/js/revolution.extension.slideanims.min.js"></script>
<script type="text/javascript" src="/public/js/revolution.extension.layeranimation.min.js"></script>
<!--Slider Revolution Js File-->
<script type="text/javascript" src="/public/js/tether.min.js"></script>
<!--Bootstrap tooltips require Tether (Tether Js)-->
<script type="text/javascript" src="/public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/public/js/bootstrap-slider.min.js"></script>
<script type="text/javascript" src="/public/js/bootstrapvalidator.min.js"></script>
<!-- bootstrap js -->

<script type="text/javascript" src="/public/js/owl.carousel.js"></script>
<!-- OWL carousel js -->
<!-- Slick Slider js -->
<script type="text/javascript" src="/public/js/slick.js"></script>
<!-- Validator -->
<!-- Plugins All js -->
<script type="text/javascript" src="/public/js/plugins-all.js"></script>
<script type="text/javascript" src="/public/js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="/public/js/custom.js"></script>
@yield('mainPage_Lib')
@yield('cartLib')
@yield('auth_reg')
@yield('category__Lib')
@yield('auth_lib')
@yield('productLib')
@yield('searchPageLib')
@yield('sliderSizes')
@yield('about_libjs')
@yield('scriptSlider')
<script type="text/javascript" src="/public/js/cart.js"></script>
<!-- custom js -->
<!-- end jquery -->
<script>
    $('.search--box button').on('click', function (e) {
        e.preventDefault();
        $(location).attr('href', '{{url("showFinderFinal")}}/' + $('.search--box input').val() );
    });

    if($(location)[0].pathname === "/public/" || $(location)[0].pathname === "/public/about" || $(location)[0].pathname === "/public/userinfo" || $(location)[0].pathname === "/public/showFinderFinal/" || $(location)[0].pathname === "/public/5/category" || $(location)[0].pathname === "/public/cart" || $(location)[0].pathname === "/public/checkout") {
        $('.f--button').remove();
    }
</script>
<script type="text/javascript">
$(document).ready(function(){

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
        });

        $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });

});
</script>

<script type="text/javascript">
//   (function(d, w, s) {
//     var widgetHash = '4kzy7aohj6quij4so51w', gcw = d.createElement(s); gcw.type = 'text/javascript'; gcw.async = true;
//     gcw.src = '//widgets.binotel.com/getcall/widgets/'+ widgetHash +'.js';
//     var sn = d.getElementsByTagName(s)[0]; sn.parentNode.insertBefore(gcw, sn);
//   })(document, window, 'script');
</script>
</body>
</html>
