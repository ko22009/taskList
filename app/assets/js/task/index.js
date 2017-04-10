var imgVerify = require('./../imgVerify');
var ajax = require('./ajax')(window.location.pathname.replace(/^\/|\/$/g, ''));
var isGood = true;
var file;

$(function () {
	$('#myModal').on('hidden.bs.modal', function () {
		$(".ajax-error").hide();
		$('input:text').val('');
		isGood = true;
		file = undefined;
	});
	$("#myModal").on("click", ".save", function () {
		if(isGood) {
			var fd = new FormData;
			fd.append('image', file);
			fd.append('name', $('input[name="name"]').val());
			fd.append('surname', $('input[name="surname"]').val());
			fd.append('phone', $('input[name="phone"]').val());
			fd.append('email', $('input[name="email"]').val());
			fd.append('csrf_token', $.ajaxSettings.data['csrf_token']);
			ajax.create(fd, function (data) {
				if(data != null) {
					try {
						data = JSON.parse(data);
					} catch (e) {
					}
					if( data.error ) {
						$(".ajax-error").text(data.error);
						$(".ajax-error").show();
					} else {
						$("#myModal").modal("hide");
						$("input:text").val('');
					}
				}
			});
		}
		isGood = true;
	});
	$(document).on('change', ':file', function() {
		var input = $(this);
		var	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		file = this.files[0];
		//console.log(file); // size, type
		//label
		input = $(this).parents('.input-group').find(':text');
		if( input.length ) {
			input.val(label);
		} else {
			if( log ) alert(label);
		}
		isGood = true;
		$(".ajax-error").hide();
		$('button.save').prop('disabled', false);
		if (imgVerify.isSupportedBrowser() && file != undefined) {
			imgVerify.isGoodImage(400, 400, file).then(function (goodImg) {
				if(typeof goodImg === 'object' && goodImg.hasOwnProperty('error')) {
					isGood = false;
					$('button.save').prop('disabled', true);
					$(".ajax-error").text(goodImg.error);
					$(".ajax-error").show();
				}
			});
		}

	});
});