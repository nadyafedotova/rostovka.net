$('.remove__product').on('click', function () {
    var productName = $(this)[0].parentElement.parentNode.children[1].innerText,
        productID = $(this)[0].parentNode.parentNode.dataset.id,
        productRemove = $(this)[0].parentNode.parentNode;

    swal({
        title: 'Удалить товар <u>'+ productName +'</u>',
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
            url: $('meta[name="root-site"]').attr('content') + '/product/delete',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), id: productID}
        }).done(function(msg) {
        });
    });
});



var $table = $('#table');
$(function () {
    $('#toolbar').find('select').change(function () {
        $table.bootstrapTable('refreshOptions', {
            exportDataType: $(this).val()
        });
    });
});

var trBoldBlue = $("table");

$(trBoldBlue).on("click", "tr", function (){
    $(this).toggleClass("bold-blue");
});

$('input[type=file]').bootstrapFileInput();


var fileChoosedZip = false, fileChoosedXLS = false, targetError = $('.file-input-wrapper');

function getFile() {
    fileChoosedZip = true;
    return fileChoosedZip
}

function getFileXls() {
    fileChoosedXLS = true;
    return fileChoosedXLS
}

function getManufactures(e) {
    console.log(e);
}

function getSeason(e) {
    console.log(e);
}

function getSelect(e) {
    if(e.srcElement.value === 'delete'){
        $('.file--uploader').css('display', 'none');
        $('.xsl--uploader').css('display', 'block');
        $('.header--add--buttons').css('display', 'block');
        $('select.manufacturer_Options').css('display', 'none');
        $('.seasone_Options').css('display', 'none');
        $('.type_Options').css('display', 'none');
        $('button.upload').css('display', 'none');
        $('.sorting__Option.availability').css('display', 'none');
        $('.edit').remove();
        $('.header--add--buttons').append('' +
            '<button class="remove col-md-4 col-sm-12 col-xs-12" style="top: 20px; display: block;">Удалить</button>');
        getFileXls();
    }

    else{
        $('.file--uploader').css('display', 'block');
        $('button.upload').css('top', '20px');
        $('button.upload').css('display', 'block');
        $('button.download').css('display', 'none');
        $('select.manufacturer_Options').css('display', 'none');
        $('.seasone_Options').css('display', 'none');
        $('.type_Options').css('display', 'none');
        $('.edit').remove();
        $('.remove').remove();
    }

    if(e.srcElement.value === 'upload') {
        $('.file--uploader').css('display', 'block');
        $('.xsl--uploader').css('display', 'block');
        $('button.upload').css('display', 'block');
        $('select.manufacturer_Options').css('display', 'none');
        $('.seasone_Options').css('display', 'none');
        $('.type_Options').css('display', 'none');
        $('.sorting__Option.availability').css('display', 'none');
        $('.edit').remove();
        $('.remove').remove();
    }

    if(e.srcElement.value === 'edit'){
        $('.xsl--uploader').css('display', 'block');
        $('.file--uploader').css('display', 'block');
        $('.upload').css('display', 'none');
        $('.sorting__Option.availability').css('display', 'none');
        $('.header--add--buttons').append('' +
            '<button class="edit col-md-4 col-sm-12 col-xs-12" style="top: 20px; display: block;">Загрузить</button>');
        getFile();
        getFileXls();
        $('.remove').remove();
    }

    if(e.srcElement.value === 'download'){
        $('.file--uploader').css('display', 'none');
        $('.xsl--uploader').css('display', 'none');
        $('button.upload').css('display', 'none');
        $('.sorting__Option.availability').css('display', 'block');
        $('.header--add--buttons').append("<button class='download allProducts col-md-4 col-sm-12 col-xs-12' onclick='getUserAllProducts()'>Скачать</button>");
        $('.header--add--buttons').append("<button class='download for_Supliers col-md-4 col-sm-12 col-xs-12' onclick='getManufacturesAllProducts()'>Скачать для поставщиков</button>");
        $('.header--add--buttons').append("<button class='download for_Supliers_photo col-md-4 col-sm-12 col-xs-12' style='right: -340px;top: -65px;width: 220px;position: relative;' onclick='getManufacturesAllProductsPhoto()'>Скачать для поставщиков без фото</button>");
        $('select.manufacturer_Options').css('display', 'block');
        $('.seasone_Options').css('display', 'block');
        $('.type_Options').css('display', 'block');
        $('.edit').remove();
        $('.remove').remove();
    }
}

