/*!
    
 =========================================================
 * Paper Dashboard - v1.1.2
 =========================================================
 
 * Product Page: http://www.creative-tim.com/product/paper-dashboard
 * Copyright 2017 Creative Tim (http://www.creative-tim.com)
 * Licensed under MIT (https://github.com/creativetimofficial/paper-dashboard/blob/master/LICENSE.md)
 
 =========================================================
 
 * The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.
 
 */


var fixedTop = false;
var transparent = true;
var navbar_initialized = false;

$(document).ready(function(){
    window_width = $(window).width();

    // Init navigation toggle for small screens
    if(window_width <= 991){
        pd.initRightMenu();
    }

    //  Activate the tooltips
    $('[rel="tooltip"]').tooltip();

});

// activate collapse right menu when the windows is resized
$(window).resize(function(){
    if($(window).width() <= 991){
        pd.initRightMenu();
    }
});

pd = {
    misc:{
        navbar_menu_visible: 0
    },
    checkScrollForTransparentNavbar: debounce(function() {
        if($(document).scrollTop() > 381 ) {
            if(transparent) {
                transparent = false;
                $('.navbar-color-on-scroll').removeClass('navbar-transparent');
                $('.navbar-title').removeClass('hidden');
            }
        } else {
            if( !transparent ) {
                transparent = true;
                $('.navbar-color-on-scroll').addClass('navbar-transparent');
                $('.navbar-title').addClass('hidden');
            }
        }
    }),
    initRightMenu: function(){
         if(!navbar_initialized){
            $off_canvas_sidebar = $('nav').find('.navbar-collapse').first().clone(true);

            $sidebar = $('.sidebar');
            sidebar_bg_color = $sidebar.data('background-color');
            sidebar_active_color = $sidebar.data('active-color');

            $logo = $sidebar.find('.logo').first();
            logo_content = $logo[0].outerHTML;

            ul_content = '';

            // set the bg color and active color from the default sidebar to the off canvas sidebar;
            $off_canvas_sidebar.attr('data-background-color',sidebar_bg_color);
            $off_canvas_sidebar.attr('data-active-color',sidebar_active_color);

            $off_canvas_sidebar.addClass('off-canvas-sidebar');

            //add the content from the regular header to the right menu
            $off_canvas_sidebar.children('ul').each(function(){
                content_buff = $(this).html();
                ul_content = ul_content + content_buff;
            });

            // add the content from the sidebar to the right menu
            content_buff = $sidebar.find('.nav').html();
            ul_content = ul_content + '<li class="divider"></li>'+ content_buff;

            ul_content = '<ul class="nav navbar-nav">' + ul_content + '</ul>';

            navbar_content = logo_content + ul_content;
            navbar_content = '<div class="sidebar-wrapper">' + navbar_content + '</div>';

            $off_canvas_sidebar.html(navbar_content);

            $('body').append($off_canvas_sidebar);

             $toggle = $('.navbar-toggle');

             $off_canvas_sidebar.find('a').removeClass('btn btn-round btn-default');
             $off_canvas_sidebar.find('button').removeClass('btn-round btn-fill btn-info btn-primary btn-success btn-danger btn-warning btn-neutral');
             $off_canvas_sidebar.find('button').addClass('btn-simple btn-block');

             $toggle.click(function (){
                if(pd.misc.navbar_menu_visible == 1) {
                    $('html').removeClass('nav-open');
                    pd.misc.navbar_menu_visible = 0;
                    $('#bodyClick').remove();
                     setTimeout(function(){
                        $toggle.removeClass('toggled');
                     }, 400);

                } else {
                    setTimeout(function(){
                        $toggle.addClass('toggled');
                    }, 430);

                    div = '<div id="bodyClick"></div>';
                    $(div).appendTo("body").click(function() {
                        $('html').removeClass('nav-open');
                        pd.misc.navbar_menu_visible = 0;
                        $('#bodyClick').remove();
                         setTimeout(function(){
                            $toggle.removeClass('toggled');
                         }, 400);
                    });

                    $('html').addClass('nav-open');
                    pd.misc.navbar_menu_visible = 1;

                }
            });
            navbar_initialized = true;
        }

    }
};


// Returns a function, that, as long as it continues to be invoked, will not
// be triggered. The function will be called after it stops being called for
// N milliseconds. If `immediate` is passed, trigger the function on the
// leading edge, instead of the trailing.

function debounce(func, wait, immediate) {
	var timeout;
	return function() {
		var context = this, args = arguments;
		clearTimeout(timeout);
		timeout = setTimeout(function() {
			timeout = null;
			if (!immediate) func.apply(context, args);
		}, wait);
		if (immediate && !timeout) func.apply(context, args);
	};
}

$('.remove').on('click', function () {
    var userName = $(this)[0].parentElement.parentNode.children[1].innerText,
        userID = $(this)[0].parentElement.parentNode.children[0].innerText,
        userRemove = $(this)[0].parentElement.parentNode;

    swal({
        title: 'Удалить пользователя <u>'+ userName +'</u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $.ajax({
            method: 'POST',
            url: $('meta[name="root-site"]').attr('content') + '/user_delete/' + userID,
            data: {'_token': $('meta[name="csrf-token"]').attr('content')}
        }).done(function(msg) {
            $(userRemove).remove();
        });
    });
});

$('input[type=number]').keyup(function() {
    var num = this.value.match(/\d/.g);
    if (num === null) {
        this.value = "";
    }
});

var userAdmin = document.getElementsByClassName("userAdmin");
changeColor(userAdmin,"#4A148C");
var userModer = document.getElementsByClassName("userModer");
changeColor(userModer,"#33691");
var userOpt = document.getElementsByClassName("userOpt");
changeColor(userOpt,"#01579B");

function changeColor(id,color) {
    for(var i=0;i<id.length;i++){
        id[i].style.color=color;
    }
}
