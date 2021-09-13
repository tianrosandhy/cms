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

// compile xoric asset
const XORIC_BASE = 'public/xoric';

mix.styles([
    XORIC_BASE + '/libs/bootstrap-tagsinput/bootstrap-tagsinput.css',
    XORIC_BASE + '/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css',
    XORIC_BASE + '/libs/flatpickr/flatpickr.min.css',
    XORIC_BASE + '/libs/dropzone/dropzone.css',
    XORIC_BASE + '/libs/toastr/toastr.min.css',
    XORIC_BASE + '/libs/select2/select2.min.css',
    XORIC_BASE + '/libs/switchery/css/switchery.min.css',
], 'public/xoric/css/app-plugins-compiled.css');
