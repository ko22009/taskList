var $ = require('jquery');

module.exports = {
	init: function () {
		this.itemListEvents();
		this.readItems();
	},
	itemListEvents: function () {
		$('#add').click(this.addItem);
		var item = $('.items-list tr#item');
		item.find('a#delete').on('click', this.deleteItem);
		item.find('a#edit').on('click', this.editItem);
	},
	deleteItem: function() {

	},
	editItem: function () {

	},
	addItem: function () {

	},
	readItems: function () {
		var item = $('.items-list tr#item');
		$.ajax({url: '/user/readAll', success: function(result){
			//$(".items-list").html(result);
			json
		}});
		//item.children('login')
	}
};