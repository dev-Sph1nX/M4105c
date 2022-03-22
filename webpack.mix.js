const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel applications. By default, we are compiling the CSS
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.js('resources/js/app.js', 'public/js')
    .vue({
        version: 2
    })
    .postCss("resources/css/app.css", "public/css", [    
        require("tailwindcss")
    ])
    .options({
        hmrOptions: {
            host: '51.83.36.122',
            port: '8086'
        }
    })
    .webpackConfig({
        devServer: {
            host: '51.83.36.122',
            port: '8086'
        }
    });
