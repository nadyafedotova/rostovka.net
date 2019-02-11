$(document).ready(function () {
    $('.mainPage--content').remove();
    var tableTr = $('.table-striped tbody tr td');
    for(var i = 0; i < $(tableTr).length; i++){
        if($(tableTr[i]).hasClass('paid--Status')){
            var getedElem = $(tableTr[i])[0].parentNode,
                input = $(tableTr[i])[0].parentNode.children[0].children[0],
                customer__Name = $(tableTr[i])[0].parentNode.children[1].lastChild;

            $(getedElem).css('background', 'rgba(90, 226, 157, 0.74)');
            $(input).css('background', 'transparent');
            $(customer__Name).attr('style', 'color: #fff !important');
        }
        else{

        }
    }
});

$(document).ready(function () {
    var options = $.extend({},
        $.datepicker.regional["ru"], {
            defaultDate: new Date(),
            dateFormat: "yy-mm-dd",
            changeMonth: true,
            changeYear: true,
            highlightWeek: true
        }
    );

    $("#from").datepicker(options);
    $("#to").datepicker(options);

});

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2) month = '0' + month;
    if (day.length < 2) day = '0' + day;

    return [year, month, day].join('-');
}

$('#from').val(formatDate(new Date()));
$('#to').val(formatDate(new Date()));

$('.remove__order').on('click', function () {
    var productName = $(this)[0].parentElement.parentNode.children[1].innerText,
        productID = $(this)[0].parentElement.parentNode.children[0].children[0].value,
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
            url: $('meta[name="root-site"]').attr('content') + '/deleteOrder',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), id: productID}
        });
    });
});
var pullT_right = document.querySelector(".pullSee");
    pullT_right.onclick=function () {
        $.ajax({
            type: "POST",
            url: $('meta[name="root-site"]').attr('content') + '/generateDateCash',
            data: {
                "dateFrom" : $('#from').val(),
                "dateTo" : $('#to').val(),
                "_token" : $('meta[name="csrf-token"]').attr('content')
            },
            success: function(msg) {
                location.href=msg;
                console.log(msg);
            }
        });
};

function getSortItem(event) {
    var pullR=document.querySelector(".pullT-right");
    if(Number (event.target.value) === 2){
        $('.image__Option').css('display', 'block');
        pullR.style.display="block";
    }
    else{
        $('.image__Option').css('display', 'none')
        pullR.style.display="none";

    }
}

$('.downloadButton button').on('click', function () {
    var dataFrom = $('#from'),
        dataTo = $('#to'),
        sortOption = Number ($('.sorting__Option option:selected').val()),
        withPhoto = Number ($('.image__Option option:selected').val());

    console.log(sortOption, withPhoto);
    if(sortOption === 1 && withPhoto === 1){
        if(dataFrom.length > 0 && dataTo.length > 0){
            dataFrom.css('border', 'none');
            dataTo.css('border', 'none');

            $.ajax({
                method: 'GET',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), dataFrom: dataFrom.val(), dataTo: dataTo.val()},
                success: function(){
                    window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersToSend?dataFrom='+dataFrom.val()+'&dataTo='+dataTo.val();
                }
            });
        }

        else{
            dataFrom.css('border', '1px solid red');
            dataTo.css('border', '1px solid red');
        }
    }

    if(sortOption === 2 && withPhoto === 1){
        if(dataFrom.length > 0 && dataTo.length > 0){
            dataFrom.css('border', 'none');
            dataTo.css('border', 'none');

            $.ajax({
                method: 'GET',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), dataFrom: dataFrom.val(), dataTo: dataTo.val()},
                success: function(){
                    window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrders?dataFrom='+dataFrom.val()+'&dataTo='+dataTo.val();
                }
            });
        }

        else{
            dataFrom.css('border', '1px solid red');
            dataTo.css('border', '1px solid red');
        }
    }


    if(sortOption === 2 && withPhoto === 2){
        if(dataFrom.length > 0 && dataTo.length > 0){
            dataFrom.css('border', 'none');
            dataTo.css('border', 'none');

            $.ajax({
                method: 'GET',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), dataFrom: dataFrom.val(), dataTo: dataTo.val()},
                success: function(){
                    window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersImages?dataFrom='+dataFrom.val()+'&dataTo='+dataTo.val();
                }
            });
        }

        else{
            dataFrom.css('border', '1px solid red');
            dataTo.css('border', '1px solid red');
        }
    }

});

$('.pull-downloadButtonPDF').on('click', function () {
    var dataFrom = $('#from'),
        dataTo = $('#to'),
        sortOption = Number ($('.sorting__Option option:selected').val()),
        withPhoto = Number ($('.image__Option option:selected').val());

    console.log(sortOption, withPhoto);
    if(sortOption === 1 && withPhoto === 1){
        if(dataFrom.length > 0 && dataTo.length > 0){
            dataFrom.css('border', 'none');
            dataTo.css('border', 'none');

            $.ajax({
                method: 'GET',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), dataFrom: dataFrom.val(), dataTo: dataTo.val()},
                success: function(){
                    window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersToSendPDF?dataFrom='+dataFrom.val()+'&dataTo='+dataTo.val();
                }
            });
        }

        else{
            dataFrom.css('border', '1px solid red');
            dataTo.css('border', '1px solid red');
        }
    }

    if(sortOption === 2 && withPhoto === 1){
        if(dataFrom.length > 0 && dataTo.length > 0){
            dataFrom.css('border', 'none');
            dataTo.css('border', 'none');

            $.ajax({
                method: 'GET',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), dataFrom: dataFrom.val(), dataTo: dataTo.val()},
                success: function(){
                    window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersPDF?dataFrom='+dataFrom.val()+'&dataTo='+dataTo.val();
                }
            });
        }

        else{
            dataFrom.css('border', '1px solid red');
            dataTo.css('border', '1px solid red');
        }
    }


    if(sortOption === 2 && withPhoto === 2){
        if(dataFrom.length > 0 && dataTo.length > 0){
            dataFrom.css('border', 'none');
            dataTo.css('border', 'none');

            $.ajax({
                method: 'GET',
                data: {'_token': $('meta[name="csrf-token"]').attr('content'), dataFrom: dataFrom.val(), dataTo: dataTo.val()},
                success: function(){
                    window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersImagesPDF?dataFrom='+dataFrom.val()+'&dataTo='+dataTo.val();
                }
            });
        }

        else{
            dataFrom.css('border', '1px solid red');
            dataTo.css('border', '1px solid red');
        }
    }

});

$('.form-search button').on('click', function (e) {
    e.preventDefault();
    window.location = $('meta[name="root-site"]').attr('content') + '/orders/' + $('.search-query').val();
});
var statusNew = document.getElementsByClassName("statusNew");
changeColor(statusNew);

var statusProcessing = document.getElementsByClassName("statusProcessing");
changeColor(statusProcessing,"#FDD835");

var statusPaid = document.getElementsByClassName("statusPaid");
changeColor(statusPaid,"#2E7D32");

var statusSend = document.getElementsByClassName("statusSend");
changeColor(statusSend,"#26A69A");

var statusNotCollect = document.getElementsByClassName("statusNotCollect");
changeColor(statusNotCollect,"#FF7043");

var statusCancel = document.getElementsByClassName("statusCancel");
changeColor(statusCancel,"#FF0500");

function changeColor(id,color) {
    for(var i=0;i<id.length;i++){
        id[i].style.color=color;
    }
}
