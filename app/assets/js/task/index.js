var sortingTable = require('./../sortingTable');
sortingTable = sortingTable('#target', '.sort');
var currentTask = require('./currentTask')(sortingTable);
var conf = require('./conf');
var Digits = require('./../Digits');

var listItems = "#" + conf.listItems;
var listItem = conf.listItem;
var button_delete = "." + conf.editForm.button_delete;
var button_edit = "." + conf.editForm.button_edit;
var prev = {id:'', val: ''};

$(function () {

	currentTask.readAll();

	// отмена - закрытие окна
	$('#myModal').on('hidden.bs.modal', function () {
		currentTask.empty();
	});

	// создание / обновление
	$("#myModal").on("click", ".save", function () {
		if(currentTask.isCreate) currentTask.create();
		else currentTask.updateData();
	});

	// обновление файла, после кнопки обзор
	$(document).on('change', ':file', function() {
		currentTask.updateFile(this);
	});

	$('button[data-target="#myModal"]').click(function(){
		$('#myModalLabel').text('Создание новой записи');
	});

	$(listItems).on("click", button_delete, function () {
		currentTask.id = $(this).closest(listItem).attr("id");
		currentTask.remove(this);
	});

	$(listItems).on("click", button_edit, function () {
		$('#myModalLabel').text('Обновление записи');
		$('#myModal .save').text('Обновить');
		currentTask.update(this);
	});

	$('#target').on('click', 'tr td', function() {
		if($(this).index() == 2) {
			if (prev.id) $('#' + prev.id).find('td').eq(2).text(prev.val);
			if (prev.id != $(this).closest('tr').attr('id')) {
				prev.id = $(this).closest('tr').attr('id');
				prev.val = $(this).text();
				$(this).text(Digits(prev.val));
			} else {
				if (prev.id) $('#' + prev.id).find('td').eq(2).text(prev.val);
				prev.id = '';
				prev.val = '';
			}
		}
	});

});