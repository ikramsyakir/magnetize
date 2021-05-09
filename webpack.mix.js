const mix = require('laravel-mix');

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

mix.js('resources/js/app.js', 'public/js')
    .css('resources/css/app.css', 'public/css')
    .copy('node_modules/@tabler/core/dist', 'public/vendor/tabler/dist')
    .copy('node_modules/@tabler/icons/iconfont', 'public/vendor/tabler/icons')
    .copy('node_modules/summernote/dist', 'public/vendor/summernote/dist')
    .copy('node_modules/@fortawesome/fontawesome-free/css/all.min.css', 'public/css/font-awesome.css')
    .copy('node_modules/@fortawesome/fontawesome-free/js/all.min.js', 'public/js/font-awesome.js')
    .copy('node_modules/@fortawesome/fontawesome-free/webfonts', 'public/webfonts')
    .sourceMaps();
