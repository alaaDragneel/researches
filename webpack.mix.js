let mix = require('laravel-mix');
let Notifications = require('pretty-mix-notifications');
let tailwindcss = require('tailwindcss');
   
mix.extend('prettyNotifications', new Notifications);
   
/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.sass('resources/assets/sass/app.scss', 'public/css')
	.options({
	    postCss: [ tailwindcss('./tailwind.js') ],
	    processCssUrls: false, // This is required when using laravel mix
	});
	
mix.js('resources/assets/js/app.js', 'public/js');
mix.prettyNotifications();
