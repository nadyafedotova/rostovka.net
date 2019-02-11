$('.brandLogo').on('change', (e) => {

	var data = new FormData();
	data.append('_token', $('meta[name="csrf-token"]').attr('content'));
	data.append('photo', $('#' + e.target.id).prop('files')[0]);
	data.append('brand_id', e.target.id);

 //    $.post('https://rostovka.net/admin/brand/', data)
 //    .success(function(msg) {

	// });

	$.ajax({
		url: '/admin/brand',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST',
		success: function(data){
			alert('Сохранено!');
			location.reload();
		}
	});
});

$('.remove__order').on('click', (e) => {
	let id = e.target.id,
		brand = $('#name' + id).text(),
		brandDel = $('#parent' + id);

    swal({
        title: 'Удалить <u>'+ brand +'</u>?',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отменить'
    }).then(function() {
        $(brandDel).remove();

        $.ajax({
            method: 'DELETE',
            url: '/admin/brand',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), id: e.target.id},
            success: function(data){
				alert('Удалено!');
			}
        });
    });
});