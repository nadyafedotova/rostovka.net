$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});

$('.form-search button').on('click', function (e) {
    e.preventDefault();
    window.location = $('meta[name="root-site"]').attr('content') + '/admin_index/' + $('.search-query').val();
});

$('#totop').click(function() {
	$.ajax({
        method: 'POST',
        url: $('meta[name="root-site"]').attr('content') + "/top",
        data: {
        	_token: $('meta[name="csrf-token"]').attr('content'),
			name: $('#prod_name').val(),
			days: $('#days').val(),
        }
	}).done(function(msg) {
		location.reload()
	});
});

$('.remove__order').click(function(e) {

    let id = e.target.id,
        top = $('#name' + id).text(),
        topDel = $('#parent' + id);

    swal({
        title: 'Удалить <u>'+ top +'</u>?',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отменить'
    }).then(function() {
        $(topDel).remove();

        $.ajax({
            method: 'DELETE',
            url: $('meta[name="root-site"]').attr('content') + "/top",
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: e.target.id,
            }
        }).done(function(msg) {

        });
    });

});