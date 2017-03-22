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
    //'bootstrap': bowerpath + 'bootstrap-sass/assets/',
    'bootstrap': bowerpath + 'bootstrap/',
    'jquery': bowerpath + 'jquery/',
    'jqueryui': bowerpath + 'jquery-ui/',
    'progressbar': bowerpath + 'bootstrap-progressbar/',
    'slider': bowerpath + 'seiyria-bootstrap-slider/',
    //'bootstrap_modal_form': bowerpath + 'laravel-bootstrap-modal-form/',
    'tagsinput': bowerpath + 'bootstrap-tagsinput/',
    'typeahead': bowerpath + 'typeahead.js/',
    'amaranjs': bowerpath + 'AmaranJS/',
    'jquery_expander': bowerpath + 'jquery.expander/',
    'simple_expand': bowerpath + 'simple-expand/',
    'jquery_cookie': bowerpath + 'jquery.cookie/',
    //'js_cookie': bowerpath + 'js-cookie/',
    'jquery_steps': bowerpath + 'jquery.steps/',
    'fonts': bowerpath + 'font-awesome/',
    'images': './resources/assets/images/',
    'css': './resources/assets/css/',
    'js': './resources/assets/js/'
};

elixir(function(mix) {

    mix.sass([
        'app.scss',
        paths.fonts + 'scss/font-awesome.scss'
    ],'public/css/app.css');

    //mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap/');
    //mix.copy(paths.bootstrap + 'fonts/bootstrap/**', 'public/fonts/bootstrap/');

    mix.copy(paths.fonts + 'fonts/**', 'public/fonts/');
    mix.copy(paths.images + '**', 'public/images/');

    mix.copy(paths.jquery + 'dist/jquery.min.js', 'public/js/');
    //mix.copy(paths.jquery_steps + 'build/jquery.steps.js',
    mix.copy(paths.js + 'env.js', 'public/js/');
    //mix.copy(paths.js + 'plan.js', 'public/js/');
    mix.copy(paths.js + 'my.vue.js', 'public/js/');

    mix.scripts([
        paths.jquery_steps + 'build/jquery.steps.min.js',
        paths.js + 'env.js', 'public/js/',
        paths.js + 'plan.js', 'public/js/'
    ], './public/js/survey.js');

    mix.scripts([
        paths.jqueryui + 'jquery-ui.js',
        paths.bootstrap + 'dist/js/bootstrap.js',
        paths.progressbar + 'bootstrap-progressbar.js',
        paths.tagsinput + 'dist/bootstrap-tagsinput.js',
        paths.slider + 'dist/bootstrap-slider.min.js',
        //paths.bootstrap_modal_form + 'src/laravel-bootstrap-modal-form.js',
        paths.typeahead + 'dist/typeahead.jquery.js',
        paths.amaranjs + 'dist/js/jquery.amaran.js',
        //paths.js_cookie + 'src/js.cookie.js',
        paths.jquery_cookie + 'jquery.cookie.js',
        paths.jquery_expander + 'jquery.expander.js',
        //paths.jquery_steps + 'build/jquery.steps.js',
        paths.simple_expand + 'src/simple-expand.min.js'

    ], './public/js/vendor.js');

    mix.scripts([
        paths.js + 'main.js'
    ], './public/js/my.jquery.js');

    mix.styles([
        paths.css + '*.css'
    ], './public/css/my.style.css');


    mix.styles([
        paths.tagsinput + 'dist/bootstrap-tagsinput.css',
        paths.amaranjs + 'dist/css/amaran.min.css',
        paths.slider + 'dist/css/bootstrap-slider.css',
        //paths.jquery_steps + 'demo/css/jquery.steps.css'
    ], './public/css/vendor.css');
});

