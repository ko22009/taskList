$(document).ready(function(){

	var currentList = {
		id: '',
		name: '',
		remove: function (elem) {
			elem.closest("li").remove();
		},
		create: function () {
			// кнопки справа - удалить и редактировать
			var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
			var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
			var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";

			$(".list_of_items").append(
				"<li class='list-group-item list-group-item2' id='todo_1'>"
				+ "<span class='custom_text'>"
				+ $("#custom_textbox").val()
				+ "</span>"
				+ twoButtons
				+ "</li>"
			);
			// очистка поля ввода
			$("#custom_textbox").val('');
		},
		editForm: function (elem) {
			var editItemBox =
				"<form class='edit_input_box col-lg-6' style='padding: 0'>" +
				"<div class='input-group'>" +
				"<input type='text' class='itembox form-control' style='height: auto' placeholder='" + currentList.name + "' >" +
				"<span class='input-group-btn'>" +
				"<input class='btn btn-default cancel' type='submit' value='Отменить'>" +
				"<input class='btn btn-default save' type='submit' value='Сохранить'>" +
				"</span>" +
				"</div>" +
				"</form>";

			// вставляем форму редактирования вместо записи
			elem.closest(listItem).html(editItemBox);
		},
		save: function (elem) {
			// кнопки
			var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
			var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
			var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
			elem.closest('.list-group-item2').html(
				"<span class='custom_text'>" +
				$(".itembox").val() +
				"</span>" +
				twoButtons
			);
		},
		cancel: function (elem) {
			var deleteButton = "<button class='delete btn btn-warning'>Удалить</button>";
			var editButton = "<button class='edit btn btn-success'>Редактировать</button>";
			var twoButtons = "<div class='btn-group pull-right'>" + deleteButton + editButton + "</div>";
			elem.closest('.list-group-item2').html(
				"<span class='custom_text'>" +
				currentList.name +
				"</span>"+
				twoButtons
			);
		}
	};

	var listItems = ".list_of_items";
	var listItem = '.list-group-item2';
	var listText = "span.custom_text";
	var createForm = "form#main_input_box";

	var editForm = {
		form: "form.edit_input_box",
		button_edit: "button.edit",
		button_cancel: "input.cancel",
		button_save: "input.save",
		button_delete: "button.delete"
	};

	// создание нового значения
	$(createForm).submit(function(event){
		//блокировка стандартного поведения
		event.preventDefault();
		currentList.create();
	});

	// удаление значения
	$(listItems).on("click", editForm.button_delete, function(){
		currentList.id = $(this).closest(listItem).attr("id");
		currentList.remove($(this));
	});

	// редактирование записи
	$(listItems).on("click", editForm.form, function (){

		currentList.name = $(this).closest(listItem).find(listText).text();
		currentList.id = $(this).closest(listItem).attr("id");
		// получение текстового значения в записи, на которой нажали кнопку редактировать
		// форма редактирование записи
		currentList.editForm($(this));

		// отмена редактирования - должно быть внутри, иначе пустая замена
		$(editForm.form).on("click", editForm.button_cancel, function(){
			event.preventDefault(); // предотвращение стандартных событий - Form submission canceled because the form is not connected
			currentList.cancel($(this));
		});

		// сохранение - должно быть внутри, иначе пустая замена
		$(editForm.form).on("click", editForm.button_save, function () {
			event.preventDefault();
			currentList.save($(this));
		});

	});

});