function getManufacturesAllProductsPhoto() {
    $('.produtsTablePage').append('<div class="preloader"><i></i></div>');
    $.ajax({
        method: 'GET',
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
        manufacturer_id: $('.sorting__Option.manufacturer_Options option:selected').val(),
        type_id: $('.sorting__Option.seasone_Options option:selected').val(),
        season_id: $('.sorting__Option.type_Options option:selected').val(),
        accessibility: $('.sorting__Option.availability option:selected').val(),
        success: function(){
            $('.preloader').remove();
            window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersToManufacturerOhnePhoto?manufacturer_id='+
                $('.sorting__Option.manufacturer_Options option:selected').val() +'&season_id='+
                $('.sorting__Option.seasone_Options option:selected').val() + '&type_id='+
                $('.sorting__Option.type_Options option:selected').val()  + '&accessibility=' +
                $('.sorting__Option.availability option:selected').val()
        }
    });
}

function getUserAllProducts(event) {
    $('.produtsTablePage').append('<div class="preloader"><i></i></div>');
    $.ajax({
        method: 'GET',
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
        manufacturer_id: $('.sorting__Option.manufacturer_Options option:selected').val(),
        type_id: $('.sorting__Option.seasone_Options option:selected').val(),
        season_id: $('.sorting__Option.type_Options option:selected').val(),
        success: function(){
            $('.preloader').remove();
            window.location = $('meta[name="root-site"]').attr('content') + '/csvDownload?manufacturer_id='+
                $('.sorting__Option.manufacturer_Options option:selected').val() +'&season_id='+
                $('.sorting__Option.seasone_Options option:selected').val() + '&type_id='+
                $('.sorting__Option.type_Options option:selected').val() + '&accessibility=' +
                $('.sorting__Option.availability option:selected').val()
        }
    });
}

function getManufacturesAllProducts() {
    $('.produtsTablePage').append('<div class="preloader"><i></i></div>');
    $.ajax({
        method: 'GET',
        data: {'_token': $('meta[name="csrf-token"]').attr('content')},
            manufacturer_id: $('.sorting__Option.manufacturer_Options option:selected').val(),
            type_id: $('.sorting__Option.seasone_Options option:selected').val(),
            season_id: $('.sorting__Option.type_Options option:selected').val(),
            accessibility: $('.sorting__Option.availability option:selected').val(),
        success: function(){
            $('.preloader').remove();
            window.location = $('meta[name="root-site"]').attr('content') + '/csvDownloadOrdersToManufacturer?manufacturer_id='+
                $('.sorting__Option.manufacturer_Options option:selected').val() +'&season_id='+
                $('.sorting__Option.seasone_Options option:selected').val() + '&type_id='+
                $('.sorting__Option.type_Options option:selected').val()  + '&accessibility=' +
                $('.sorting__Option.availability option:selected').val()
        }
    });
}

$(document).ready(function () {
    $('.sorting__Option').data("toggle");
    $('.inputs--group a').each(function(i) {
        if ( i === 0 ) {
            $(this).addClass('file--uploader');
        }
        if ( i === 1 ) {
            $(this).addClass('xsl--uploader');
        }
    });
});

$(document).on('click', 'button.edit', function () {
    if (fileChoosedZip === true && fileChoosedXLS === true) {
        var zip_data = new FormData();
        zip_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        if($('#archive').prop('files')[0] !== undefined)
        zip_data.append('photo', $('#archive').prop('files')[0]);
        zip_data.append('files', $('#xslsx').prop('files')[0]);

        $('.produtsTablePage').append('<div class="preloader"><i></i></div>');
        $.ajax({
            method: 'POST',
            headers: {'Content-Type': undefined},
            url: $('meta[name="root-site"]').attr('content') + '/csvLoadUpdate',
            processData: false,
            contentType: false,
            data: zip_data,
            success: function(){
                $('.preloader').remove();
                $('.table-responsive').append(
                    '<div class="alert alert-success" role="alert" style="position: absolute;\n' +
                    '    top: -140px;\n' +
                    '    width: 100%;\n' +
                    '    left: 0;">\n' +
                    '<a href="#" class="alert-link">Товары умпешно загруженны</a>\n' +
                    '</div>'
                );

                if($('.alert')){
                    setTimeout(removeAlert, 10000);
                }
            },
            error: function () {
                $('.table-responsive').append(
                    '<div class="alert alert-danger" role="alert" style="position: absolute;\n' +
                    '    top: -140px;\n' +
                    '    width: 100%;\n' +
                    '    left: 0;">\n' +
                    '<a href="#" class="alert-link">ОШБИКА! Выберите файлы</a>\n' +
                    '</div>'
                );

                if($('.alert')){
                    setTimeout(removeAlert, 10000);
                }
            }
        });
    }
});

