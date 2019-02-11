$('.cartBl').remove();
var Cart_data = [{row: []}],
    mobileVersion = false;

if(Cart_data[0].row.length < 5){
    var intElemOffsetHeight = $( window ).height(),
        intElemOffsetWidth = $( window ).width();

    if(intElemOffsetWidth >= 1024){
        isDesc();
        getData();
        mobileVersion = false;
    } else {
        getmobileData();
        mobileVersion = true;
    }
    setHeight(intElemOffsetHeight);
    $(window).resize(function() {
        intElemOffsetHeight = $( window ).height() + 200;
        intElemOffsetWidth = $( window ).width();
        setHeight(intElemOffsetHeight);

        if(intElemOffsetWidth >= 1024){
            isDesc();
        } else {
            isMobile();
        }
    });
    function isDesc() {
        $('.is--desc').css('display', 'block');
        $('.is--Mobile').css('display', 'none');
    }

    function isMobile() {
        $('.is--desc').css('display', 'none');
        $('.is--Mobile').css('display', 'block');
    }
    function setHeight(intElemOffsetHeight) {
        $('.cart-container').css('height', ''+intElemOffsetHeight+'');
    }
}

function getData() {
    var retrievedData = localStorage.getItem("Cart_data");
    if(retrievedData !== null){
        Cart_data = JSON.parse(retrievedData);
        $('.cartPage_article').remove();
        Cart_template(Cart_data);
    }
}

function getmobileData() {
    var retrievedData = localStorage.getItem("Cart_data");
    if(retrievedData !== null){
        Cart_data = JSON.parse(retrievedData);
        $('.cartPage_article').remove();
        moBile_template(Cart_data);
    }
}
if(Cart_data[0].row.length === 0){
    $('.cart-form').remove();
    $('.post-8').append('<div class="cartPage_article">Корзина пуста :(</div>');
    $('.mobile-post.is-mobile').append('<div class="cartPage_article">Корзина пуста :(</div>');
    $('.tableFooter').css('display', 'none');
}
else{
    TotalCost();
    $('.tableFooter').css('display', 'block');
}

function TotalCost() {
    $.find('[data-set="totalCost"]')[0].innerHTML = Cart_data[0].cartProducts_summ.toFixed(2) + ' грн';
}

function moBile_template(Cart_data) {
    $.get('cartTmpl/cartMobile.html', {}, function (templateBody) {
        $.tmpl(templateBody, Cart_data).appendTo('#mobile--goods');

        getSelectedValue();

        for (var i = 0; i < Cart_data[0].row.length; i++){
            if(Cart_data[0].row[i].box__price === Cart_data[0].row[i].rostovka__price){
                $('[data-select-id="'+ Cart_data[0].row[i].productID +'"]').remove();

                $('[product-id="'+ Cart_data[0].row[i].productID +'"] .select-style')[0].innerHTML =
                    "<div class='form-group select-style'><input class='form-control' type=\"number\" placeholder=\""+Cart_data[0].row[i].names.box+"\" disabled></div>"
            }
        }
    });
}

function Cart_template(Cart_data) {
    $.get('cartTmpl/cartTable.html', {}, function (templateBody) {
        $.tmpl(templateBody, Cart_data).appendTo('#cartTableInner');

        getSelectedValue();

        for (var i = 0; i < Cart_data[0].row.length; i++){
            if(Cart_data[0].row[i].box__price === Cart_data[0].row[i].rostovka__price){
                $('[data-select-id="'+ Cart_data[0].row[i].productID +'"]').remove();
                $('[product-id="'+ Cart_data[0].row[i].productID +'"] .type .select-style')[0].innerHTML =
                    "<div class='form-group select-style'><input class='form-control' type=\"number\" placeholder=\""+Cart_data[0].row[i].names.box+"\" disabled></div>"
            }
        }
    });
}

if(Cart_data[0].row.length === 0){
    $('.mobile-post is-mobile').append('<span class="isClear">Корзина пуста</span>')
}

if($.find('#cartTableInner').length !== 0){
    $(document).on('click', '.removeItem', function (){
        if(mobileVersion === true){
            var removeTarget = Number ($(this)[0].offsetParent.dataset.id);
            for (var i = 0; i < Cart_data[0].row.length; i++){
                var arrayID = Cart_data[0].row[i].productID;
                if(removeTarget === Number (arrayID)){
                    var domElement = $.find('[product-id="'+ removeTarget +'"]');
                    $(domElement).remove();
                    Cart_data[0].cartProducts_summ -= Cart_data[0].row[i].quantityPrice;
                    TotalCost();

                    Cart_data[0].row.splice(i, 1);
                    Cart_data[0].cartCount--;
                    localStorage.setItem("Cart_data", JSON.stringify(Cart_data));

                    if(Cart_data[0].row.length === 0){
                        $('.cart-form').remove();
                        $('.post-8').append('<div class="cartPage_article">Корзина пуста :(</div>');

                        $('.mobile-post.is-mobile').append('<div class="cartPage_article">Корзина пуста :(</div>');
                        $('.tableFooter').css('display', 'none');
                    }
                    if(Cart_data[0].row.length < 5){
                        $('.mb-80').addClass('Zero--height');
                    }
                }
            }
        } else {
            var removeTarget = Number ($(this)[0].parentElement.parentElement.attributes[1].nodeValue);
            for (var i = 0; i < Cart_data[0].row.length; i++){
                var arrayID = Cart_data[0].row[i].productID;
                if(removeTarget === Number (arrayID)){
                    var domElement = $.find('[product-id="'+ removeTarget +'"]');
                    $(domElement).remove();
                    Cart_data[0].cartProducts_summ -= Cart_data[0].row[i].quantityPrice;
                    TotalCost();

                    Cart_data[0].row.splice(i, 1);
                    Cart_data[0].cartCount--;
                    localStorage.setItem("Cart_data", JSON.stringify(Cart_data));

                    if(Cart_data[0].row.length === 0){
                        $('.cart-form').remove();
                        $('.post-8').append('<div class="cartPage_article">Корзина пуста :(</div>');
                        $('.tableFooter').css('display', 'none');
                    }
                    if(Cart_data[0].row.length < 5){
                        $('.mb-80').addClass('Zero--height');
                    }
                }
            }
        }
    });
}

