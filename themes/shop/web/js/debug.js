(function (window) {
	'use strict';

	// Setting favicon, title and message on the console
	// in debug mode on the local server
	if (/localhost|127\.0\.0\.1|192\.168\.\d{1,3}\.\d{1,3}/.test(window.location.hostname)) {
		var
			document = window.document,
			favicon = document.createElement('link'),
			titleText = 'DEBUG — ' + document.title;

		favicon.rel = 'icon';
		favicon.href = '/debug.ico';

		document.getElementsByTagName('head')[0].appendChild(favicon);

		document.title = titleText;

		console && console.info && console.info(titleText);
	}
})(window);
