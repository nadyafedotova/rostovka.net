(function ($) {

    'use strict';

    function initNavbar() {
        if (!$('section:first').is('.parallax-bg, .dark-bg, .colored-bg') && $('#home-slider').length == 0) {
            $('#topnav').addClass('stick affix-top');
            $('body').addClass('top-padding');
        }

        if ($('section:first').is('.parallax-bg-text-dark')) {
            $('body').addClass('light-slide');
        }

        $('#topnav .navigation-menu a[data-scroll="true"], #aside-nav .navigation-menu a[data-scroll="true"]').on('click', function () {
            if ($(window).width() < 992) {
                $(".menu-toggle").click();
            }
        });

        $('body').scrollspy({
            target: '#navigation'
        });

        $('.menu-toggle').on('click', function (event) {
            event.preventDefault();
            $(this).toggleClass('is-active');

            $('#navigation').slideToggle(400);
            $('#topnav .cart-open').removeClass('opened');

        });

        $('.navigation-menu>li').slice(-2).addClass('last-elements');

        $('.navigation-menu li.menu-item-has-children>a').on('click', function (e) {
            if ($(window).width() < 992) {
                e.preventDefault();
                $(this).parent('li').toggleClass('opened').find('.submenu:first').toggleClass('opened');
            }
        });

        $('#scroll-section').on('click', function (event) {
            event.preventDefault();

            var parentSection = $(this).closest('section');
            var nextSection = parentSection.next('section');

            $('html,body').animate({
                scrollTop: nextSection.offset().top - 60
            }, 1000);

        });

        $('.open-search-form').on('click', function (e) {
            e.preventDefault();
            $('#search-modal').addClass('active');
            $('body').addClass('modal-open');
            $('#topnav .cart-open').removeClass('opened');
        });

        $('#close-search-modal').on('click', function (e) {
            e.preventDefault();
            $('#search-modal').removeClass('active');
            $('body').removeClass('modal-open');
        });

        $('#topnav').on('click', '.cart-open>a', function (event) {
            if ($(window).width() < 992) {
                event.preventDefault();
                event.stopPropagation();

                if ($('#navigation').is(':visible')) {
                    $('.menu-toggle').click();
                }

                $(this).parent('.cart-open').toggleClass('opened');
            }
        });
    }

    function initScroll() {
        $(window).scroll(function () {

            if ($('section:first').is('.parallax-bg, .dark-bg, #home, .colored-bg') || $('#home-slider').length) {

                if ($(window).width() > 991) {
                    if ($(window).scrollTop() >= $('#topnav').height() && $(window).scrollTop() <= 200) {
                        $('#topnav').addClass('op-0');
                    } else {
                        $('#topnav').removeClass('op-0');
                    }

                    if ($(window).scrollTop() >= 100) {
                        $('#topnav').addClass('stick');
                    } else {
                        $('#topnav').removeClass('stick');
                    }

                    if ($(window).scrollTop() > 400) {
                        $('#topnav').addClass('affix-top');
                    } else {
                        $('#topnav').removeClass('affix-top');
                    }
                }

            }

            if ($(window).scrollTop() >= 900) {
                $('.go-top').addClass('showed-up');
            } else {
                $('.go-top').removeClass('showed-up');
            }

            initParallax();

        }).trigger('scroll');
    }

    function initParallax() {
        $('.parallax-bg-element img').each(function (index, el) {
            var container = $(this).parent('.parallax-bg-element');
            var image = $(this).attr('src');

            $(container).css('background-image', 'url(' + image + ')');

            $(this).remove();
        });

        $('.parallax-wrapper, .img-holder').each(function (index, el) {
            var elOffset = $(el).parent().offset().top;
            var winTop = $(window).scrollTop();
            var scrll = (winTop - elOffset) * .15;

            if ($(el).isOnScreen()) {
                $(el).css('transform', 'translate3d(0, ' + (scrll) + 'px, 0)');
            }

        });
    }

    function initGeneral() {

        $("a[href='#top']").on('click', function () {
            $("html, body").animate({scrollTop: 0}, 1000);
            return false;
        });

        if ($('#home-slider').length) {
            $('body').addClass('has-home-slider');
        }

        $('#topnav .navigation-menu a[href*="#"], #aside-nav .navigation-menu a[href*="#"], a.btn[href*="#"]').not('[href="#"]').attr('data-scroll', 'true');

        $('a[data-scroll="true"]').on('click', function () {
            if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
                var target = $(this.hash);
                target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
                if (target.length) {
                    $('html,body').animate({
                        scrollTop: target.offset().top
                    }, 1000);
                    return false;
                }
            }
        });

        $('#home-slider').closest('section').css({
            'padding-top': 0,
            'padding-bottom': 0,
        });

        $('.bg-img, .thumb-placeholder, .box>img').each(function (index, el) {
            var image = $(el).attr('src');
            $(el).parent().css('background-image', 'url(' + image + ')');

            if ($(el).parent().hasClass('box')) {
                $(el).parent().addClass('box-with-image');
            }

            $(el).remove();
        });

        $('#topnav li a[data-hc-icon]').each(function (index, el) {
            var iconClass = $(el).data('hc-icon');
            var icon = '<i class="' + iconClass + '"></i>';

            $(el).prepend(icon);

        });

        $('[data-toggle="tooltip"]').tooltip();

        $('.alert').on('closed.bs.alert', function () {
            fixScroll();
        });

        $('a[data-toggle=tab]').on('shown.bs.tab', function (e) {

            $(window).trigger('resize');

            var container = $($(this).attr('href'));

            if (container.find('.progress-bar').length) {
                container.find('.progress-bar').each(function (index, el) {
                    $(el).css('width', $(this).data('progress') + '%');
                    $(el).parents('.skill').find('.skill-perc').css('right', 100 - $(el).data('progress') + '%');
                });
            }

        });

        $('body').on('click', '#newsletter-modal', function () {
            $(this).modal('hide');
        });

        $('body').on('click', '#newsletter-modal .modal-content', function (e) {
            e.stopPropagation();
        });

        $('.tab-content').each(function (index, el) {
            $(el).find('.tab-pane:first').addClass('active in');
        });

        $('.progress-bar').appear(function () {
            $(this).css('width', $(this).data('progress') + '%');
            $(this).parents('.skill').find('.skill-perc').css('right', 100 - $(this).data('progress') + '%');
        });

        $('.circle-bar-wrap').each(function (index, el) {
            $(el).appear(function () {

                var options = {
                    color: $(el).data('color'),
                    number: $(el).data('number'),
                    trailColor: $(el).data('color') == '#fff' ? 'rgba(255,255,255,0.25)' : '#eee'
                }

                var bar = new ProgressBar.Circle(el, {
                    strokeWidth: 1,
                    easing: 'easeInOut',
                    duration: 1400,
                    color: options.color,
                    trailColor: options.trailColor,
                    trailWidth: 1,
                    svgStyle: null,
                    text: {
                        autoStyleContainer: false
                    },
                    from: {color: options.color, width: 1},
                    to: {color: options.color, width: 1},
                    step: function (state, circle) {
                        circle.path.setAttribute('stroke', state.color);
                        circle.path.setAttribute('stroke-width', state.width);

                        var value = Math.round(circle.value() * 100);
                        if (value === 0) {
                            circle.setText('');
                        } else {
                            circle.setText(value);
                        }

                    }
                });

                bar.animate(options.number / 100);

            });

        });

        $('[data-negative-margin]').each(function (index, el) {
            $(el).css('margin-top', -$(el).data('negative-margin'));
        });

        $('.share-btn').on('click', function (event) {
            event.preventDefault();

            var left = ($(window).width() / 2) - (600 / 2),
                top = ($(window).height() / 2) - (400 / 2);

            window.open($(this).attr('href'), 'window', 'left=' + left + ',top=' + top + ',width=600,height=400,toolbar=0');
        });

    }


    function initHomeSlider() {

        $('#home-slider .slides>li>img').each(function (index, el) {
            var slide = $(this).parent('li');
            var image = $(this).attr('src');

            $(slide).prepend($('<div class="slide-image"></div>').css('background-image', 'url(' + image + ')'));

            if (navigator.userAgent.indexOf("Firefox") != -1 && $('#home').hasClass('bordered')) {
                $('.slide-image').addClass('ff-fix');
            }

            $(this).remove();
        });

        var options = {
            prevText: '<i class="hc-arrow-left"></i>',
            nextText: '<i class="hc-arrow-right"></i>',
            keyboard: true,
        };

        if ($('#home-slider .slides > li').length < 2) {
            options.directionNav = false
        }

        options.start = function () {
            var delay = 0;
            var currentSlide = $('#home-slider').find(".slides > li.flex-active-slide");

            if ($(currentSlide).find('.slide-wrap').hasClass('light')) {
                $('body').addClass('light-slide');
            } else {
                $('body').removeClass('light-slide');
            }

            $('#home-slider').find(".slides > li.flex-active-slide .slide-content > .container").children().each(function () {
                var $content = $(this);
                setTimeout(function () {
                    $content.css({
                        'opacity': 1,
                        '-webkit-transform': 'translateY(0)',
                        '-moz-transform': 'translateY(0)',
                        'transform': 'translateY(0)',
                    });

                }, delay);

                delay += 200;
            })
        }

        options.before = function () {
            $('#home-slider').find(".slides > li .slide-content > .container").children().each(function () {
                var $content = $(this);
                $content.css({
                    'opacity': 0,
                    '-webkit-transform': 'translateY(20px)',
                    '-moz-transform': 'translateY(20px)',
                    'transform': 'translateY(20px)',
                });
            })
        }

        options.after = options.start;

        $('#home-slider').flexslider(options);

        $(window).resize(function (event) {

            $('#home-slider .slide-content').each(function (index, el) {
                if ($(el)[0].scrollWidth > $(el).innerWidth() && $(window).width() < 768) {
                    $(el).find('h1').addClass('xs-smaller-font');
                }
            });

        }).trigger('resize');

    }
    

    function init() {

        $.fn.isOnScreen = function () {
            var viewport = {};
            viewport.top = $(window).scrollTop();
            viewport.bottom = viewport.top + $(window).height();
            var bounds = {};
            bounds.top = this.offset().top;
            bounds.bottom = bounds.top + this.outerHeight();
            return ((bounds.top <= viewport.bottom) && (bounds.bottom >= viewport.top));
        };

        initHomeSlider();
        initGeneral();
        initScroll();
        initNavbar();
    }

    init();

})(jQuery);


