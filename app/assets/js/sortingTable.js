// сортировка реализована только по одному элементу
// для множественной сортировки, нужно реализовывать глубокое сравнение

function SortingTableCreator(htmlHref, sortHref) {
	var self = this; // чтобы не потерять контекст
	self.ref = htmlHref;
	self.srcRef = sortHref;
	self.origin = '';
	self.tableData = '';
	self.num = 0;
	self.rowData = '';

	self.compare = function(asc) {
		if (asc)
		{
			for(var i = 0; i < this.rowData.length - 1; i++){
				for(var j = 0; j < this.rowData.length - (i + 1); j++){
					if($(this.rowData.item(j).getElementsByTagName('td').item(this.num)).find('.custom_text').text() > $(this.rowData.item(j+1).getElementsByTagName('td').item(this.num)).find('.custom_text').text()){
						this.tableData.insertBefore(this.rowData.item(j+1), this.rowData.item(j));
					}
				}
			}
		}else
		{
			for(var i = 0; i < this.rowData.length - 1; i++){
				for(var j = 0; j < this.rowData.length - (i + 1); j++){
					if($(this.rowData.item(j).getElementsByTagName('td').item(this.num)).find('.custom_text').text() < $(this.rowData.item(j+1).getElementsByTagName('td').item(this.num)).find('.custom_text').text()){
						this.tableData.insertBefore(this.rowData.item(j+1), this.rowData.item(j));
					}
				}
			}
		}
	}

	self.init = function () {
		self.elem = $(self.ref);
		self.tableData = document.getElementById('sorting').getElementsByTagName('tbody').item(0);
		self.updateClone();
		self.origin = $(self.rowData).clone(true, true);
		$(self.srcRef).click(function () {
			self.sortColumn.call(this);
		});
	};

	self.sortColumn = function () {
		// globals
		var sort = $(this).attr("data-sort");
		self.num = $(this).closest('th').index();
		var sortColumn = this;
		if (sort == undefined) {
			$(this).closest('th').find('span.sort').removeAttr("data-sort");
			$(this).attr("data-sort", 1);
			$(this).closest('th').find('span.sort').removeClass().addClass('glyphicon glyphicon-sort sort');
			$(this).removeClass().addClass('glyphicon glyphicon-sort-by-alphabet-alt sort');
			self.compare(true);
		} else if (sort == 1) {
			$(this).closest('th').find('span.sort').removeAttr("data-sort");
			$(this).attr("data-sort", -1);
			$(this).closest('tr').find('span.sort').removeClass().addClass('glyphicon glyphicon-sort sort');
			$(this).removeClass().addClass('glyphicon glyphicon-sort-by-alphabet sort');
			self.compare(false);
		} else if (sort == -1) {
			$(this).closest('th').find('span.sort').removeAttr("data-sort");
			$(this).removeClass().addClass('glyphicon glyphicon-sort sort');
			self.clear();
		}
	};

	self.clear = function()
	{
		$('#filter input').val('');
		$("#filter th span").removeAttr("data-sort");
		$("#filter th span.sort").removeClass().addClass('glyphicon glyphicon-sort sort');
		$(self.ref).html($(self.origin).clone(true, true));
	};

	self.updateClone = function () {
		self.rowData = self.tableData.getElementsByTagName('tr');
	};
}

module.exports = function (htmlHref, sortHref) {
	return new SortingTableCreator(htmlHref, sortHref);
};