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
mix.webpackConfig({
    output: {
        publicPath: '/css/app/'
    }
});

mix.setPublicPath('public/app/css/')
    .postCss('resources/css/app.css', 'app.css', [
        require('postcss-import'),
        require('tailwindcss'),
    ]);

mix.disableNotifications();
