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

var vendor_path = './node_modules/';

var paths = {
    'jquery': vendor_path + 'jquery/',
    'bootstrap': vendor_path + 'bootstrap/',
    'bootstrap_switch': vendor_path + 'bootstrap-switch/',
    'jqueryui': vendor_path + 'components-jqueryui/',
    'jqueryui_bootstrap': vendor_path + 'jquery-ui-bootstrap/',
    'jqueryui_sortable_animation': vendor_path + 'jquery-ui-sortable-animation/',
    'jquery_easing': vendor_path + 'jquery.easing/',
    'progressbar': vendor_path + 'bootstrap-progressbar/',
    'tagsinput': vendor_path + 'bootstrap-tagsinput/',
    'select': vendor_path + 'bootstrap-select/',
    'datatables': vendor_path + 'datatables.net/',
    'datatables_bs': vendor_path + 'datatables.net-bs/',
    'typeahead': vendor_path + 'typeahead.js/',
    'toastr': vendor_path + 'toastr/',
    'jquery_collapse': vendor_path + 'jquery-collapse/',
    'jquery_expander': vendor_path + 'jquery-expander/',
    'simple_expand': vendor_path + 'simple-expand/',
    'jquery_cookie': vendor_path + 'jquery.cookie/',
    'jquery_steps': vendor_path + 'jquery-steps/',
    'vue': vendor_path + 'vue/',
    'fonts': vendor_path + 'font-awesome/',
    'images': './resources/assets/images/',
    'css': './resources/assets/css/',
    'js': './resources/assets/js/'
};

mix.sass('resources/assets/sass/app.scss','public/css/app.css');

mix.copy(paths.images, 'public/images/', false);
mix.copy(paths.css + 'pdf.css', 'public/css/');
mix.copy(paths.bootstrap + 'fonts/**', 'public/fonts/bootstrap/');

//mix.js(paths.jquery + 'dist/jquery.min.js', 'public/js/');
mix.js(paths.vue + 'dist/vue.min.js', 'public/js/');
mix.js(paths.js + 'app.js', 'public/js');

mix.scripts([
    paths.jqueryui + 'jquery-ui.js',
    paths.jquery_easing + 'js/jquery.easing.min.js',
    paths.jquery_steps + 'build/jquery.steps.min.js',
    paths.bootstrap + 'dist/js/bootstrap.min.js',
    paths.bootstrap_switch + 'dist/js/bootstrap-switch.min.js',
    paths.toastr + 'toastr.js',
    paths.jquery_collapse + 'src/jquery.collapse.js',
    paths.progressbar + 'bootstrap-progressbar.js',
    paths.tagsinput + 'dist/bootstrap-tagsinput.js',
    paths.datatables + 'js/jquery.dataTables.js',
    paths.datatables_bs + 'js/dataTables.bootstrap.js',
    paths.select + 'dist/js/bootstrap-select.min.js',
    paths.typeahead + 'dist/typeahead.jquery.js',
    paths.jquery_cookie + 'jquery.cookie.js',
    paths.jquery_expander + 'jquery.expander.js',
    paths.simple_expand + 'src/simple-expand.min.js'
], './public/js/vendor.js');

mix.babel([
    paths.js + 'main.js',
    paths.js + 'admin.js',
    paths.js + 'survey.js'
], './public/js/my.jquery.js');

mix.styles([
    paths.css + 'datepicker.jqueryui.css',
    paths.css + 'jquery.steps.css',
    paths.css + 'style.css',
    paths.css + 'admin.css',
    paths.css + 'form.css',
], './public/css/my.style.css');

mix.styles([
    paths.jqueryui_bootstrap + 'jquery.ui.theme.css',
    paths.jqueryui_bootstrap + 'jquery.ui.theme.font-awesome.css',
    paths.bootstrap_switch + 'dist/css/bootstrap3/bootstrap-switch.css',
    paths.toastr + 'build/toastr.css',
    paths.tagsinput + 'dist/bootstrap-tagsinput.css',
    paths.select + 'dist/css/bootstrap-select.css',
    paths.datatables_bs + 'css/dataTables.bootstrap.css'
], './public/css/vendor.css');
