const path = require('path');
const mix = require('laravel-mix');
require('laravel-mix-tailwind');
require('laravel-mix-svg-vue');

// Compile dashboard assets
mix.js('resources/js/app.js', 'public/js/app.js')
    .svgVue()
    .sourceMaps();
mix.sass('resources/sass/app.scss', 'public/css/app.css')
    .tailwind('./tailwind.config.js');

// Webpack config
mix.webpackConfig({
    resolve: {
        alias: {
            '@': path.resolve('resources/js'),
            'moment': path.resolve(__dirname, 'node_modules', 'moment', 'moment.js'),
        },
    },
});

// Copy tinymce skins
mix.copy('node_modules/tinymce/skins', 'public/js/skins');

// Mix version
if (mix.inProduction()) {
    mix.version();
}

// Disable notifications
mix.disableSuccessNotifications();
