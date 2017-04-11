var currentTask = require('./currentTask');

$(function () {

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

});