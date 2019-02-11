$('.removePrudct').on('click', function (){
    var productName = $(this)[0].parentElement.parentNode.children[1].innerText,
        productID = $(this)[0].parentNode.parentNode.dataset.id,
        productRemove = $(this)[0].parentNode.parentNode;

    swal({
        title: 'Удалить <u>'+ productName +'</u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $(productRemove).remove();

        $.ajax({
            method: 'POST',
            url: $('meta[name="root-site"]').attr('content') + '/deleteProductFromOrder',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), id: productID},
            success: function(){
                window.location.reload(true);
            }
        });
    });
});

$('.addProduct .fa-plus-square').on('click', function(){
    $("#productsModal").modal('show');
});



var searchData = [];
$('.search--good').on('click', function () {
    if($('[data-set="searchProduct"]').val() !== ''){
        $('.modal-body').append('<div class="preloader"><i></i></div>');

        var imageUrl = [];
        $.ajax({
            method: 'POST',
            url: $('meta[name="root-site"]').attr('content') + '/finder',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), name: $('[data-set="searchProduct"]').val()}
        }).done(function (msg) {
            $('[data-set="searchProduct"]').val('');
            $('.preloader').remove();
            searchData = msg;
            for(var i = 0; i < msg.length; i++){
                imageUrl.push({url: msg[i].photo.photo_url})
            }

            if(searchData.length > 99){
                $('.founded--good').css('display', 'none');
                $('.modal-body').append('<div class="zero--result">Слишком много товаров :(</div>')
            }

            if(searchData.length === 0){
                $('.founded--good').css('display', 'none');
                $('.modal-body').append('<div class="zero--result">Поиск не дал результатов :(</div>')
            }
            else{
                searchResult(searchData, imageUrl);
                $('.zero--result').remove();
            }
        });
    }
});

function searchResult(searchData, imageUrl) {
    $('tbody tr').remove();
    $.get($('meta[name="root-site"]').attr('content') + '/admin_resources/tmpl/search_tmpl.html', {}, function (templateBody) {
        $.tmpl(templateBody, searchData).appendTo('#tmpl');
        $('.founded--good').css('display', 'block');

        $(document).ready(function () {
            for (var u = 0; u < imageUrl.length; u++){
                $('[data-img="image-url"]')[u].src = $('meta[name="root-site"]').attr('content') + '/images/products/' + imageUrl[u].url
            }
        });

        var filterData = [];
        for (var i = 0; i < searchData.length; i++){
            if(searchData[i].box_count === searchData[i].rostovka_count){
                filterData.push(searchData[i]);
            }
        }
        if(filterData.length > 0){
            for(var z = 0; z < filterData.length; z++){
                $('[data-select-id="'+ filterData[z].id +'"]').remove();
                $('[data-product-id="'+ filterData[z].id +'"] .select-style')[0].innerHTML =
                    "<div class=\"form-group select-style\"> " +
                    "<select class='form-control' type=\"number\" disabled data-set='select_box_type'>" +
                    "<option value='0' data-set='box' selected='selected'>в ящике</option>" +
                    "</select>"+
                    "</div>"
            }
        }
    });
}

if(searchData.length === 0){
    $('.founded--good').css('display', 'none');
}

var choosedProducts = [];
$('.add--product--in').on('click', function () {
    var checkedProduct = 0, itemCount = 0, checkboxes = $('.check--good');

    for(var z = 0; z < $(checkboxes).length; z++) {
        if ($(checkboxes)[z].checked === true) {
            checkedProduct = $(checkboxes)[z].parentNode.parentNode.dataset.productId;
            itemCount = $(checkboxes)[z].parentNode.parentNode.children[7].children["0"].value;
            $('.product--list').append('<div class="preloader"><i></i></div>');

            choosedProducts.push({
                orderID: $('[data-orderid]')[0].dataset.orderid,
                id: checkedProduct,
                quantity: itemCount,
                type: $('[data-set="select_box_type"] option:selected')[z].dataset.set
            });
        }
    }

    if(choosedProducts.length > 0) {
        $.ajax({
            method: 'POST',
            url: $('meta[name="root-site"]').attr('content') + '/addOrderDetail',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), data: choosedProducts},
            success: function(){
                window.location.reload(true);
            }
        });
        $("#productsModal").modal('hide');
    }
});