var conf = {
	listItems: "target", // list_of_items - задается в views/list/index.php
	listItem: 'tr',
	listText: "custom_text",
	textBox: "custom_textbox", // id - задается в views/list/index.php
	itemBox: "itembox",
	createForm: "main_input_box", // id - задается в views/list/index.php
	editForm: {
		form: "edit_input_box",
		button_edit: "edit",
		button_cancel: "cancel",
		button_save: "save",
		button_delete: "delete"
	}
};

module.exports = conf;