var conf = require('./conf');
var Ajax = require('./ajax');
var listAjax = new Ajax('list');

var currentList = {
	id: '',
	name: '',
	textBox: "#" + conf.textBox,
	listItems: "." + conf.listItems,
	listItem: "." + conf.listItem,
	itemBox: "." + conf.itemBox,
	/*read: function (id) {
		var elem = listAjax.read(id);
		if(elem != null)
		{

		}
	},*/
	clear: function () {
		$(currentList.listItems).empty();
	},
	readAll: function () {
		currentList.clear();
		listAjax.read(undefined, function (data) {
			$.each(data, function (index, info) {
				currentList.createForm(info['name'], info['id']);
			});
		});
	},
	remove: function (elem) {
		listAjax.delete(currentList.id, function () {
			elem.closest("li").remove();
		});
	},
	create: function () {
		var name = $(currentList.textBox).val();
		listAjax.create(name, function (data) {
			if(data != null)
			{
				if(data.hasOwnProperty('success'))
				{
					currentList.createForm(data['name'], data['id']);
				} else if(data.hasOwnProperty('error')) console.log(data['error']);
			}
		});
	},
	createForm: function (name, id) {
		// кнопки справа - удалить и редактировать
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group right'>" + deleteButton + editButton + "</div>";

		$(currentList.listItems).append(
			"<li id='" + id + "' class='list-group-item " + conf.listItem + " clearfix'>"
			+ "<span class='" + conf.listText + " left'>"
			+ name
			+ "</span>"
			+ twoButtons
			+ "</li>"
		);
		// очистка поля ввода
		$(currentList.textBox).val('');
	},
	editForm: function (elem) {
		var editItemBox =
			"<form class='edit_input_box col-lg-6' style='padding: 0'>" +
			"<div class='input-group'>" +
			"<input type='text' class='" + conf.itemBox + " form-control' style='height: auto' placeholder='" + currentList.name + "' >" +
			"<span class='input-group-btn'>" +
			"<input class='btn btn-default cancel' type='submit' value='Отменить'>" +
			"<input class='btn btn-default save' type='submit' value='Сохранить'>" +
			"</span>" +
			"</div>" +
			"</form>";
		// вставляем форму редактирования вместо записи
		elem.closest(currentList.listItem).html(editItemBox);
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
			"<span class='" + conf.listText + "'>" +
			name +
			"</span>" +
			twoButtons
		);
	},
	cancel: function (elem) {
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
		elem.closest(currentList.listItem).html(
			"<span class='" + conf.listText + "'>" +
			currentList.name +
			"</span>"+
			twoButtons
		);
	}
};

module.exports = currentList;