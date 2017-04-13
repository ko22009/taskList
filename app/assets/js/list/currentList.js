var conf = require('./conf');
var Ajax = require('./ajax');
var listAjax = new Ajax('list');
var filterTable = require('./../filterTable');
var sortingTable;
var currentList = {
	id: '',
	name: '',
	textBox: "#" + conf.textBox,
	listItems: "#" + conf.listItems,
	listItem: conf.listItem,
	itemBox: "." + conf.itemBox,
	clear: function () {
		$(this.listItems).empty();
	},
	readAll: function () {
		currentList.clear();
		listAjax.read(undefined, function (data) {
			$.each(data, function (index, info) {
				currentList.createForm(info['name'], info['id']);
			});
			filterTable('#target', $('#filter input.string'));
			sortingTable.init();
		});
	},
	remove: function (elem) {
		listAjax.delete(currentList.id, function () {
			elem.closest(conf.listItem).remove();
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
					sortingTable.compare(); // after add update sort
					$('#filter input').keyup(); // after add update filter
				} else if(data.hasOwnProperty('error')) console.log(data['error']);
			}
		});
	},
	createForm: function (name, id) {
		// кнопки справа - удалить и редактировать
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group right'>" + deleteButton + editButton + "</div>";
		$(this.listItems).append(
			"<tr id='" + id + "'>"
			+ "<td>"
			+ "<a href='list/" + id + "'>"
			+ "<span class='" + conf.listText + " left'>"
			+ name
			+ "</span>"
			+ "</a>"
			+ twoButtons
			+ "</td>"
			+ "</tr>"
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

module.exports = function (sorting) {
	sortingTable = sorting;
	return currentList;
};