// init Isotope
var $grid = $('.grid').isotope({
    itemSelector: '.element-item',
    layoutMode: 'fitRows',
    percentPosition: true
});

// filter functions
var filterFns = {
    // show if number is greater than 50
    numberGreaterThan50: function () {
        var number = $(this).find('.number').text();
        return parseInt(number, 10) > 50;
    },
    // show if name ends with -ium
    ium: function () {
        var name = $(this).find('.name').text();
        return name.match(/ium$/);
    }
};

// bind filter button click
$('.filters-button-group').on('click', 'button', function () {
    var filterValue = $(this).attr('data-filter');
    // use filterFn if matches value
    filterValue = filterFns[filterValue] || filterValue;
    $grid.isotope({filter: filterValue});
});

// change is-checked class on buttons
$('.button-group').each(function (i, buttonGroup) {
    var $buttonGroup = $(buttonGroup);
    $buttonGroup.on('click', 'button', function () {
        $buttonGroup.find('.is-checked').removeClass('is-checked');
        $(this).addClass('is-checked');
    });
});


function getOptions(event) {
    var dataID = Number (event.target.offsetParent.offsetParent.offsetParent.dataset.id),
        productImage = $.find('[data-id="'+ dataID +'"] .product-thumb img')[0].currentSrc,
        productName = $.find('[data-id="'+ dataID +'"] h4')[0].innerText,
        productID = $.find('[data-id="'+ dataID +'"] .id-goods')[0].innerText,
        productPrice = $.find('[data-id="'+ dataID +'"] .itemPrice')[0].innerText;

    //all
    $.find('.productForm .product-thumb img')[0].attributes[0].value = productImage;
    $.find('.productForm .mname')[0].innerText = productName;
    $.find('.productForm .mid')[0].innerText = productID;
    $.find('.productForm .mprice')[0].innerText = productPrice;


    //mans
    $.find('.mans .product-thumb img')[0].attributes[0].value = productImage;
    $.find('.mans .mname')[0].innerText = productName;
    $.find('.mans .mid')[0].innerText = productID;
    $.find('.mans .mprice')[0].innerText = productPrice;
}

