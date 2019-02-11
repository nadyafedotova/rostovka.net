'use strict';
var cartArray = localStorage.getItem('Cart_data'), data = [];
cartArray = JSON.parse(cartArray);

$.ajax({
    method: "POST",
    url: $('meta[name="root-site"]').attr('content') + '/api/topSales',
    data: {
        _token: $('meta[name="csrf-token"]').attr('content'),
        category_id : 1
    }
}).done(function( msg ) {
    for(var i= 0; i < msg.length; i++ ) {
        data[i] = {
            dataID: msg[i].id,
            imgUrl: $('meta[name="root-site"]').attr('content') + '/images/products/'+msg[i].photo.photo_url,
            name: msg[i].name,
            rostovka: msg[i].rostovka_count,
            box: msg[i].box_count,
            type: msg[i].types,
            price: msg[i].prise,
            full__price: msg[i].full__price,
            rostovka__price: msg[i].rostovka__price,
            real_id: msg[i].id,
            product_url: '/' + msg[i].product_url,
            option_type: 'full__price',
            size: msg[i].size.name
        };
    }

    drawBestSellers(data);
}) .fail(function( msg ) {

});

function drawBestSellers(data) {
    $.get($('meta[name="root-site"]').attr('content') + '/cartTmpl/product_best.html', {}, function (templateBody) {
        $.tmpl(templateBody, data).appendTo('#newest');
        makeSlider();
    });
}

var init = function () {
    checkPrices();
    cartCheck();
};

function getSelect(event) {
    var targetBox = $.find('[data-set="boxset"]')[0].classList;
    var targetRostovka = $.find('[data-set="rotovkaset"]')[0].classList;

    if (event.target.parentNode.parentNode.dataset.set === "rotovkaset") {
        targetRostovka.remove('disable');
        targetRostovka.add('choosed');
        targetBox.add('disable');
        targetBox.remove('choosed');
    }
    else {
        targetRostovka.add('disable');
        targetRostovka.remove('choosed');
        targetBox.remove('disable');
        targetBox.add('choosed');
    }
}

init();

function checkPrices() {
    if(Number ($('[data-set="boxset"] .iPrice')[0].innerText) === Number ($('[data-set="rotovkaset"] .iPrice')[0].innerText)){
        $('[data-set="rotovkaset"]').css('display', 'none')
    }
}


function cartCheck() {
    var prodid = Number ($('[data-prodid]')[0].dataset.prodid);
    var cartArray = localStorage.getItem('Cart_data');
    cartArray = JSON.parse(cartArray);
    if (cartArray !== null) {
        for (var i = 0; i < cartArray[0].row.length; i++) {
            if (cartArray[0].row[i].targetID === prodid) {
                $('.chooseItem').remove();
                $('.product-price').remove();
                $('.single-variation-wrap').append('' +
                    '<div class="product--is--inCart">' +
                    '<span>Товар в корзине</span>' +
                    '<div class="move--to--cart"><a class="cart--url">Перейти в корзину</a></div>' +
                    '</div>');
            }
        }
        setUrl();
    }
}


function setUrl() {
    var url = $('meta[name="root-site"]').attr('content') + '/cart';
    $('.cart--url').attr("href", url);
}


function makeSlider() {
    $('.best--seller').slick({
        dots: true,
        speed: 500,
        slidesToShow: 4,
        slidesToScroll: 1
    });
}

console.log((Number($('[data-set="boxset"] .iPrice')[0].innerText)));
console.log(Number ($('[data-set="rotovkaset"] .iPrice')[0].innerText));