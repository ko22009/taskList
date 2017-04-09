var _URL = window.URL || window.webkitURL;

function isSupportedBrowser() {
	return window.File && window.FileReader && window.FileList && window.Image;
}

function isGoodImage(width, height) {
	var deferred = jQuery.Deferred();
	var image = new Image();
	image.onload = function() {
		// Check if image is bad/invalid
		if (this.width + this.height === 0) {
			this.onerror();
			return;
		}
		// Check the image resolution
		if (this.width <= width && this.height <= height) {
			deferred.resolve({});
		} else {
			deferred.resolve({error: 'Неверное разрешение изображения'});
		}
	};

	image.onerror = function() {
		deferred.resolve({error: 'Неверный формат изображения'});
	};
	image.src = _URL.createObjectURL(file); // ?
	return deferred.promise();
}

module.exports = function () {
	return {
		isSupportedBrowser: isSupportedBrowser,
		isGoodImage: isGoodImage
	}
};