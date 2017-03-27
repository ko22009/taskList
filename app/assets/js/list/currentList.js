var conf = require('./conf');

var currentList = {
	id: '',
	name: '',
	textBox: "#" + conf.textBox,
	listItems: "." + conf.listItems,
	listItem: "." + conf.listItem,
	itemBox: "." + conf.itemBox,
	remove: function (elem) {
		elem.closest("li").remove();
	},
	create: function () {
		// кнопки справа - удалить и редактировать
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group right'>" + deleteButton + editButton + "</div>";

		$(this.listItems).append(
			"<li class='list-group-item " + conf.listItem + " clearfix'>"
			+ "<span class='" + conf.listText + " left'>"
			+ $(this.textBox).val()
			+ "</span>"
			+ twoButtons
			+ "</li>"
		);
		// очистка поля ввода
		$(this.textBox).val('');
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
		elem.closest(this.listItem).html(editItemBox);
	},
	save: function (elem) {
		// кнопки
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
		elem.closest(this.listItem).html(
			"<span class='" + conf.listText + "'>" +
			$(this.itemBox).val() +
			"</span>" +
			twoButtons
		);
	},
	cancel: function (elem) {
		var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
		var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
		var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
		elem.closest(this.listItem).html(
			"<span class='" + conf.listText + "'>" +
			currentList.name +
			"</span>"+
			twoButtons
		);
	}
};

module.exports = currentList;