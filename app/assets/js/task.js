'use strict';

$(document).on('change', ':file', function() {
	var input = $(this);
	var	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
	var file = this.files[0];
	console.log(file); // size, type
	//label
	input = $(this).parents('.input-group').find(':text');
	if( input.length ) {
		input.val(label);
	} else {
		if( log ) alert(label);
	}

	var fd = new FormData;
	fd.append('image', file);

	$.ajax({
		url: '/img',
		type: 'POST',
		processData: false,
		contentType: false,
		data: fd,
		success: function( respond, textStatus, jqXHR ){
			// Если все ОК
			if( typeof respond.error === 'undefined' ){
				// Файлы успешно загружены, делаем что нибудь здесь
				$('.ajax-respond').html( respond );
			}
			else{
				console.log('ОШИБКИ ОТВЕТА сервера: ' + respond.error );
			}
		},
		error: function( jqXHR, textStatus, errorThrown ){
			console.log('ОШИБКИ AJAX запроса: ' + textStatus );
		}
	});


});