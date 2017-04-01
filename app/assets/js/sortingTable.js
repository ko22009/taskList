// сортировка реализована только по одному элементу
// для множественной сортировки, нужно реализовывать глубокое сравнение

function SortingTableCreator(htmlHref, sortHref) {
	var self = this; // чтобы не потерять контекст
	self.ref = htmlHref;
	self.srcRef = sortHref;
	self.tableData = '';
	self.num = 0;
	self.rowData = '';

	self.compare = function(type) {
		if(type == 1)
		{
			for(var i = 0; i < self.rowData.length - 1; i++){
				for(var j = 0; j < self.rowData.length; j++){
					if(i != j)
					if($($(self.rowData[i]).find('td')[self.num]).find('.custom_text').text().toLowerCase() < $($(self.rowData[j]).find('td')[self.num]).find('.custom_text').text().toLowerCase()){
						$(self.rowData[j]).insertBefore($(self.rowData[i]));
					}
				}
			}
		}else if (type == 2)
		{
			for(var i = 0; i < self.rowData.length - 1; i++){
				for(var j = 0; j < self.rowData.length; j++){
					if(i != j)
					if($($(self.rowData[i]).find('td')[self.num]).find('.custom_text').text().toLowerCase() > $($(self.rowData[j]).find('td')[self.num]).find('.custom_text').text().toLowerCase()){
						$(self.rowData[j]).insertBefore($(self.rowData[i]));
					}
				}
			}
		} else if(type == 3)
		{
			for(var i = 0; i < self.rowData.length - 1; i++){
				for(var j = 0; j < self.rowData.length; j++){
					if(i != j)
					if($(self.rowData[i]).attr('id') < $(self.rowData[j]).attr('id')){
						$(self.rowData[i]).insertBefore($(self.rowData[j]));
					}
				}
			}
		}
		console.log($('#target').children());
	};

	self.init = function () {
		self.elem = $(self.ref);
		self.tableData = $('#sorting tbody');
		self.rowData = $(self.tableData).find('tr');
		$(self.srcRef).click(function () {
			self.sortColumn.call(this);
		});
	};

	self.sortColumn = function () {
		var sort = $(this).attr("data-sort");
		self.num = $(this).closest('th').index();
		var sortColumn = this;
		$(self.ref).find('.cancel').click(); // убираем поле редактирование
		if (sort == undefined) {
			$(this).closest('th').find('span.sort').removeAttr("data-sort");
			$(this).attr("data-sort", 1);
			$(this).closest('th').find('span.sort').removeClass().addClass('glyphicon glyphicon-sort sort');
			$(this).removeClass().addClass('glyphicon glyphicon-sort-by-alphabet-alt sort');
			self.compare(1);
		} else if (sort == 1) {
			$(this).closest('th').find('span.sort').removeAttr("data-sort");
			$(this).attr("data-sort", -1);
			$(this).closest('tr').find('span.sort').removeClass().addClass('glyphicon glyphicon-sort sort');
			$(this).removeClass().addClass('glyphicon glyphicon-sort-by-alphabet sort');
			self.compare(2);
		} else if (sort == -1) {
			$(this).closest('th').find('span.sort').removeAttr("data-sort");
			$(this).removeClass().addClass('glyphicon glyphicon-sort sort');
			self.compare(3);
			self.clear();
		}
	};

	self.clear = function() {
		$('#filter input').val('');
		$("#filter th span").removeAttr("data-sort");
		$("#filter th span.sort").removeClass().addClass('glyphicon glyphicon-sort sort');
	};

}

module.exports = function (htmlHref, sortHref) {
	return new SortingTableCreator(htmlHref, sortHref);
};