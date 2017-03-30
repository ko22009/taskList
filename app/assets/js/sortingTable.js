;(function () {
	'use strict';

	function bind(func, context) {
		return function() { // (*)
			return func.apply(context, arguments);
		};
	}

	function copyToDom(obj) {
		var tbody = [];
		for (var i = 0; i < obj.length; i++) {
			tbody[i] = $('<tr></tr>');
			for (var key in obj[i]) {
				if (obj[i].hasOwnProperty(key)) {
					var elem = $('<td></td>').append(obj[i][key]);
					$(tbody[i]).append(elem);
				}
			}
		}
		$(this.ref).html(tbody);
	}

	function compareClassIncrease(arg1, arg2) {
		if (arg1[this.num] < arg2[this.num]) return 1;
		else if (arg1[this.num] > arg2[this.num]) return -1;
		else return 0;
	}

	function compareClassDecrease(arg1, arg2) {
		if (arg1[this.num] < arg2[this.num]) return -1;
		else if (arg1[this.num] > arg2[this.num]) return 1;
		else return 0;
	}

	// сортировка реализована только по одному элементу
	// для множественной сортировки, нужно реализовывать глубокое сравнение

	function SortingTableCreator(htmlHref, sortHref) {

		var self = this; // чтобы не потерять контекст
		self.ref = htmlHref;
		self.srcRef = sortHref;
		self.clone = '';
		self.origin = '';

		self.init = function () {
			self.count = $(self.ref).find('tr:first').children('td').length;
			SortingTableCreator.updateClone = bind(SortingTableCreator.updateClone, self);
			SortingTableCreator.updateClone();
			self.origin = JSON.parse(JSON.stringify(self.clone));
			copyToDom = bind(copyToDom, self); // привязка к контексту
			compareClassIncrease = bind(compareClassIncrease, self);
			compareClassDecrease = bind(compareClassDecrease, self);
			$(self.srcRef).click(function () {
				self.sortColumn.call(this);
			});
		};

		self.sortColumn = function () {
			// globals
			var sort = $(this).attr("data-sort");
			var num = $(this).closest('td').index();
			var sortColumn = this;
			if (sort == undefined) {
				$(this).closest('tr').find('td span').removeAttr("data-sort");
				$(this).attr("data-sort", 1);
				$(this).closest('tr').find('td span').removeClass().addClass('glyphicon glyphicon-sort');
				$(this).removeClass().addClass('glyphicon glyphicon-sort-by-alphabet-alt');
				self.clone.sort(compareClassIncrease); // привязали ф-цию к контексту
				copyToDom(self.clone);
			} else if (sort == 1) {
				$(this).closest('tr').find('td span').removeAttr("data-sort");
				$(this).attr("data-sort", -1);
				$(this).closest('tr').find('td span').removeClass().addClass('glyphicon glyphicon-sort');
				$(this).removeClass().addClass('glyphicon glyphicon-sort-by-alphabet');
				self.clone.sort(compareClassDecrease);
				copyToDom(self.clone);
			} else if (sort == -1) {
				$(this).closest('tr').find('td span').removeAttr("data-sort");
				$(this).removeClass().addClass('glyphicon glyphicon-sort');
				$(this).closest('tr').find('td input').val('');
				self.clone = JSON.parse(JSON.stringify(self.origin));
				copyToDom(self.origin);
			}
		};
	}

	// Статичный метод, чтобы можно было постучаться с фильтра - расширяем базовый прототип
	SortingTableCreator.updateClone = function () {
		var self = this;
		var sortArrClass = [];
		for (var i = 0; i < self.count; i++) {
			var elem = $(self.ref).find('tr:visible td').filter(function (index) {
				return index % self.count === i;
			});
			for (var j = 0; j < elem.length; j++) {
				if (sortArrClass[j] == undefined) sortArrClass[j] = [];
				sortArrClass[j][i] = $(elem[j]).text();
			}
		}
		self.clone = JSON.parse(JSON.stringify(sortArrClass));
	};

	function sortingTable(htmlHref, sortHref) {
		var sortingTableInit = new SortingTableCreator(htmlHref, sortHref);
		sortingTableInit.init();
		window.updateClone = SortingTableCreator.updateClone;
		// должно быть внутри, так как SortingTableCreator создается здесь и расширение updateClone доступным становится
	}

	window.sortingTable = sortingTable;

})();