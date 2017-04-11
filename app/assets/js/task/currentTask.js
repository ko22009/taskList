var listAjax = require('./ajax')(window.location.pathname.replace(/^\/|\/$/g, ''));
var imgVerify = require('./../imgVerify');
var conf = require('./conf');

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
	updateFile: function (self) {
		var input = $(self);
		var	label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
		currentTask.file = self.files[0];
		//console.log(file); // size, type
		//label
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
			imgVerify.isGoodImage(400, 400, currentTask.file).then(function (goodImg) {
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
			$.each(data, function (index, info) {
				currentTask.createForm(info);
			});
		});
	},
	remove: function (elem) {
		listAjax.delete(currentTask.id, function () {
			elem.closest(conf.listItem).remove();
		});
	},
	create: function () {
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
		if(currentTask.image != undefined)	document.getElementById(currentTask.id).getElementsByTagName('img')[0].src = '/app/uploads/' + currentTask.image;
		// очистка поля ввода
		currentTask.empty();
	},
	editForm: function (elem) {
		var editItemBox =
			"<form class='edit_input_box col-lg-6' style='padding: 0'>" +
			"<div class='input-group'>" +
			"<input type='text' class='" + conf.itemBox + " form-control' style='height: auto' placeholder='" + currentTask.name + "' >" +
			"<span class='input-group-btn'>" +
			"<input class='btn btn-default cancel' type='submit' value='Отменить'>" +
			"<input class='btn btn-default save' type='submit' value='Сохранить'>" +
			"</span>" +
			"</div>" +
			"</form>";
		// вставляем форму редактирования вместо записи
		elem.closest(currentList.listItem).find('td').html(editItemBox);
	},
	save: function (elem) {
		var id = currentList.id;
		var name = $(currentList.itemBox).val();
		listAjax.update({id: id, name: name}, function (data) {
			if(data != null)
			{
				if(data.hasOwnProperty('success'))
				{
					currentList.saveForm(elem, name);
					$('#filter input').keyup(); // after edit update filter
					sortingTable.compare(); // after edit update sort
				} else if(data.hasOwnProperty('error')) console.log(data['error']);
			}
		});
	},
	saveForm: function (elem, name) {
		// кнопки
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
		elem.closest(currentList.listItem).html(
			"<td>" +
			"<span class='" + conf.listText + "'>" +
			name +
			"</span>" +
			twoButtons +
			"</td>"
		);
	},
	cancel: function (elem) {
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
		elem.closest(currentList.listItem).html(
			"<td>" +
			"<span class='" + conf.listText + "'>" +
			currentList.name +
			"</span>"+
			twoButtons +
			"</td>"
		);
	}
};

module.exports = currentTask;