$('.add_discount').on('click', function () {
    var inputValue = $('.addnewButton input').val(),
        dataID = $('.discounts ul li').length;
    dataID++;

    if(inputValue === ""){
        console.log(false)
    }
    else{
        $('.discounts ul').append('<li data-id="'+ dataID +'">'+inputValue+'% <a class="remove__Filter" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></li>')
        $('.addnewButton input').val("");
        remfilter();
    }
});

$('.add__payMethod').on('click', function () {
    var inputValue = $('.add__payMethodVal').val(),
        dataID = $('.Methods ul li').length;
    dataID++;

    if(inputValue === ""){
        console.log(false)
    }
    else{
        $('.Methods ul').append('<li data-id="'+ dataID +'">'+inputValue+'<a class="remove__Filter" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></li>')
        $('.add__payMethodVal').val("");
        remfilter();
    }
});


$('.delivery__method').on('click', function () {
    var inputValue = $('.delivery__val').val(),
        dataID = $('.deliveryMethods ul li').length;
    dataID++;

    if(inputValue === ""){
        console.log(false)
    }
    else{
        $('.deliveryMethods ul').append('<li data-id="'+ dataID +'">'+inputValue+'<a class="remove__Filter" href="#!"><i class="table--icons ti-trash type-success" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i></a></li>')
        $('.delivery__val').val("");
        remfilter();
    }
});

$('.ex_rates__add').on('click', function () {
    var rateName = $('.exrateName').val(),
        rateCode = $('.exrateCode').val(),
        rateCourse = $('.exrateCourse').val(),
        dataID = 0;

        dataID = $('.ex--rates--table table tbody tr').length;
    dataID++;

    if(rateName === "" || rateCode === "" || rateCourse === ""){
        console.log(false);
        $('.ex--rates input').css('border', '1px solid red')
    }
    else{
        $('.ex--rates--table table tbody').append('<tr data-id="'+ dataID +'"> <td>'+ rateName +'</td> <td>'+ rateCode +'</td> <td>'+ rateCourse +' <i class="table--icons ti-trash type-success removetr" aria-label="Try me! Example: success modal" data-toggle="tooltip" title="Удалить"></i> </td> </tr>');
        $('.exrateName').val("");
        $('.exrateCode').val("");
        $('.exrateCourse').val("");
        remtr();
        $('.ex--rates input').css('border', '1px solid #ddd')
    }
});

function remItemTr(event) {
    var elemDelete = event.currentTarget.parentNode.offsetParent,
        itemTrName = event.currentTarget.parentNode.offsetParent.children[0].innerText;

    swal({
        title: 'Удалить <u> '+ itemTrName + ' </u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $(elemDelete).remove();
    });

}


function remFilter(event) {
    var filterName = event.currentTarget.parentNode.firstChild.data,
        filterID = event.currentTarget.parentNode.dataset.id,
        elemDelete = event.currentTarget.parentNode;

    swal({
        title: 'Удалить <u>'+ filterName +'</u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $(elemDelete).remove();
        console.log(filterName, filterID)
    });
}

function remfilter() {
    $('.remove__Filter').on('click', function (event) {
        remFilter(event);
    });
}

function remtr() {
    $('.removetr').on('click', function (event) {
        remItemTr(event);
    })
}

remfilter();
remtr();