$(document).ready(function(){
	$('#plusMan').click(() => {
		let col = $('.specman').length + 1;

		$('#template').clone().insertAfter('form .row:last')
			.css('display', 'block')
			.attr('id', `parent${col}`)
			.addClass('specman');

		$('select:last').attr('name', 'man' + (col));
	    $('.ti-close:last')[0].dataset.count = col;
		$('input[name="lenght"]:last').val(col);

		$('.remove__man').off();
		$('.remove__man').on('click', (e) => {
			let id = e.target.id;
			let count = e.target.dataset.count;
			
			if (id) {
				swal({
			        title: 'Убрать доступ пользователю?',
			        type: 'info',
			        showCloseButton: true,
			        showCancelButton: true,
			        focusConfirm: false,
			        confirmButtonText: 'Удалить',
			        cancelButtonText: 'Отменить'
			    }).then(function() {
					$.ajax({
				        method: 'POST',
				        url: $('meta[name="root-site"]').attr('content') + '/delman',
				        data: {_token:  $('meta[name="csrf-token"]').attr('content'), id: id}
				    }).done(function(msg) {
				    	swal({
				        	title: 'Удалено',
					        type: 'success',
					    });
				    });
				});
			}

			$(`#parent${count}`).remove();
			$(`input[name="lenght"]:last`).val($('.specman').length);

			for (i = parseInt(count); i <= $('.specman').length; i++) {
				$(`#parent${i+1}`).attr('id', `parent${i}`)
				$(`select[name="man${i+1}"]:last`).attr('name', 'man' + (i));
			    $(`.ti-close[data-count="${i+1}"]:last`)[0].dataset.count = i;
			}
		});
	})

	$('.remove__man').on('click', (e) => {
		let id = e.target.id;
		let count = e.target.dataset.count;
		
		if (id) {
			swal({
		        title: 'Убрать доступ пользователю?',
		        type: 'info',
		        showCloseButton: true,
		        showCancelButton: true,
		        focusConfirm: false,
		        confirmButtonText: 'Удалить',
		        cancelButtonText: 'Отменить'
		    }).then(function() {
				$.ajax({
			        method: 'POST',
			        url: $('meta[name="root-site"]').attr('content') + '/delman',
			        data: {_token:  $('meta[name="csrf-token"]').attr('content'), id: id}
			    }).done(function(msg) {
			    	swal({
			        	title: 'Удалено',
				        type: 'success',
				    });
			    });
			});
		}

		$(`#parent${count}`).remove();
		$(`input[name="lenght"]:last`).val($('.specman').length);

		for (i = parseInt(count); i <= $('.specman').length; i++) {
			$(`#parent${i+1}`).attr('id', `parent${i}`)
			$(`select[name="man${i+1}"]:last`).attr('name', 'man' + (i));
		    $(`.ti-close[data-count="${i+1}"]:last`)[0].dataset.count = i;
		}
	});
});