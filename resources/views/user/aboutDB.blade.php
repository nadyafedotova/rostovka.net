@extends('user.markup.markup')

@section('about_lib')
    <link rel="stylesheet" href="{{asset('css/themify-icons.css')}}" />
    <link rel="stylesheet" href="{{asset('css/base.css')}}" /> 
    <link rel="stylesheet" href="{{asset('css/elements.css')}}" />
    <!-- <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.css" rel="stylesheet"> -->
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
                                    {!! $about -> tab1 !!}
                                </div>
                            <!-- end tab content 01 -->
                            <!-- tab content 02 -->
                                <div id="tab2" class="elementToAnimate text-center center-col tab-pane">
                                    {!! $about -> tab2 !!}
                                </div>
                                            <!-- end tab content 02 -->
                                            <!-- tab content 03 -->
                                <div id="tab3" class="elementToAnimate text-center center-col tab-pane">
                                    {!! $about -> tab3 !!}               
                                </div>
                                            <!-- end tab content 03 -->
                                            <!-- tab content 04 -->
                                <div id="tab4" class="elementToAnimate text-left  center-col tab-pane">
                                    {!! $about -> tab4 !!}           
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


        @if (Auth::user() && Auth::user()->type = "admin")
            <!-- <textarea style="display:none" id="text" class="form-control border-input" type="text"></textarea> -->
        @endif
@endsection


@section('about_libjs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.7/summernote.js"></script>

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

            // $('#text').summernote();
        });
        </script>
@endsection