var targetID = 0;
function getSelect(event, value) {
    if(mobileVersion === true){
        targetID = event.target.attributes[3].nodeValue;
    } else {
        targetID = event.target.parentElement.offsetParent.parentElement.attributes[1].nodeValue;
    }

    if(value === '1'){
        var rostovka_Price = 0, recalculated_price = 0;

        for (var i = 0; i < Cart_data[0].row.length; i++){
            if(Number (targetID) === Cart_data[0].row[i].productID){
                rostovka_Price = Cart_data[0].row[i].rostovka__price * Cart_data[0].row[i].quantity;
                $.find('[product-id="'+ targetID +'"] .item--price')[0].innerText = Cart_data[0].row[i].rostovka__price.toFixed(2) + ' грн';
                $.find('[product-id="'+ targetID +'"] .price.counting')[0].innerText = rostovka_Price.toFixed(2) + ' грн';
                Cart_data[0].row[i].quantityPrice = rostovka_Price;
                Cart_data[0].row[i].selected_value = value;
                Cart_data[0].row[i].price = parseFloat(Cart_data[0].row[i].rostovka__price.toFixed(2));
            }
            recalculated_price += Cart_data[0].row[i].quantityPrice;
        }

        Cart_data[0].cartProducts_summ = recalculated_price;
        $.find('[data-set="totalCost"]')[0].innerText = recalculated_price.toFixed(2) + ' грн';
        localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
    }

    else{
        var box_Price = 0, recalculatedP = 0;

        for (var z = 0; z < Cart_data[0].row.length; z++){
            if(Number (targetID) === Cart_data[0].row[z].productID){
                Cart_data[0].row[z].price = parseFloat(Cart_data[0].row[z].box__price.toFixed(2));
                box_Price = Cart_data[0].row[z].price * Cart_data[0].row[z].quantity;
                $.find('[product-id="'+ targetID +'"] .item--price')[0].innerText = Cart_data[0].row[z].price.toFixed(2) + ' грн';
                $.find('[product-id="'+ targetID +'"] .price.counting')[0].innerText = box_Price.toFixed(2) + ' грн';
                Cart_data[0].row[z].quantityPrice = box_Price;
                Cart_data[0].row[z].selected_value = value;
            }
            recalculatedP += Cart_data[0].row[z].quantityPrice;
        }

        Cart_data[0].cartProducts_summ = recalculatedP;
        $.find('[data-set="totalCost"]')[0].innerText = recalculatedP.toFixed(2) + ' грн';
        localStorage.setItem("Cart_data", JSON.stringify(Cart_data));
    }
}

function getSelectedValue() {
    for (var i = 0; i < Cart_data[0].row.length; i++){

        if(Cart_data[0].row[i].selected_value !== null){
            var options = $('[product-id="'+ Cart_data[0].row[i].productID +'"] select');
            $(options).val(Cart_data[0].row[i].selected_value);
        }

        if(Cart_data[0].row[i].selected_value === '1'){
            $.find('[product-id="'+ Cart_data[0].row[i].productID +'"] .item--price')[0].innerText = Cart_data[0].row[i].rostovka__price.toFixed(2) + ' грн';
        }
        else{
            $.find('[product-id="'+ Cart_data[0].row[i].productID +'"] .item--price')[0].innerText = Cart_data[0].row[i].price.toFixed(2) + ' грн';
        }
    }
}

var footer = document.querySelector(".footer");
var cartPage_article = document.querySelector(".cartPage_article");
if((location.href=== location.origin +"/rostovka_app/public/cart")&&(cartPage_article.innerHTML="Корзина пуста :(")){
    footer.style.position="absolute";
    footer.style.bottom="0";
}

function redirectBack() {
    if ( document.referrer.indexOf("https://rostovka.net/male") != -1 )
        window.location.replace("https://rostovka.net/male"); 
    else if ( document.referrer.indexOf("https://rostovka.net/female") != -1 )
        window.location.replace("https://rostovka.net/female");
    else if ( document.referrer.indexOf("https://rostovka.net/kids") != -1 )
        window.location.replace("https://rostovka.net/kids");
    else if ( document.referrer.indexOf("https://rostovka.net/sales") != -1 )
        window.location.replace("https://rostovka.net/sales");
    else if ( document.referrer.indexOf("https://rostovka.net/showFinderFinal") != -1 ) {
        if (Cart_data[0].cartCount == 0) window.location.replace("https://rostovka.net/"); 
        let category = Cart_data[0].row[Cart_data[0].row.length - 1].cart_product_url;
        category = category.substring(0, category.indexOf('/'));
        window.location.replace("https://rostovka.net/" + category);
    }
    else window.location.replace("https://rostovka.net/"); 
}

$('#redirectback').on('click', function() {
    redirectBack();
});
