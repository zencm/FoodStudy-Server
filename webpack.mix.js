let mix = require('laravel-mix');

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

mix
	.copy('node_modules/jquery-serializejson/jquery.serializejson.min.js', 'public/js')
	.js('resources/js/app.js', 'public/js')
    .sass('resources/sass/app.scss', 'public/css')
	.js('resources/assets/js/app.js', 'public/page/js')
    .sass('resources/assets/sass/app.scss', 'public/page/css')
    .copyDirectory('resources/assets/images', 'public/page/images');
