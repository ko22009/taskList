var sortingTable = require('./sortingTable');

var filterTable = function (HTMLTBodyRef, aFilters) {
	var filters = {};
	for (var i = 0; i < aFilters.length; i++) {
		filters[i] = new filterTable.Filter(aFilters[i]);
		filters[i]._setAction(function () {
			var rows = $(HTMLTBodyRef).children();
			walkThrough(rows);
		});
	}
	// каждый раз по всем фильтрам проверяет
	var walkThrough = function (rows) {
		var tr;
		for (var i = 0; i < rows.length; i += 1) {
			tr = rows[i];
			for (var f in filters) {
				if (filters.hasOwnProperty(f)) {
					// проверка фильтра со значение, введенное в фильтр, скрыть или показать
					if (filters[f].validate(tr.children[f].innerText) === false) {
						$(tr).hide();
						break;
					} else {
						$(tr).show();
					}
				}
			}
		}
	};
};

filterTable.Filter = function (HTMLElementRef) {
	this.filters = Array.isArray(HTMLElementRef) ? HTMLElementRef : [HTMLElementRef];
	this.validate = function (cellValue) {
		for (var i = 0; i < this.filters.length; i += 1) {
			if (cellValue.toUpperCase().includes($(this.filters[i]).val().toUpperCase()) === false)
				return false;
		}
	};

	// подписываем события
	this._setAction = function (callback) {
		for (var i = 0; i < this.filters.length; i += 1) {
			$(this.filters[i]).change(callback);
			$(this.filters[i]).keyup(callback);
		}
	}
};

module.exports = filterTable;