var manformArray = [], formArray = [];



$(".productForm").validate({
    rules: {
        csname: {
            required: true
        },

        csnumber: {
            required: true
        },

        size: {
            required: true
        }

    },
    messages: {
        csname: {
            required: "Р’РІРµРґРёС‚Рµ РІР°С€Рµ РёРјСЏ"
        },

        csnumber: {
            required: "Р’РІРµРґРёС‚Рµ РІР°С€ РЅРѕРјРµСЂ С‚РµР»РµС„РѕРЅР°"
        },

        size: {
            required: "Р’С‹Р±РµСЂРёС‚Рµ СЂР°Р·РјРµСЂ"
        }
    },
    submitHandler: function() {
        var selectNum = Number ($('.productForm select')[0].selectedIndex),
            indexOfoption = $('.productForm select')[0][selectNum],
            optionValue = $(indexOfoption)[0].innerText,
            nameOfClient = $('.productForm .user-name')[0].lastElementChild.value,
            clientPhone = $('.productForm .phone-number')[0].lastElementChild.value,
            productName = $('.productForm .mname')[0].innerText,
            productmID = Number ($('.productForm .mid')[0].innerText.replace("ID: ", "")),
            productMPrice = $('.productForm .mprice')[0].innerText;

        formArray.push({
            client: nameOfClient,
            phone: clientPhone,
            prodName: productName,
            prodID: productmID,
            prodPrice: productMPrice,
            size: optionValue
        });

        if(formArray.length > 0){
            $.ajax({
                method: "POST",
                url: "send_product.php",
                data: {array : formArray[0]}
            }).done(function (msg) {
                $('.product-modal').modal('hide');
                $('.sendedModal').modal('show');
                formArray = [];
            });
        }
    }
});

