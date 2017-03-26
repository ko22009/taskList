var conf = require('./conf');
var currentList = require('./currentList');
var listItems = "." + conf.listItems;
var listItem = "." + conf.listItem;
var createForm = "#" + conf.createForm;
var listText = "." + conf.listText;

// создание нового значения
$(createForm).submit(function(event){
	//блокировка стандартного поведения
	event.preventDefault();
	currentList.create();
});

// удаление значения
$(listItems).on("click", conf.editForm.button_delete, function(){
	currentList.id = $(this).closest(listItem).attr("id");
	currentList.remove($(this));
});

// редактирование записи
$(listItems).on("click", conf.editForm.button_edit, function (){
	currentList.name = $(this).closest(listItem).find(listText).text();
	currentList.id = $(this).closest(listItem).attr("id");
	// получение текстового значения в записи, на которой нажали кнопку редактировать
	// форма редактирование записи
	currentList.editForm($(this));

	// отмена редактирования - должно быть внутри, иначе пустая замена
	$(conf.editForm.form).on("click", conf.editForm.button_cancel, function(){
		event.preventDefault(); // предотвращение стандартных событий - Form submission canceled because the form is not connected
		currentList.cancel($(this));
	});

	// сохранение - должно быть внутри, иначе пустая замена
	$(conf.editForm.form).on("click", conf.editForm.button_save, function () {
		event.preventDefault();
		currentList.save($(this));
	});

});