@extends('user.markup.markup')

@section('about_lib')
    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('css/base.css')}}" /> 
    <link rel="stylesheet" href="{{asset('css/elements.css')}}" />
@endsection

@section('aboutPage')
<div id="page" class="page">
<section style="background-color: white; outline-offset:-3px; padding-top:50px; padding-bottom:50px;">
            <div class="container position-relative">
                <div class="row">
                <!-- section title -->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center elementToAnimate1">
                        <h2 class="section-title-large sm-section-title-medium xs-section-title-large font-weight-600 alt-font margin-three-bottom xs-margin-fifteen-bottom" style="padding-bottom: 50px;">ROSTOVKA</h2>
                    </div>
                <!-- end section title -->
                <!-- animated-tab -->
                    <div class="col-md-12 col-sm-12 col-xs-12 text-center no-padding tab-style2 elementToAnimate1">
                <!-- tab navigation -->
                        <ul class="nav nav-tabs margin-ten-bottom tabs">
                            <li class="nav" style="display: block;">
                                <a href="#tab1" class="sm-margin-bottom-10px" style="margin-bottom: 6px;"><img src="{{asset('img/store.svg')}}" data-selector="img" style="width: 60px; height: 60px;">
                                </a>
                                    <span class="font-weight-500 alt-font text-dark-gray margin-seventeen-bottom display-block tz-text" data-selector=".tz-text">О МАГАЗИНЕ</span>
                                </li>
                                <li class="nav" style="display: block;">
                                    <a href="#tab2" class="margin-bottom-15px sm-margin-bottom-10px" style=""><img src="{{asset('img/box.svg')}}" data-selector="img" style="width: 50px; height: 50px;"></a>
                                    <span class="font-weight-500 alt-font text-dark-gray margin-seventeen-bottom display-block tz-text" style="padding-top: 9px;" data-selector=".tz-text">ДОСТАВКА</span>
                                </li>
                                <li class="nav" style="display: block;">
                                    <a href="#tab3" class="margin-bottom-15px sm-margin-bottom-10px"><img src="{{asset('img/cash.svg')}}" data-selector="img" style="width: 50px; height: 50px;"></a>
                                    <span class="font-weight-500 alt-font text-dark-gray margin-seventeen-bottom display-block tz-text"  style="padding-top: 9px;" data-selector=".tz-text">ОПЛАТА</span>
                                </li>
                                <li class="nav" style="display: block;">
                                    <a href="#tab4" class="margin-bottom-15px sm-margin-bottom-10px"><img src="{{asset('img/return.svg')}}" data-selector="img" style="width: 50px; height: 50px;"></a>
                                    <span class="font-weight-500 alt-font text-dark-gray margin-seventeen-bottom display-block tz-text"  style="padding-top: 9px;" data-selector=".tz-text">ВОЗВРАТ И ОБМЕН</span>
                                </li>
                            </ul>
                <!-- end tab navigation -->
                <!-- tab content section -->
                    <div class="tab-content">
                <!-- tab content 01 -->
                    <div id="tab1" class="elementToAnimate text-left center-col tab-pane active">
                    <section class="xs-padding-60px-tb" style="border:none;">
                        <div class="container" style="font-weight: 400; font-family: 'Open Sans', sans-serif; text-transform: none; border-radius: 0px; color: rgb(0, 0, 0) !important; font-size: 16px !important; color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif;">
                            <div class="row">
                <!-- section title -->
                                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                    <div class=" width-100 margin-lr-auto md-width-70 sm-width-100 tz-text margin-thirteen-bottom xs-margin-nineteen-bottom">
                                    Компания ROSTOVKA надежный поставщик обуви, предоставляющий широкий спектр услуг, которые позволяют вам, не выходя из дома или офиса в любом регионе Украины и ближнего зарубежья, подобрать необходимые модели и купить обувь оптом. Уже на протяжении многих лет занимается оптовой продажей комфортной и модельной детской, женской и мужской обуви.
                                    </div>
                                </div>
                <!-- end section title -->
                            </div>
                            <div class="row two-column">
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center margin-four-bottom xs-margin-nineteen-bottom">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                        <img src="{{asset('img/1.svg')}}">
                                    </div>  
                                    <div class="col-lg-10 col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100"> 
                                            <p class="text-black">У нас широкий ассортимент модельной качественной обуви из натуральных и искусственных материалов.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center margin-four-bottom xs-margin-nineteen-bottom">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                        <img src="{{asset('img/2.svg')}}"> 
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100 tz-text"> 
                                            <p class="no-margin-bottom text-black">Каталог нашей продукции позволит Вам найти модель на любой вкус.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center xs-margin-nineteen-bottom">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                        <img src="{{asset('img/3.svg')}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100 tz-text"> 
                                            <p class="no-margin-bottom text-black">Компания ROSTOVKA заботится о том, чтобы предложить потребителю более качественную и удобную обувь.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                        <img src="{{asset('img/4.svg')}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100"> 
                                            <p class="no-margin-bottom text-black">Мы работаем с фабриками Китая, Польши, Турции, Украины.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center xs-margin-nineteen-bottom" style="padding-top:35px;">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                       <img src="{{asset('img/5.svg')}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100"> 
                                            <p class="no-margin-bottom text-black">Предлагаем вам оптимальное сочетание цены и качества.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center" style="padding-top:35px;">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                        <img src="{{asset('img/6.svg')}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100"> 
                                            <p class="no-margin-bottom text-black">Каждодневное обновление каталога.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center xs-margin-nineteen-bottom" style="padding-top:35px;">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom">
                                        <img src="{{asset('img/7.svg')}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100"> 
                                            <p class="no-margin-bottom text-black">Быстрая обработка заказа и его комплектация.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                <!-- feature box -->
                                <div class="col-md-6 col-sm-6 col-xs-12 xs-text-center" style="padding-top:35px;">
                                    <div class="container">
                                        <div class="row">
                                    <div class="col-md-2 col-sm-2 col-xs-4 xs-margin-seven-bottom" style="align-items: center;">
                                        <img src="{{asset('img/8.svg')}}">
                                    </div>
                                    <div class="col-md-10 col-sm-10 col-xs-8 feature-box-details">
                                        <div class="text-medium float-left width-100"> 
                                            <p class="no-margin-bottom text-black">Быстрая реакция Менеджера, Своевременная отправка.</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                                </div>
                <!-- end feature box -->
                            </div>
                            <div class="row" style="padding-top:50px;">
                <!-- section title -->
                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                <div class="width-60 margin-lr-auto md-width-70 sm-width-100 tz-text margin-thirteen-bottom xs-margin-nineteen-bottom">
                                    Режим работы: С 8:00 до 18:00 Выходной (Пятница).
                                </div>
                            </div>
                <!-- end section title -->
                            </div> 
                        </div>
                    </section>
                    </div>
                <!-- end tab content 01 -->
                <!-- tab content 02 -->
                    <div id="tab2" class="elementToAnimate text-center center-col tab-pane">
                    <section style="border:none; background-color: rgb(255, 255, 255); padding-left: 0px; padding-right: 0px; border-color: rgb(112, 112, 112); padding-bottom: 10px !important;">
                                        <div class="container">
                                            <div class="row">
                                            <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                                            <div class="text-medium width-100 margin-lr-auto md-width-70 sm-width-100 tz-text" style="background-color: rgba(0, 0, 0, 0); font-weight: 400; font-family: 'Open Sans', sans-serif; text-transform: none; border-radius: 0px; color: rgb(0, 0, 0) !important; font-size: 16px !important;" id="ui-id-11"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Доставка заказа осуществляется любой транспортной компанией или иным доступным способом доставки товара по выбору клиента, также вы можете забрать ваш заказ у нас на складе, или мы можем подвести ваш заказ к указанному вами транспортному средству. Мы работаем с такими перевозчиками как:</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        </section>
                        <section id="clients-section4" class="padding-110px-tb bg-white builder-bg clients-section4 xs-padding-60px-tb" style="background-color: rgb(255, 255, 255); padding-left: 0px; padding-right: 0px; padding-top: 15px !important; padding-bottom: 15px !important; border-color: rgb(255, 255, 255) !important;">
                            <div class="container">
                                <div class="row">
                                    <!-- clients logo -->
                                    <div class="col-md-3 col-sm-6 col-xs-12">
                                        <div class="client-logo-outer"><div class="client-logo-inner"><a><img src="{{asset('img/Nova-Pochta.jpg')}}" data-img-size="(W)800px X (H)500px" alt="" style="border-radius: 0px; border-color: rgb(78, 78, 78); border-style: none; border-width: 1px !important;" id="ui-id-44"></a></div></div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="padding-top:10px;">
                                        <div class="client-logo-outer"><div class="client-logo-inner"><a><img src="{{asset('img/Nova-Pochtaa.jpg')}}" data-img-size="(W)800px X (H)500px" alt="" style="border-radius: 0px; border-color: rgb(78, 78, 78); border-style: none; border-width: 1px !important;" id="ui-id-45"></a></div></div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="padding-top:25px;">
                                        <div class="client-logo-outer"><div class="client-logo-inner"><a><img src="{{asset('img/logo-avtolux.png')}}" data-img-size="(W)800px X (H)500px" alt="" style="border-radius: 0px; border-color: rgb(78, 78, 78); border-style: none; border-width: 1px !important;" id="ui-id-46"></a></div></div>
                                    </div>
                                    <div class="col-md-3 col-sm-6 col-xs-12" style="padding-top:25px;">
                                        <div class="client-logo-outer"><div class="client-logo-inner"><a><img src="{{asset('img/Логотип_Ін-Тайм.png')}}" data-img-size="(W)800px X (H)500px" alt="" style="border-radius: 0px; border-color: rgb(78, 78, 78); border-style: none; border-width: 1px !important;" id="ui-id-47"></a></div></div>
                                    </div>
                                    <!-- end clients logo -->
                                </div>
                            </div>
                        </section>
                        <section class="padding-110px-tb xs-padding-60px-tb bg-white builder-bg" id="title-section13" style="background-color: rgb(255, 255, 255); padding-left: 0px; padding-right: 0px; padding-top: 50px !important; padding-bottom: 50px !important; border-color: rgb(255, 255, 255) !important;">
                            <div class="container">
                                <!-- section title -->
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 title-small sm-title-small">
                                        <span class="text-large text-fast-blue alt-font letter-spacing-2 tz-text xs-margin-seven-bottom" style="color: rgb(57, 102, 230); background-color: rgba(0, 0, 0, 0); font-weight: 400; font-family: Montserrat, sans-serif; text-transform: none; border-radius: 0px; font-size: 18px !important;" id="ui-id-19"><span style="color: rgb(255, 0, 0); font-family: 'Open Sans', sans-serif; font-weight: 600; text-align: justify;">За сохранность груза при перевозке ответственность за груз несет компания перевозчика</span></span>
                                        <div class="text-medium display-block margin-three-top margin-six-bottom tz-text xs-margin-nine-bottom" style="text-align: justify;"><p><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; font-size: 15px; text-align: justify;">Также на доставку и оперативность сбора заказа влияют такие факторы, как внимательное заполнение полей для регистрации (так не правильно указанный номер тел. или не точный адрес, приводят к задержке сбора заказа и отправке груза) Компания ROSTOVKA заботится о своих клиентах и нам важно чтоб при осуществлении доставки Вы получали свой груз без задержек, проблем и в полной комплектации.&nbsp;</span></p></div>                  
                                        <div class="text-medium display-block margin-three-top margin-six-bottom tz-text xs-margin-nine-bottom" style="text-align: justify;"><p><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; font-size: 15px; text-align: justify;">Для того чтоб у нас с Вами было меньше спорных вопросов рекомендуем Вам осматривать груз при получении. Внимательно осмотреть целостность коробов, только убедившись, что информация о вашем грузе соответствует данным указанным в товарной накладной, подписывайте документы.&nbsp;</span></p></div>
                                        <div class="text-medium display-block margin-three-top margin-six-bottom tz-text xs-margin-nine-bottom" style="text-align: justify;"><p><span class="red" style="color: red; font-weight: 600; font-family: 'Open Sans', sans-serif; font-size: 15px; text-align: justify;">При заказе от 20 ящиков</span><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; font-size: 15px; text-align: justify;">&nbsp;доставка на отделение почты бесплатная</span></p></div>
                                    
                                    
                                </div>
                                <!-- end section title -->
                            </div>
                        </div>
                    </section>
                                </div>
                                <!-- end tab content 02 -->
                                <!-- tab content 03 -->
                                <div id="tab3" class="elementToAnimate text-center center-col tab-pane">
                                    <section class=" feature-style4 bg-white builder-bg xs-padding-60px-tb" id="feature-section6" style="background-color: rgb(255, 255, 255); padding-left: 0px; padding-right: 0px; border-color: rgb(112, 112, 112) rgb(112, 112, 112) rgb(236, 236, 236); padding-top: 0px; border: none; ">
                <div class="container">
                    <div class="row">
                        <!-- section title -->
                        <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                            <div class="text-medium width-60 margin-lr-auto md-width-70 sm-width-100 tz-text margin-thirteen-bottom xs-margin-nineteen-bottom" style="color: rgb(112, 112, 112); background-color: rgba(0, 0, 0, 0); font-weight: 400; font-family: 'Open Sans', sans-serif; text-transform: none; border-radius: 0px; font-size: 16px !important;" id="ui-id-58"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Оплата осуществляется следующим образам:</span><ul class="payment" style="margin: 20px 0px; padding: 0px; list-style-type: none; color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;"></ul><div><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">
</span></div></div>
                        </div>
                        <!-- end section title -->
                    </div>
                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12n four-column">
                            <!-- feature box -->
                            <div class="container">
                            <div class="row">
                            <div class="col-md-4 col-sm-6 col-xs-12 text-center sm-margin-nine-bottom xs-margin-nineteen-bottom">
                                <div class="border-radius-50 bg-cyan text-white icon-extra-large line-height-75 feature-icon builder-bg margin-nineteen-bottom sm-margin-sixteen-bottom xs-margin-nine-bottom" style="padding: 24px; border-color: rgb(255, 255, 255); background-color: rgb(57, 102, 230) !important;" id="ui-id-52"><i class="fa tz-icon-color fa-credit-card" aria-hidden="true" style="color: rgb(255, 255, 255); font-size: 50px; background-color: rgba(0, 0, 0, 0); padding-top: 10px;" id="ui-id-55"></i></div>
                                <h3 class="text-medium text-dark-gray font-weight-600 alt-font  display-block sm-margin-nine-bottom xs-margin-five-bottom tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Оплата на банковскую карту</span></h3>
                                <span style="font-size: 12px;">(оплата при получении в отделении перевозчика)</span>
                                
                            </div>
                            <!-- end feature box -->
                            <!-- feature box -->
                            <div class="col-md-4 col-sm-6 col-xs-12 text-center sm-margin-nine-bottom xs-margin-nineteen-bottom">
                                <div class="border-radius-50 bg-cyan text-white icon-extra-large line-height-75 feature-icon builder-bg margin-nineteen-bottom sm-margin-sixteen-bottom xs-margin-nine-bottom" style="padding: 24px; border-color: rgb(255, 255, 255); background-color: rgb(57, 102, 230) !important;" id="ui-id-53"><i class="fa tz-icon-color fa-list-alt" aria-hidden="true" style="color: rgb(255, 255, 255); font-size: 50px; background-color: rgba(0, 0, 0, 0); padding-top:10px" id="ui-id-56"></i></div>
                                <h3 class="text-medium text-dark-gray font-weight-600 alt-font  display-block sm-margin-nine-bottom xs-margin-five-bottom tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Наложенный платеж</span></h3>
                                <span style="font-size: 12px;">(оплата при получении в отделении перевозчика)</span>

                                
                            </div>
                            <!-- end feature box -->
                            <!-- feature box -->
                            <div class="col-md-4 col-sm-6 col-xs-12 text-center xs-margin-nineteen-bottom">
                                <div class="border-radius-50 bg-cyan text-white icon-extra-large line-height-75 feature-icon builder-bg margin-nineteen-bottom sm-margin-sixteen-bottom xs-margin-nine-bottom" style="padding: 24px; border-color: rgb(255, 255, 255); background-color: rgb(57, 102, 230) !important;" id="ui-id-54"><i class="fa tz-icon-color fa-money" aria-hidden="true" style="color: rgb(255, 255, 255); font-size: 50px; background-color: rgba(0, 0, 0, 0); padding-top:10px" id="ui-id-57"></i></div>
                                <h3 class="text-medium text-dark-gray font-weight-600 alt-font margin-six-bottom display-block sm-margin-nine-bottom xs-margin-five-bottom tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Наличными</span></h3>
                                
                            </div>
                            <!-- end feature box -->
                        </div>
                    </div>
                        </div>
                    </div>
                </div>
            </section>
                                </div>
                                <!-- end tab content 03 -->
                                <!-- tab content 04 -->
                                <div id="tab4" class="elementToAnimate text-left  center-col tab-pane">
                                   <section class=" bg-white builder-bg xs-padding-60px-tb" id="feature-section4" style="border: none;">
                <div class="container">
                    <div class="row one-column" style="padding-left:45px;">
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium float-left text-sky-blue vertical-align-middle margin-seven-right tz-text"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px; transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Возврат принимается только в оригинальных коробках</span></h3>
                            
                        </div>
                        <!-- end feature box -->
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium text-sky-blue float-left vertical-align-middle margin-seven-right"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px;  transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Запах от обуви также не считается браком</span></h3>
                            
                        </div>
                        <!-- end feature box -->
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium text-sky-blue float-left vertical-align-middle margin-seven no-margin-tb no-margin-left"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px;  transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Также не принимаются возврат обуви если она вам просто не понравилась.</span></h3>
                            
                        </div>
                        <!-- end feature box -->
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12  margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium text-sky-blue float-left vertical-align-middle margin-seven no-margin-tb no-margin-left"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px;  transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Фото на сайте может отличатся от оригинала тоном и это не является браком</span></h3>
                        </div>
                        <!-- end feature box -->
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium text-sky-blue float-left vertical-align-middle margin-seven no-margin-tb no-margin-left"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px;  transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Если возврат отправлен наложеным платежом,от такого заказа будет отказ</span></h3>
                            
                        </div>
                        <!-- end feature box -->
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium text-sky-blue float-left vertical-align-middle margin-seven no-margin-tb no-margin-left"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px;  transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">Про фабричный брак, распаковку, или ошибку сотрудников компании, надо сообщить немедленно</span>
</h3>
                            
                        </div>
                        <!-- end feature box -->
                        <!-- feature box -->
                        <div class="col-md-12 col-sm-6 col-xs-12 margin-three-bottom xs-margin-ten-bottom">
                            <div class="icon-medium text-sky-blue float-left vertical-align-middle margin-seven no-margin-tb no-margin-left"><img src="{{asset('img/po.svg')}}" alt="" style="width: 75px; height: 50px;  transform: rotate(35deg);"></div>
                            <h3 class="text-medium font-weight-600 text-dark-gray overflow-hidden vertical-align-middle line-height-30 tz-text"><span style="color: rgb(51, 51, 51); font-family: 'Open Sans', sans-serif; text-align: justify;">При возврате продукции по причине ошибки нашего сотрудника, транспортные расходы оплачивает интернет магазин</span>
</h3>
                            
                        </div>
                        <!-- end feature box -->
                    </div>
                </div>
            </section>
                                </div>
                                <!-- end tab content 04 -->
                                <!-- tab content 05 -->
                                
                                <!-- end tab content 06 -->
                            </div>
                            <!-- end tab content section -->
                        </div>
                        <!-- end animated-tab -->
                    </div>
                </div>
            </section>
        </div>
@endsection


@section('about_libjs')
    <script>
        $(document).ready(function() {
            $('ul.tabs').each(function(){
              var $active, $content, $links = $(this).find('a');

              $active = $($links.filter('[href="'+location.hash+'"]')[0] || $links[0]);
              $active.addClass('active');

              $content = $($active[0].hash);

              $links.not($active).each(function () {
                $(this.hash).hide();
              });

              $(this).on('click', 'a', function(e){
                $active.removeClass('active');
                $content.hide();
                $active = $(this);
                $content = $(this.hash);
                $active.addClass('active');
                $content.show();
                e.preventDefault();
              });
            });
        });
        </script>
@endsection