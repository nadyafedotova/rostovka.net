'use strict';
var Cart_data = localStorage.getItem('Cart_data');
if(Cart_data) {
    Cart_data = JSON.parse(Cart_data);
}
var data = [];
var searchPagegoodID = null;
$(document).on("click", '[data-set="buyButtonSearch"]', function (event) {
    searchPagegoodID = Number (this.parentElement.dataset.id);
    $('.dropdownCart .cartButton').css('display', 'block');
    $('.cartButton').css('margin', '0');
    $.ajax({
        method: 'POST',
        url: $('meta[name="root-site"]').attr('content') + "/api/product",
        data: {id: searchPagegoodID}})
        .done(function(msg) {
            data = msg;
            addtoCart(event, searchPagegoodID);
            searchPagegoodID = null, data = null;
        });
});
