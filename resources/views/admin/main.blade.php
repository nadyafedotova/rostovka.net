<!doctype html>
<html lang="ua">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="{{url('admin/img/apple-icon.png')}}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{url('assets/img/favicon.png')}}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

    <title>Rostovka.net Dashboard</title>

    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <meta name="root-site" content="{!!route('root')!!}">
    <meta name="csrf-token" content="{!! csrf_token() !!}">

    <!-- Bootstrap core CSS     -->
    <link href="{{url('css/admin/bootstrap.min.css')}}" rel="stylesheet" />

    <!-- Animation library for notifications   -->
    <link href="{{url('css/admin/animate.min.css')}}" rel="stylesheet"/>

    <!--  Paper Dashboard core CSS    -->
    <link href="{{url('css/admin/paper-dashboard.css')}}" rel="stylesheet"/>

    <!--  CSS for Demo Purpose, don't include it in your project -->
    <link href="{{url('css/admin/demo.css')}}" rel="stylesheet" />

    <!--  Fonts and icons     -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Istok+Web:400,700&amp;subset=cyrillic,cyrillic-ext" rel="stylesheet">
    <link href="{{url('css/admin/themify-icons.css')}}" rel="stylesheet">

    @yield('edit_userCss')
    @yield('productsCss')
    @yield('product_addCss')
    @yield('filterPage_Css')
    @yield('ordersCss')
    @yield('orderInfo_Css')
    @yield('optionsCss')
    @yield('suppliersCss')
</head>
<body>

<div class="wrapper">
    <div class="sidebar" data-background-color="white" data-active-color="danger">

        <div class="sidebar-wrapper">
            <div class="logo">
                <a href="{{url("admin_index")}}" class="simple-text">
                    Rostovka.net
                </a>
            </div>
            <ul class="nav">
                @if(Auth::user()->type == 'admin' )
                <li id="users" @if(Request::route()->getName() == "adminIndex") class="active" @endif>
                    <a href="{{url('admin_index')}}">
                        <i class="ti-user"></i>
                        <p>Пользователи</p>
                    </a>
                </li>
                @endif
                <li id="products" @if(Request::route()->getName() == "products") class="active" @endif>
                    <a href="{{url('products')}}">
                        <i class="ti-view-list-alt"></i>
                        <p>Товары</p>
                    </a>
                </li>

                @if(Auth::user()->type == 'admin' )
                <li id="orders" @if(Request::route()->getName() == "orders") class="active" @endif>
                    <a href="{{url('orders')}}">
                        <i class="ti-pencil-alt2"></i>
                        <p>Заказы</p>
                    </a>
                </li>
                @endif

                @if(Auth::user()->type == 'admin' )
                <li id="orders" @if(Request::route()->getName() == "adminBrands") class="active" @endif>
                    <a href="{{url('admin/brands')}}">
                        <i class="ti-image"></i>
                        <p>Бренды</p>
                    </a>
                </li>
                @endif

                <li id="suppliers" @if(Request::route()->getName() == "suppliers") class="active" @endif >
                    <a href="{{url('suppliers')}}">
                        <i class="ti-package"></i>
                        <p>Поставщики</p>
                    </a>
                </li>

                <li id="suppliers" @if(Request::route()->getName() == "types") class="active" @endif >
                    <a href="{{url('type')}}">
                        <i class="ti-package"></i>
                        <p>Фильтры</p>
                    </a>
                </li>

                @if(Auth::user()->type == 'admin' )
                <li id="seo" @if(Request::route()->getName() == "adminSeo") class="active" @endif>
                    <a href="{{url('seo')}}">
                        <i class="ti-bar-chart"></i>
                        <p>SEO</p>
                    </a>
                </li>
                @endif

                @if(Auth::user()->type == 'admin' )
                <li id="seo" @if(Request::route()->getName() == "adminTop") class="active" @endif>
                    <a href="{{url('top')}}">
                        <i class="ti-bar-chart"></i>
                        <p>ТОП ТОВАРОВ</p>
                    </a>
                </li>
                @endif

                @if(Auth::user()->type == 'admin' )
                <li id="seo" @if(Request::route()->getName() == "adminFool") class="active" @endif>
                    <a href="{{url('fools')}}">
                        <i class="ti-lock"></i>
                        <p>Проблемные клиенты</p>
                    </a>
                </li>
                @endif

                @if(Auth::user()->type == 'admin' )
                <li id="seo" @if(Request::route()->getName() == "adminAbout") class="active" @endif>
                    <a href="{{url('admin/about')}}">
                        <i class="ti-marker"></i>
                        <p>О нас</p>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="main-panel">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar bar1"></span>
                        <span class="icon-bar bar2"></span>
                        <span class="icon-bar bar3"></span>
                    </button>
                    <a class="navbar-brand" target="_blank" href="{{url("/")}}">Перейти на сайт</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a href="{{url("/personal")}}">
                                <i class="ti-settings"></i>
                                <p>Настройки</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>



        @yield('all_user')
        @yield('edit_user')
        @yield('products_container')
        @yield('add_product_content')
        @yield('filterPage_content')
        @yield('orders_container')
        @yield('orderInfo_content')
        @yield('options_container')
        @yield('suppliers_container')
        @yield('editingFilters')

        <footer class="footer">
            <div class="container-fluid">
                <div class="copyright pull-right">
                    &copy; <script>document.write(new Date().getFullYear())</script>, rostovka.net
                </div>
            </div>
        </footer>
    </div>
</div>


</body>

<!--   Core JS Files   -->
<script src="{{url('js/admin/jquery-1.10.2.js?n=3')}}" type="text/javascript"></script>
<script src="{{url('js/admin/bootstrap.min.js?n=3')}}" type="text/javascript"></script>

<!--  Checkbox, Radio & Switch Plugins -->
<script src="{{url('js/admin/bootstrap-checkbox-radio.js?n=3')}}"></script>

<!--  Notifications Plugin    -->
<script src="{{url('js/admin/bootstrap-notify.js?n=3')}}"></script>

<!-- Sweet Alert -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/6.11.0/sweetalert2.all.min.js"></script>

<!-- Paper Dashboard Core javascript and methods for Demo purpose -->
<script src="{{url('js/admin/paper-dashboard.js?n=3')}}"></script>

<!-- Paper Dashboard DEMO methods, don't include it in your project! -->
<script src="{{url('js/admin/demo.js?n=3')}}"></script>

<script type="text/javascript" src="{{asset('js/jquery.tmpl.min.js?n=3')}}"></script>

@yield('edit_userLib')
@yield('productsLib')
@yield('product_addLib')
@yield('filterPage_Lib')
@yield('ordersLib')
@yield('optionsLib')
@yield('suppliersLib')
@yield('filterPageLIb')

</html>