$(document).on('click', 'button.remove', function () {
    if(fileChoosedXLS === false){
        $(targetError).css('border', '1px solid red');
        $('body').append('' +
            '<div class="alert alert-danger alert--xsl">\n' +
            '  <strong>Внимане!</strong> Для загрузки товаров, выберите .XLS файл с товарами с рабочего стола' +
            '</div>');
        setInterval(function () {
            $('.alert--xsl').remove()
        }, 5000);
    }
    else{
        var zip_data = new FormData();
        zip_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        zip_data.append('files', $('#xslsx').prop('files')[0]);
        $('.produtsTablePage').append('<div class="preloader"><i></i></div>');

        $.ajax({
            method: 'POST',
            headers: {'Content-Type': undefined},
            url: $('meta[name="root-site"]').attr('content') + '/csvLoadDelete',
            processData: false,
            contentType: false,
            data: zip_data,
            success: function(){
                $('.preloader').remove();
                $('.table-responsive').append(
                    '<div class="alert alert-success" role="alert" style="position: absolute;\n' +
                    '    top: -140px;\n' +
                    '    width: 100%;\n' +
                    '    left: 0;">\n' +
                    '<a href="#" class="alert-link">Товары успешно удалены</a>\n' +
                    '</div>'
                );

                if($('.alert')){
                    setTimeout(removeAlert, 10000);
                }
            },
            error: function () {}
        });
    }
});

$(document).on('click', 'button.upload', function () {
    if(fileChoosedZip === false){
        $(targetError).css('border', '1px solid red');
        $('body').append('' +
            '<div class="alert alert-danger">\n' +
            '  <strong>Внимане!</strong> Для загрузки товаров, выберите .ZIP архив фотографиий с рабочего стола' +
            '</div>');
        setInterval(function() { $('.alert').remove() }, 5000);
    }

    if(fileChoosedXLS === false) {
        $('.xsl--uploader').css('border', '1px solid red');
        $('body').append('' +
            '<div class="alert alert-danger alert--xsl">\n' +
            '  <strong>Внимане!</strong> Для загрузки товаров, выберите .XLS файл с товарами с рабочего стола' +
            '</div>');
        setInterval(function () {
            $('.alert--xsl').remove()
        }, 5000);
    }

    if (fileChoosedZip === true && fileChoosedXLS === true) {
        var zip_data = new FormData();
        zip_data.append('_token', $('meta[name="csrf-token"]').attr('content'));
        zip_data.append('photo', $('#archive').prop('files')[0]);
        zip_data.append('files', $('#xslsx').prop('files')[0]);
        $('.produtsTablePage').append('<div class="preloader"><i></i></div>');

        $.ajax({
            method: 'POST',
            headers: {'Content-Type': undefined},
            url: $('meta[name="root-site"]').attr('content') + '/csvLoad',
            processData: false,
            contentType: false,
            data: zip_data,
            success: function(msg){
                if(msg[1][1]){
                    var res="";
                    for(var i = 1; i < msg[1].length;i++){
                        res+=msg[1][i] +" , ";
                    }
                    $('.table-responsive').append(
                        '<div class="alert alert-success" role="alert" style="position: absolute;\n' +
                        '    top: -140px;\n' +
                        '    width: 100%;\n' +
                        '    left: 0;">\n' +
                        '<div href="#" class="alert-link">Товары успешно загруженны!</div>\n' +
                        ' <br/> ' +
                        '<div href="#" class="alert-link">Товары, которые уже есть в базе, находятся в строчках: ' + res + '</div>\n'+
                        '</div>'
                    );
                }

                else{
                    $('.table-responsive').append(
                        '<div class="alert alert-success" role="alert" style="position: absolute;\n' +
                        '    top: -140px;\n' +
                        '    width: 100%;\n' +
                        '    left: 0;">\n' +
                        '<a href="#" class="alert-link">Товары успешно загруженны</a>\n' +
                        '</div>'
                    );
                }

                if($('.alert')){
                    setTimeout(removeAlert, 15000);
                }
                $('.preloader').remove();
            },
            error: function () {
                $('.table-responsive').append(
                    '<div class="alert alert-danger" role="alert" style="position: absolute;\n' +
                    '    top: -140px;\n' +
                    '    width: 100%;\n' +
                    '    left: 0;">\n' +
                    '<a href="#" class="alert-link">ОШБИКА! В товарах найденны дубли</a>\n' +
                    '</div>'
                );

                if($('.alert')){
                    setTimeout(removeAlert, 2000);
                }
            }
        });
    }
});

