function Ajax() {
	this.url = '';
	this.create = function(data){};
	this.read = function (id){};
	this.update = function(){};
	this.delete = function(id){};
}

module.exports = function() {
	return Ajax;
};