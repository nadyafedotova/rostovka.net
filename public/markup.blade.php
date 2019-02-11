<!doctype html>
<html lang="UA">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="root-site" content="{!!route('root')!!}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>

    <title>Оптовая продажа женской, мужской и детской обуви в Украине</title>
    <meta name="keywords" content="купить обувь оптом, обувь оптом, обувь оптом одесса, купить обувь оптом в украине, оптовая продажа обуви, 7 км обувь оптом, обувь оптом 7км" />
    <meta name="description" content="Качественная обувь оптом в Одессе доступна в нашем каталоге. Огромный выбор детской, женской, мужской обуви с доставкой по всей Украине." />
    <meta http-equiv='cache-control' content='no-cache'>
    <meta http-equiv='expires' content='0'>
    <meta http-equiv='pragma' content='no-cache'>
    <!--[if IE]>
    <meta http-equiv='X-UA-Compatible' content='IE=edge,chrome=1'><![endif]-->

    <!-- Favicone Icon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{asset('img/favicon.ico')}}">
    <link rel="icon" type="img/png" href="{{asset('img/favicon.ico')}}">
    <link rel="apple-touch-icon" href="{{asset('img/favicon.ico')}}">

    <!-- CSS -->
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/font-awesome.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/animate.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/def.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{asset('css/bootstrap-slider.min.css')}}" rel="stylesheet" type="text/css"/>
    @yield('productLibCSS')
</head>
<body class="">

<div id="nlpopup_overlay"></div>

<div class="sidebar_overlay"></div>

<!--==========================================-->
<!-- wrapper -->
<!--==========================================-->
<div class="wraper mainPage--Container">
    <!-- Header -->
    <header class="header">
        <!--Topbar-->
        <div class="header-topbar">
            <div class="header-topbar-inner">
                <!--Topbar Left-->
                <div class="topbar-left">
                    <div class="phone pull-left">
                        <div class="text-left pull-left">
                            <i class="fa fa-phone left" aria-hidden="true"></i>
                            <b>(067) 25-333-05</b>
                        </div>

                        <div class="text-left pull-left">
                            <i class="fa fa-phone left" aria-hidden="true"></i>
                            <b>(093) 350-43-82 (Viber)</b>
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
                                <a href="{{url('/login')}}"><i class="fa fa-lock left" aria-hidden="true"></i><span
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
        <div id="header-sticky" class="header-main">
            <div class="header-main-inner">
                <!-- Logo -->
                <div class="logo">
                    <a href="{{url('/')}}">
                        <img src="{{asset('img/logo_black.png')}}" alt="Rostovka"/>
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
                                        <a href="{{url('checkout')}}" class="button checkour_cart">Купить</a>
                                    </span>
                                </span>

                            </li>
                        </ul>
                    </div>
                    <!-- End Sidebar Icon -->
                </div>
                <!-- End Right Sidebar Nav -->


                <!-- Navigation Menu -->
                <nav class="navigation-menu">
                    @include('user.markup.header')


                </nav>
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
                        <img src="{{url('img/logo_white.png')}}" width="400" alt="">
                    </div>
                </div>

                <div class="copyrights">
                    <p class="copyright">2018 &copy; Dev by<a href="http://comnd-x.com/" target="_blank">Command+X</a></p>
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

    </footer>
</div>

{{--<script id="Cart_template" src="{{asset('cartTmpl/cart.html')}}" type="text/x-jquery-tmpl"></script>--}}
<script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery-ui.js')}}"></script>
<!-- jquery library js -->
<script type="text/javascript" src="{{asset('js/modernizr.js')}}"></script>
<!--modernizr Js-->
<script type="text/javascript" src="{{asset('js/jquery.themepunch.revolution.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.themepunch.tools.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/revolution.extension.navigation.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/revolution.extension.parallax.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/revolution.extension.slideanims.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/revolution.extension.layeranimation.min.js')}}"></script>
<!--Slider Revolution Js File-->
<script type="text/javascript" src="{{asset('js/tether.min.js')}}"></script>
<!--Bootstrap tooltips require Tether (Tether Js)-->
<script type="text/javascript" src="{{asset('js/bootstrap.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrap-slider.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/bootstrapvalidator.min.js')}}"></script>
<!-- bootstrap js -->

<script type="text/javascript" src="{{asset('js/owl.carousel.js')}}"></script>
<!-- OWL carousel js -->
<!-- Slick Slider js -->
<script type="text/javascript" src="{{asset('js/slick.js')}}"></script>
<!-- Validator -->
<!-- Plugins All js -->
<script type="text/javascript" src="{{asset('js/plugins-all.js')}}"></script>
<script type="text/javascript" src="{{asset('js/jquery.tmpl.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/custom.js')}}"></script>
@yield('mainPage_Lib')
@yield('cartLib')
@yield('auth_reg')
@yield('category__Lib')
@yield('auth_lib')
@yield('productLib')
<script type="text/javascript" src="{{asset('js/cart.js')}}"></script>
<!-- custom js -->
<!-- end jquery -->
<script>
    $('.search--box button').on('click', function (e) {
        e.preventDefault();
        $(location).attr('href', '{{url("showFinderFinal")}}/' + $('.search--box input').val() );
    });
</script>
</body>
</html>