function removeAlert() {
    $('.alert').remove();
}

$('.form-search button').on('click', function (e) {
    e.preventDefault();
    window.location = $('meta[name="root-site"]').attr('content') + '/products/' + $('.search-query').val();
});

var checkTov = document.getElementsByClassName("checkTov");
var chooseAll =document.getElementById("chooseAll");
var closeAll =document.getElementById("closeAll");
var countNumber = document.querySelector(".countNumber");
var clearAll = document.querySelector(".clearAll");
var price = document.querySelector(".price");
var pricePurchase =document.querySelector(".pricePurchase");
var searchArt =document.querySelector(".searchArt");
var searchMan = document.querySelector(".searchMan");
var saveAll = document.querySelector(".saveAll");
var availability =document.querySelector(".isExist");

saveAll.addEventListener("click",function () {
    var save =[];
    for(var i=0;i<checkTov.length;i++){
            if(checkTov[i].checked===true){
                save.push(checkTov[i].value);
            }
    }

    if(pricePurchase.value>price.value)
    {
        alert("Цена закупки должна быть меньше цены")
    }
    else if(pricePurchase.value===""&&price.value===""&&availability.value==="0"){
        alert("Не заполненно не одного поля!")
    }
    else {
        $.ajax({
            type: "POST",
            url: $('meta[name="root-site"]').attr('content') + '/testIncomeData',
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "save": save,
                "price": price.value,
                "pricePurchase": pricePurchase.value,
                "availability": availability.value
            },
            success: function (msg) {
                location.reload();
            }
        });

    }
});
searchArt.addEventListener("keypress",function (e) {
    if(e.keyCode===13){
        if(searchArt.value!==""&&searchMan.value!=="0"){
            location.href = location.origin + "/public/products" +"?article=" +searchArt.value +"&manufacturer="+searchMan.value;
        }
        else if(searchArt.value!==""){
            location.href = location.origin + "/public/products" +"?article=" +searchArt.value;
        }
        else if(searchMan.value!=="0"){
            location.href = location.origin + "/public/products"+"?manufacturer="+searchMan.value;
        }
    }
});
console.log(searchMan.valueOf());

searchMan.addEventListener("keypress",function (e) {
    if(e.keyCode===13){
        if(searchArt.value!==""&&searchMan.value!=="0"){
            location.href = location.origin+"/public/products" +"?article=" +searchArt.value +"&manufacturer="+searchMan.value;
        }
        else if(searchMan.value!=="0"){
            location.href = location.origin+"/public/products" +"?manufacturer=" +searchMan.value;
        }
        else if(searchArt.value!==""){
            location.href = location.origin+"/public/products"+"?article="+searchArt.value;
        }
    }
});

pricePurchase.addEventListener("keypress",function (e) {
    if(e.keyCode >= 48 && e.keyCode <= 57){
    }
    else{
        e.preventDefault()
    }
});

price.addEventListener("keypress",function (e) {
    if(e.keyCode >= 48 && e.keyCode <= 57){
    }
    else{
        e.preventDefault()
    }
});

clearAll.addEventListener("click",function () {
    countNumber.innerHTML="0";
    for(var i=0;i<checkTov.length;i++){
        checkTov[i].checked=false;
        closeAll.style.display="none";
        chooseAll.style.display="block";
    }
});

 for(var j = 0;j<checkTov.length;j++){
     checkTov[j].addEventListener("change",function () {
         if(this.checked===true){
             countNumber.innerHTML++;
         }
         else{
             countNumber.innerHTML--;
         }
     })
 }

chooseAll.addEventListener('click',function () {

    for(var i=0;i<checkTov.length;i++){
        if(checkTov[i].checked===false){
            countNumber.innerHTML++;
            checkTov[i].checked=true;
            closeAll.style.display="block";
            chooseAll.style.display="none";
        }
    }
});

closeAll.addEventListener('click',function () {
    for(var i=0;i<checkTov.length;i++){
        if(checkTov[i].checked===true){
            countNumber.innerHTML--;
            checkTov[i].checked=false;
            closeAll.style.display="none";
            chooseAll.style.display="block";
        }
    }
});