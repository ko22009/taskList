var _URL = window.URL || window.webkitURL;

var isSupportedBrowser = function () {
	return window.File && window.FileReader && window.FileList && window.Image;
};

var isGoodImage = function (width, height, size, file) {
	var deferred = jQuery.Deferred();
	var image = new Image();
	image.onload = function() {
		// Check if image is bad/invalid
		if (this.width + this.height === 0) {
			this.onerror('Неверный формат изображения');
			return;
		}
		if(file.size > size) {
			this.onerror('Большой объем файла');
			return;
		}
		// Check the image resolution
		if (this.width <= width && this.height <= height) {
			deferred.resolve({});
		} else {
			deferred.resolve({error: 'Неверное разрешение изображения'});
		}
	};

	image.onerror = function(err) {
		deferred.resolve({error: err});
	};
	image.src = _URL.createObjectURL(file);
	return deferred.promise();
};

module.exports.isSupportedBrowser = isSupportedBrowser;
module.exports.isGoodImage = isGoodImage;