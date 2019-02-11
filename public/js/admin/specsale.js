$(document).ready(function(){
	$('#plusMan').click(() => {
		let col = $('.specsale').length + 1;

		$('#template').clone().insertAfter('form .row:last')
			.css('display', 'block')
			.attr('id', `parent${col}`)
			.addClass('specsale');

		$('select:last').attr('name', 'sel' + (col));
	    $('input[name="percent1"]:last').attr('name', 'percent' + (col));
	    $('input[name="minus1"]:last').attr('name', 'minus' + (col));
	    $('.ti-close:last')[0].dataset.count = col;
		$('input[name="lenght"]:last').val(col);

		$('.remove__sale').off();
		$('.remove__sale').on('click', (e) => {
			let id = e.target.id;
			let count = e.target.dataset.count;
			
			if (id) {
				swal({
			        title: 'Удалить скидку?',
			        type: 'info',
			        showCloseButton: true,
			        showCancelButton: true,
			        focusConfirm: false,
			        confirmButtonText: 'Удалить',
			        cancelButtonText: 'Отменить'
			    }).then(function() {
					$.ajax({
				        method: 'POST',
				        url: $('meta[name="root-site"]').attr('content') + '/delsale',
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
			$(`input[name="lenght"]:last`).val($('.specsale').length);

			for (i = parseInt(count); i <= $('.specsale').length; i++) {
				$(`#parent${i+1}`).attr('id', `parent${i}`)
				$(`select[name="sel${i+1}"]:last`).attr('name', 'sel' + (i));
			    $(`input[name="percent${i+1}"]:last`).attr('name', 'percent' + (i));
			    $(`input[name="minus${i+1}"]:last`).attr('name', 'minus' + (i));
			    $(`.ti-close[data-count="${i+1}"]:last`)[0].dataset.count = i;
			}
		});
	})

	$('.remove__sale').on('click', (e) => {
			let id = e.target.id;
			let count = e.target.dataset.count;
			
			if (id) {
				swal({
			        title: 'Удалить скидку?',
			        type: 'info',
			        showCloseButton: true,
			        showCancelButton: true,
			        focusConfirm: false,
			        confirmButtonText: 'Удалить',
			        cancelButtonText: 'Отменить'
			    }).then(function() {
					$.ajax({
				        method: 'POST',
				        url: $('meta[name="root-site"]').attr('content') + '/delsale',
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
			$(`input[name="lenght"]:last`).val($('.specsale').length);

			for (i = parseInt(count); i <= $('.specsale').length; i++) {
				$(`#parent${i+1}`).attr('id', `parent${i}`)
				$(`select[name="sel${i+1}"]:last`).attr('name', 'sel' + (i));
			    $(`input[name="percent${i+1}"]:last`).attr('name', 'percent' + (i));
			    $(`input[name="minus${i+1}"]:last`).attr('name', 'minus' + (i));
			    $(`.ti-close[data-count="${i+1}"]:last`)[0].dataset.count = i;
			}
		});
});