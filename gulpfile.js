var elixir = require('laravel-elixir');

/*
 |--------------------------------------------------------------------------
 | Elixir Asset Management
 |--------------------------------------------------------------------------
 |
 | Elixir provides a clean, fluent API for defining some basic Gulp tasks
 | for your Laravel application. By default, we are compiling the Sass
 | file for our application, as well as publishing vendor resources.
 |
 */

elixir.config.bowerDir = './resources/assets/bower/';

var bowerpath = './resources/assets/bower/';

var paths = {
    'bootstrap': bowerpath + 'bootstrap/',
    'jquery': bowerpath + 'jquery/',
    'jqueryui': bowerpath + 'jquery-ui/',
    'jqueryui_bootstrap': bowerpath + 'jquery-ui-bootstrap/',
    'jqueryui_sortable_animation': bowerpath + 'jquery-ui-sortable-animation/',
    'jquery_easing': bowerpath + 'jquery.easing/',
    'progressbar': bowerpath + 'bootstrap-progressbar/',
    'slider': bowerpath + 'seiyria-bootstrap-slider/',
    'tagsinput': bowerpath + 'bootstrap-tagsinput/',
    'select': bowerpath + 'bootstrap-select/',
    'datatables': bowerpath + 'datatables.net/',
    'datatables_bs': bowerpath + 'datatables.net-bs/',
    'typeahead': bowerpath + 'typeahead.js/',
    'toastr': bowerpath + 'toastr/',
    'jquery_expander': bowerpath + 'jquery.expander/',
    'simple_expand': bowerpath + 'simple-expand/',
    'jquery_cookie': bowerpath + 'jquery.cookie/',
    'jquery_steps': bowerpath + 'jquery.steps/',
    'fonts': bowerpath + 'font-awesome/',
    'images': './resources/assets/images/',
    'css': './resources/assets/css/',
    'js': './resources/assets/js/'
    //'bootstrap_modal_form': bowerpath + 'laravel-bootstrap-modal-form/',
};

elixir(function(mix) {

    mix.sass([
        'app.scss',
        paths.fonts + 'scss/font-awesome.scss'
    ],'public/css/app.css');

    mix.copy(paths.images + '**', 'public/images/');
    mix.copy(paths.jquery + 'dist/jquery.min.js', 'public/js/');
    mix.copy(paths.toastr + 'toastr.min.js', 'public/js/');
    mix.copy(paths.css + 'pdf.css', 'public/css/');
    mix.copy(paths.bootstrap + 'fonts/**', 'public/fonts/bootstrap/');

    mix.scripts([
        paths.jquery_steps + 'build/jquery.steps.min.js',
        paths.js + 'plan.js', 'public/js/'
    ], './public/js/survey.js');

    mix.scripts([
        paths.jqueryui + 'jquery-ui.min.js',
        paths.jquery_easing + 'js/jquery.easing.min.js',
        paths.bootstrap + 'dist/js/bootstrap.min.js',
        paths.progressbar + 'bootstrap-progressbar.js',
        paths.tagsinput + 'dist/bootstrap-tagsinput.js',
        paths.datatables + 'js/jquery.dataTables.js',
        paths.datatables_bs + 'js/dataTables.bootstrap.js',
        //paths.slider + 'dist/bootstrap-slider.min.js',
        paths.select + 'dist/js/bootstrap-select.min.js',
        paths.typeahead + 'dist/typeahead.jquery.js',
        paths.jquery_cookie + 'jquery.cookie.js',
        paths.jquery_expander + 'jquery.expander.js',
        paths.simple_expand + 'src/simple-expand.min.js'

    ], './public/js/vendor.js');

    mix.scripts([
        paths.js + 'main.js',
        paths.js + 'admin.js'
    ], './public/js/my.jquery.js');

    mix.styles([
        paths.css + 'datepicker.jqueryui.css',
        paths.css + 'jquery.steps.css',
        paths.css + 'style.css',
        paths.css + 'admin.css'
    ], './public/css/my.style.css');

    mix.styles([
        paths.jqueryui_bootstrap + 'jquery.ui.theme.font-awesome.css',
        paths.toastr + 'toastr.css',
        paths.tagsinput + 'dist/bootstrap-tagsinput.css',
        paths.slider + 'dist/css/bootstrap-slider.css',
        paths.select + 'dist/css/bootstrap-select.css',
        paths.datatables_bs + 'css/dataTables.bootstrap.css'
    ], './public/css/vendor.css');
});