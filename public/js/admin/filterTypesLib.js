$('.remove__product').on('click', function () {
    var clickedTableTr = $(this).parents(),
        types = $(clickedTableTr)[4].classList.value === 'typesBlock',
        seasons = $(clickedTableTr)[4].classList.value === 'seasons',
        choosedName = $(clickedTableTr)[1].children[1].innerText,
        choosedID = $(clickedTableTr)[1].dataset.id;


    if(types || seasons){
        removeFilter(clickedTableTr, types, seasons, choosedName, choosedID)
    }
});


function removeFilter(clickedTableTr, types, seasons, choosedName, choosedID) {
    if(types !== false){
        choosedType = 'тип';
        removeType(choosedType, choosedName, choosedID, clickedTableTr);
    } else {
        choosedType = 'сезон'
        remoeSeasone(choosedType, choosedName, choosedID, clickedTableTr);
    }
}

function removeType(choosedType, choosedName, choosedID, clickedTableTr) {
    swal({
        title: ' Удалить ' + choosedType + ' <u>' + choosedName +'</u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $.ajax({
            method: 'DELETE',
            url: $('meta[name="root-site"]').attr('content') + '/type/' + choosedID,
            data: {'_token': $('meta[name="csrf-token"]').attr('content')}
        }).done(function(msg) {
            $(clickedTableTr)[1].remove();
        }).error(function(msg){
            $(choosedID).remove();
        })
    });
}

function remoeSeasone(choosedType, choosedName, choosedID, clickedTableTr) {
    swal({
        title: ' Удалить ' + choosedType + ' <u>' + choosedName +'</u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $.ajax({
            method: 'GET',
            url: $('meta[name="root-site"]').attr('content') + '/seasonRemove/' + choosedID,
            data: {'_token': $('meta[name="csrf-token"]').attr('content')}
        }).done(function(msg) {
            $(clickedTableTr)[1].remove();
        }).error(function(msg){
            $(choosedID).remove();
        })
    });
}