let mix = require('laravel-mix');
let tailwindcss = require('tailwindcss');

mix.sass('resources/assets/sass/app.scss', 'public/css')
	.options({
	    postCss: [ tailwindcss('./tailwind.js') ],
	    processCssUrls: false, // This is required when using laravel mix
	});
	
mix.js('resources/assets/js/app.js', 'public/js');
