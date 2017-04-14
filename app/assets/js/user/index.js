$(function () {

	$('#login').submit(function () {
		var data = $(this).serialize();
		$.ajax({
			url: '/api/user/signin',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function (info) {
				data = info;
			},
			error: function (request, message, error) {
				console.log(request, message, error);
				data = null;
			}
		}).done(function () {
				if( data.error ) {
					$(".ajax-error").text(data.error);
					$(".ajax-error").show();
				} else {
					$(".ajax-error").hide();
					window.location.href = '/';
				}
		});
		return false;
	});

	$('#register').submit(function () {
		var data = $(this).serialize();

		$.ajax({
			url: '/api/user/signout',
			type: 'POST',
			data: data,
			dataType: 'json',
			success: function (info) {
				data = info;
			},
			error: function (request, message, error) {
				console.log(request, message, error);
				data = null;
			}
		}).done(function () {
			if( data.error ) {
				$(".ajax-error").text(data.error);
				$(".ajax-error").show();
			} else {
				$(".ajax-error").hide();
				window.location.href = '/';
			}
		});
		return false;
	});

});