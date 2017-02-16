<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

// HOMEPAGE
Route::group(['middleware' => 'guest'], function() {

    // HOME SCREEN
    Route::get( '/', ['uses' => 'HomeController@index', 'as'   => 'home']);

    // LOGIN
    Route::get('/login', ['uses' => 'UserController@getLogin']);
    Route::post('/login', ['uses' => 'UserController@postLogin', 'as' => 'login']);

    // REGISTER
    Route::get('/register', ['uses' => 'UserController@getRegister']);
    Route::post('/register', ['uses' => 'UserController@postRegister', 'as' => 'register']);

});

Route::group(['middleware' => 'auth'], function()
{
    // DASHBOARD
    Route::get('/my/dashboard', [
        'uses' => 'PlanController@index',
        'as' => 'dashboard'
    ]);

    // LOGOUT
    Route::get('/logout', [
        'uses' => 'UserController@postLogout',
        'as' => 'logout'
    ]);

    // PROFILE
    Route::get('/my/profile', [
        'uses' => 'UserController@getProfile'
    ]);
    Route::post('/profile', [
        'uses' => 'UserController@postProfile',
        'as' => 'update_profile'
    ]);

    // FEEDBACK
    Route::post('/feedback', [
        'uses' => 'DashboardController@feedback',
        'as' => 'feedback'
    ]);

    /* PLAN */

    /* SHOW */
    Route::get('/plan/{id}/show',[
        'uses' => 'PlanController@show',
        'as' => 'show_plan'
    ]);
    /* CREATE */
    Route::post('/plan/create', [
        'uses' => 'PlanController@create',
        'as' => 'create_plan'
    ]);
    /* EDIT */
    Route::get('/plan/{project_number}/{version}/edit', [
        'uses' => 'PlanController@edit',
        'as' => 'edit_plan'
    ]);
    /* UPDATE */
    Route::post('/plan/update', [
        'uses' => 'PlanController@update',
        'as' => 'update_plan'
    ]);
    /* EXPORT */
    Route::get('/plan/{project_number}/{version}/export/{format?}', [
        'uses' => 'PlanController@export',
        'as' => 'export_plan'
    ]);
    /* EMAIL */
    Route::post('/plan/email', [
        'uses' => 'PlanController@email',
        'as' => 'email_plan'
    ]);
    /* TOGGLE FINAL STATE */
    Route::get('/plan/{project_number}/{version}/toggle', [
        'uses' => 'PlanController@toggle',
        'as' => 'toggle_plan'
    ]);
    /* VERSION */
    Route::post('/plan/version', [
        'uses' => 'PlanController@version',
        'as' => 'version_plan'
    ]);



    Route::get('/plan/{project_number}/{version}/test_output_filter', [
        'uses' => 'PlanController@test_output_filter',
        'as' => 'test_output_filter'
    ]);


    Route::group(['middleware' => 'App\Http\Middleware\AdminMiddleware', 'prefix' => 'admin'], function() {
        /* DASHBOARD */
        Route::get( '/', [
            'uses' => 'Admin\DashboardController@index',
            'as'   => 'admin'
        ] );

        /* REST ENTITIES */
        Route::resource( 'user', 'Admin\UserController' );
        Route::resource( 'project', 'Admin\ProjectController' );
        Route::resource( 'plan', 'Admin\PlanController' );
        Route::resource( 'template', 'Admin\TemplateController' );
        Route::resource( 'section', 'Admin\SectionController' );
        Route::resource( 'question', 'Admin\QuestionController' );

        /* TESTING */

        /* LOG VIEWER */
        Route::get( 'logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index' );

        /* PHPINFO */
        Route::get( 'info', [
            'as' => 'phpinfo',
            function () {
                return phpinfo();
            }
        ] );

        /* RAW IVMC */
        Route::get( '/project/{project_number}/raw_ivmc', [
            'uses' => 'ProjectController@raw_ivmc',
            'as'   => 'raw_ivmc'
        ] );

        /* RANDOM IVMC */
        Route::get( 'random_ivmc', [
            'uses' => 'ProjectController@random_ivmc',
            'as'   => 'random_ivmc'
        ] );
    });
});