$(".product-modal-men .mans").validate({
    rules: {
        csname: {
            required: true
        },

        csnumber: {
            required: true
        },

        size: {
            required: true
        }

    },
    messages: {
        csname: {
            required: "Р’РІРµРґРёС‚Рµ РІР°С€Рµ РёРјСЏ"
        },

        csnumber: {
            required: "Р’РІРµРґРёС‚Рµ РІР°С€ РЅРѕРјРµСЂ С‚РµР»РµС„РѕРЅР°"
        },

        size: {
            required: "Р’С‹Р±РµСЂРёС‚Рµ СЂР°Р·РјРµСЂ"
        }
    },
    submitHandler: function() {
        var selectNum = Number ($('.product-modal-men .mans select')[0].selectedIndex),
            indexOfoption = $('.product-modal-men .mans select')[0][selectNum],
            optionValue = $(indexOfoption)[0].innerText,
            nameOfClient = $('.product-modal-men .mans .user-name')[0].children[1].value,
            clientPhone = $('.product-modal-men .mans .phone-number')[0].children[1].value,
            productName = $('.product-modal-men .mans .mname')[0].innerText,
            productmID = Number ($('.product-modal-men .mans .mid')[0].innerText.replace("ID: ", "")),
            productMPrice = $('.product-modal-men .mans .mprice')[0].innerText;


        manformArray.push({
            client: nameOfClient,
            phone: clientPhone,
            prodName: productName,
            prodID: productmID,
            prodPrice: productMPrice,
            size: optionValue
        });

        if(manformArray.length > 0){

            $.ajax({
                method: "POST",
                url: "send_product.php",
                data: {array : manformArray[0]}
            }).done(function () {
                $('.product-modal-men').modal('hide');
                $('.sendedModal').modal('show');
                manformArray = [];
            });
        }


    }
});

$(document).on('click', '[data-callme-config="main"]', function () {
    var textfield = $.find('.callme-field textarea')[0].parentNode,
        phoneInput = $.find('[type="tel"]');

    $(textfield).addClass('textField');

    $(phoneInput).keyup(function()
    {
        if (/\D/g.test(this.value))
        {
            this.value = this.value.replace(/\D/g, '');
        }
    });
});