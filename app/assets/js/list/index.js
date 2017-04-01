var conf = require('./conf');
var sortingTable = require('./../sortingTable');
sortingTable = sortingTable('#target', '.sort');
var currentList = require('./currentList')(sortingTable);
var listItems = "#" + conf.listItems;
var listItem = conf.listItem;
var createForm = "#" + conf.createForm;
var editForm = "." + conf.editForm.form;
var listText = "." + conf.listText;
var button_delete = "." + conf.editForm.button_delete;
var button_edit = "." + conf.editForm.button_edit;
var button_cancel = "." + conf.editForm.button_cancel;
var button_save = "." + conf.editForm.button_save;

currentList.readAll();

// создание нового значения
$(createForm).submit(function () {
	//блокировка стандартного поведения
	//event.preventDefault();
	currentList.create();
	return false; // preventDefault
});

// удаление значения
$(listItems).on("click", button_delete, function () {
	currentList.id = $(this).closest(listItem).attr("id");
	currentList.remove($(this));
});

// редактирование записи
$(listItems).on("click", button_edit, function () {
	currentList.name = $(this).closest(listItem).find(listText).text();
	currentList.id = $(this).closest(listItem).attr("id");
	// получение текстового значения в записи, на которой нажали кнопку редактировать
	// форма редактирование записи
	currentList.editForm($(this));

	// отмена редактирования - должно быть внутри, иначе пустая замена
	$(editForm).on("click", button_cancel, function () {
		currentList.cancel($(this));
		return false;
	});

	// сохранение - должно быть внутри, иначе пустая замена
	$(editForm).on("click", button_save, function () {
		currentList.save($(this));
		return false;
	});

});