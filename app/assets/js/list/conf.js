var conf = {
	listItems: "list_of_items", // list_of_items - задается в views/list/index.php
	listItem: 'list-group-item2',
	listText: "custom_text",
	textBox: "custom_textbox", // id - задается в views/list/index.php
	itemBox: "itembox",
	createForm: "main_input_box", // id - задается в views/list/index.php
	editForm: {
		form: "form.edit_input_box",
		button_edit: "button.edit",
		button_cancel: "input.cancel",
		button_save: "input.save",
		button_delete: "button.delete"
	}
};

module.exports = conf;