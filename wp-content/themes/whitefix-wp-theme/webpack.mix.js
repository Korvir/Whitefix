const mix = require('laravel-mix');


mix
	.js('src/js/app.js', 'dist/js')
	.sass('src/scss/app.scss', 'dist/css')
	.sass('src/scss/icons/themify-icons.scss', 'dist/css')
	.copy('src/scss/fonts', 'dist/css/fonts')
	// .disableSuccessNotifications();
	.options({
		processCssUrls: false,
	});
