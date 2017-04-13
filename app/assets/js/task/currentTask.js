var listAjax = require('./ajax')(window.location.pathname.replace(/^\/|\/$/g, ''));
var imgVerify = require('./../imgVerify');
var conf = require('./conf');
var sortingTable;

var currentTask = {
	id: '',
	name: '',
	surname: '',
	phone: '',
	email: '',
	image: '',
	textBox: "#" + conf.textBox,
	listItems: "#" + conf.listItems,
	listItem: conf.listItem,
	itemBox: "." + conf.itemBox,
	isGood: true,
	file: undefined,
	isCreate: true,
	updateFile: function (self) {
		var input = $(self);
		var	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		currentTask.file = self.files[0];
		input = $(self).parents('.input-group').find(':text');
		if( input.length ) {
			input.val(label);
		} else {
			if( log ) alert(label);
		}

		currentTask.isGood = true;
		$(".ajax-error").hide();
		$('button.save').prop('disabled', false);
		if (imgVerify.isSupportedBrowser() && currentTask.file != undefined) {
			imgVerify.isGoodImage(conf.width, conf.height, conf.size, currentTask.file).then(function (goodImg) {
				if(typeof goodImg === 'object' && goodImg.hasOwnProperty('error')) {
					currentTask.isGood = false;
					$('button.save').prop('disabled', true);
					$(".ajax-error").text(goodImg.error);
					$(".ajax-error").show();
				}
			});
		}
	},
	empty: function () {
		$(".ajax-error").hide();
		$('input:text').val('');
		currentTask.isGood = true;
		currentTask.file = undefined;
	},
	clear: function () {
		$(this.listItems).empty();
	},
	readAll: function () {
		currentTask.clear();
		listAjax.read(undefined, function (data) {
			try {
				data = JSON.parse(data);
			} catch (e){}
			if( !data.error )
			$.each(data, function (index, info) {
				currentTask.id = info['id'];
				currentTask.name = info['name'];
				currentTask.surname = info['surname'];
				currentTask.phone = info['phone'];
				currentTask.email = info['email'];
				currentTask.image = info['image'];
				currentTask.createForm();
			});
			sortingTable.init();
		});
	},
	remove: function (elem) {
		listAjax.delete(currentTask.id, function (data) {
			try {
				data = JSON.parse(data);
			} catch(e) {}
			if(data != null && !data.error) $(elem).closest(conf.listItem).remove();
		});
	},
	create: function () {
		currentTask.isCreate = true;
		if(currentTask.isGood) {
			var fd = new FormData;
			currentTask.name = $('input[name="name"]').val();
			currentTask.surname = $('input[name="surname"]').val();
			currentTask.phone = $('input[name="phone"]').val();
			currentTask.email = $('input[name="email"]').val();
			fd.append('image', currentTask.file);
			fd.append('name', currentTask.name);
			fd.append('surname', currentTask.surname);
			fd.append('phone', currentTask.phone);
			fd.append('email', currentTask.email);
			fd.append('csrf_token', $.ajaxSettings.data['csrf_token']);
			listAjax.create(fd, function (data) {
				if(data != null) {
					try {
						data = JSON.parse(data);
					} catch (e) {
					}
					if( data.error ) {
						$(".ajax-error").text(data.error);
						$(".ajax-error").show();
					} else {
						currentTask.id = data['id'];
						currentTask.image = data['image'];
						currentTask.createForm();
						$("#myModal").modal("hide");
						$("input:text").val('');
						sortingTable.compare(); // after add update sort
					}
				}
			});
		}
		currentTask.isGood = true;
	},
	createForm: function () {
		// кнопки справа - удалить и редактировать
		var deleteButton = "<span class='glyphicon glyphicon-trash delete' aria-hidden='true'></span>";
		var editButton = "<span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span>";
		var twoButtons = deleteButton + editButton;
		$(this.listItems).append(
			"<tr id='" + currentTask.id + "'>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.name
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.surname
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.phone
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.email
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ "<img />"
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ twoButtons
			+ "</td>"
			+ "</tr>"
		);

		if(currentTask.image)	document.getElementById(currentTask.id).getElementsByTagName('img')[0].src = '/app/uploads/' + currentTask.image;
		// очистка поля ввода
		currentTask.empty();
	},
	update: function (self) {
		currentTask.isCreate = false;
		currentTask.id = $(self).closest('tr').attr('id');
		$('#myModal').modal('show');
		var elems = $(self).closest('tr').find('td');
		elems.each(function (index) {
			switch(index)
			{
				case 0: currentTask.name = $(elems[0]).text();
				case 1: currentTask.surname = $(elems[1]).text();
				case 2: currentTask.phone = $(elems[2]).text();
				case 3: currentTask.email = $(elems[3]).text();
				case 4: {
					var text = $(elems[4]).find('img').attr('src');
					if(text){
						currentTask.file = text.match('(?!.*\/).*')[0];
						currentTask.image = text.match('(?!.*\/).*')[0];
					}
				}
			}
		});
		$('input[name="name"]').val(currentTask.name);
		$('input[name="surname"]').val(currentTask.surname);
		$('input[name="phone"]').val(currentTask.phone);
		$('input[name="email"]').val(currentTask.email);
		$('input[name="file"]').val(currentTask.file);
	},
	updateData: function () {
		var fd = new FormData;
		currentTask.name = $('input[name="name"]').val();
		currentTask.surname = $('input[name="surname"]').val();
		currentTask.phone = $('input[name="phone"]').val();
		currentTask.email = $('input[name="email"]').val();
		fd.append('id', currentTask.id);
		fd.append('image', currentTask.file);
		fd.append('name', currentTask.name);
		fd.append('surname', currentTask.surname);
		fd.append('phone', currentTask.phone);
		fd.append('email', currentTask.email);
		fd.append('csrf_token', $.ajaxSettings.data['csrf_token']);
		listAjax.update(fd, function (data) {
			if(data != null) {
				try {
					data = JSON.parse(data);
					if( data.error ) {
						console.log(data['error']);
					} else {
						currentTask.image = data['image'];
						currentTask.updateRowData();
					}
				} catch (e) {
				}
			}
		});
	},
	updateRowData: function () {
		var deleteButton = "<span class='glyphicon glyphicon-trash delete' aria-hidden='true'></span>";
		var editButton = "<span class='glyphicon glyphicon-pencil edit' aria-hidden='true'></span>";
		var twoButtons = deleteButton + editButton;
		$('#' + currentTask.id).html(
			"<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.name
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.surname
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.phone
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ currentTask.email
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ "<span class='" + conf.listText + " left'>"
			+ "<img />"
			+ "</span>"
			+ "</td>"
			+ "<td>"
			+ twoButtons
			+ "</td>"
		);
		if(currentTask.image)	document.getElementById(currentTask.id).getElementsByTagName('img')[0].src = '/app/uploads/' + currentTask.image;
		// очистка поля ввода
		currentTask.empty();
		$("#myModal").modal("hide");
		sortingTable.compare(); // after edit update sort
	}
};

module.exports = function (sorting) {
	sortingTable = sorting;
	return currentTask;
};;