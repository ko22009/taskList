var currentTask = require('./currentTask');
var conf = require('./conf');

var listItems = "#" + conf.listItems;
var listItem = conf.listItem;
var button_delete = "." + conf.editForm.button_delete;

$(function () {

	currentTask.readAll();

	// отмена - закрытие окна
	$('#myModal').on('hidden.bs.modal', function () {
		currentTask.empty();
	});

	// создание / обновление?
	$("#myModal").on("click", ".save", function () {
		currentTask.create();
	});

	// обновление файла, после кнопки обзор
	$(document).on('change', ':file', function() {
		currentTask.updateFile(this);
	});

	$(listItems).on("click", button_delete, function () {
		currentTask.id = $(this).closest(listItem).attr("id");
		currentTask.remove($(this));
	});

});