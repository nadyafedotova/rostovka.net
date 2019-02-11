$('.copy_link').on('click', (e) => {
	var $temp = $("<input>");
	$("body").append($temp);
	$temp.val('https://rostovka.net/novelty/' + e.target.id).select();
	document.execCommand("copy");
	$temp.remove();

    swal({
        title: 'Скопировано!',
        type: 'info',
        focusConfirm: true,
        confirmButtonText: 'OK'
    });
});

$('.remove_link').on('click', (e) => {
	let id = e.target.id,
		novName = $('#name' + id).text(),
		novDel = $('#parent' + id);

    swal({
        title: 'Удалить поставку за <u>'+ novName +'</u>?',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отменить'
    }).then(function() {
        $(novDel).remove();

        $.ajax({
            method: 'DELETE',
            url: '/admin/novelty',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), id: e.target.id},
            success: function(data){
				alert('Удалено!');
			}
        });
    });
});