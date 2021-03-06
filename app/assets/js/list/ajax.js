var Ajax = require('./../interface/ajax');

function ListAjax(url) {
	this.url = url;
}

ListAjax.prototype = Object.create(Ajax);

ListAjax.prototype.create = function (name, afterdo) {
	var data = null;
	$.ajax({
		url: '/api/' + this.url + '/create',
		type: 'POST',
		data: { name: name },
		dataType: 'json',
		success: function (info) {
			data = info;
		},
		error: function (request, message, error) {
			console.log(request, message, error);
			data = null;
		}
	}).done(function () {
		afterdo(data);
	});
};

ListAjax.prototype.read = function (id, afterdo) {
	var data = null;
	$.ajax({
		url: '/api/' + this.url + '/read',
		type: 'POST',
		data: { id: id },
		dataType: 'json',
		success: function (info) {
			data = info;
		},
		error: function (request, message, error) {
			console.log(request, message, error);
			data = null;
		}
	}).done(function () {
		afterdo(data);
	});
};

ListAjax.prototype.update = function (updateData, afterdo) {
	var data = null;
	$.ajax({
		url: '/api/' + this.url + '/update',
		type: 'POST',
		data: {id: updateData.id, name: updateData.name},
		dataType: 'json',
		success: function (info) {
			data = info;
			//console.log(data);
		},
		error: function (request, message, error) {
			console.log(request, message, error);
			data = null;
		}
	}).done(function () {
		afterdo(data);
	});
};

ListAjax.prototype.delete = function (id, afterdo) {
	$.ajax({
		url: '/api/' + this.url + '/delete',
		type: 'POST',
		data: {id: id},
		dataType: 'json',
		success: function (data) {
			//console.log(data);
		},
		error: function (request, message, error) {
			console.log(request, message, error);
		}
	}).done(function () {
		afterdo();
	});
};

module.exports = function(url) {
	return new ListAjax(url);
};