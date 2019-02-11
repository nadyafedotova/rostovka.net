$('.form-search button').on('click', function (e) {
    e.preventDefault();
    window.location = $('meta[name="root-site"]').attr('content') + '/suppliers/' + $('.search-query').val();
});

$('.remove__product').on('click', function () {
    var clickedTableTr = $(this).parents(),
        choosedName = $(clickedTableTr)[1].children[1].innerText,
        choosedID = $(clickedTableTr)[1].dataset.id;

    removeFilter(clickedTableTr, choosedName, choosedID)
});


function removeFilter(clickedTableTr, choosedName, choosedID) {

    swal({
        title: ' Удалить поставщика' + ' <u>' + choosedName +'</u>',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Да',
        cancelButtonText: 'Нет'
    }).then(function() {
        $.ajax({
            method: 'GET',
            url: $('meta[name="root-site"]').attr('content') + '/suppliers_delete/' + choosedID,
            data: {'_token': $('meta[name="csrf-token"]').attr('content')}
        }).done(function(msg) {
            $(clickedTableTr)[1].remove();
        }).error(function(msg){
            $(choosedID).remove();
        })
    });
}