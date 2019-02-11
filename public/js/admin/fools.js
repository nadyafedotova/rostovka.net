$('#foolsSubmit').on('click', (e) => {

	var data = new FormData();
	data.append('_token', $('meta[name="csrf-token"]').attr('content'));
	data.append('fools', $('#foolsList').prop('files')[0]);

	$.ajax({
		url: '/fools',
		data: data,
		cache: false,
		contentType: false,
		processData: false,
		method: 'POST',
		type: 'POST',
		success: function(data){
			//alert('Сохранено!');
			//location.reload();
		}
	});
});

$('.remove__fool').on('click', (e) => {
	let id = e.target.id,
		name = $('#name' + id).text(),
		parent = $('#parent' + id);

    swal({
        title: 'Удалить <u>'+ name +'</u>?',
        type: 'info',
        showCloseButton: true,
        showCancelButton: true,
        focusConfirm: false,
        confirmButtonText: 'Удалить',
        cancelButtonText: 'Отменить'
    }).then(function() {

        $.ajax({
            method: 'DELETE',
            url: '/fools',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), id: e.target.id},
            success: function(data) {
				swal({
				    type: 'success',
				    html: 'Удалено!'
				});

				$(parent).remove();
			}
        });
    });
});


$('#foolsAdd').click(function() {

	swal({
	  title: 'Добавить проблемного клиента',
	  html:
	    '<input id="swal-input1" placeholder="Введите номер" class="swal2-input">' +
	    '<input id="swal-input2" placeholder="Введите почту" class="swal2-input">' +
	    '<input id="swal-input3" placeholder="Введите причину добавления (необязательно)" class="swal2-input">',
	  preConfirm: function () {
	    return new Promise(function (resolve) {
	      resolve([
	        $('#swal-input1').val(),
	        $('#swal-input2').val(),
	        $('#swal-input3').val()
	      ])
	    })
	  }
	}).then(function (data) {
		$.ajax({
            method: 'post',
            url: '/fools/add',
            data: {'_token': $('meta[name="csrf-token"]').attr('content'), name: data[0], email: data[1], reason: data[2]},
            success: function(data) {
				swal({
				    type: 'success',
				    html: 'Добавлено!'
				});
				location.reload();
			}
        });
	})
  
});