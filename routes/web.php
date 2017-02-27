<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//Auth::routes();

// HOMEPAGE
Route::group(['middleware' => 'guest'], function()
{
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
    Route::get('/plan/{id}/edit', [
        'uses' => 'PlanController@edit',
        'as' => 'edit_plan'
    ]);
    /* UPDATE */
    Route::post('/plan/update', [
        'uses' => 'PlanController@update',
        'as' => 'update_plan'
    ]);
    /* EXPORT */
    Route::get('/plan/{id}/export/{format?}', [
        'uses' => 'PlanController@export',
        'as' => 'export_plan'
    ]);
    /* EMAIL */
    Route::post('/plan/email', [
        'uses' => 'PlanController@email',
        'as' => 'email_plan'
    ]);
    /* TOGGLE FINAL STATE */
    Route::get('/plan/{id}/toggle', [
        'uses' => 'PlanController@toggle',
        'as' => 'toggle_plan'
    ]);
    /* VERSION */
    Route::post('/plan/version', [
        'uses' => 'PlanController@version',
        'as' => 'version_plan'
    ]);



    Route::get('/plan/{id}/test_output_filter', [
        'uses' => 'PlanController@test_output_filter',
        'as' => 'test_output_filter'
    ]);


    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function()
    {
        Route::get( '/', 'Admin\DashboardController@index', ['as' => 'admin'])->name('admin.dashboard');

        Route::get('/phpinfo', function () {
            return phpinfo();
        })->name('admin.phpinfo');

        Route::get( '/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index', ['as' => 'admin'] )->name('admin.log_viewer');
        Route::get( '/project/{project_number}/raw_ivmc', 'Admin\ProjectController@raw_ivmc', ['as' => 'admin'])->name('admin.raw_ivmc');
        Route::get( '/project/random_ivmc', 'Admin\ProjectController@random_ivmc', ['as' => 'admin'])->name('admin.random_ivmc');

        /* REST ENTITIES */
        Route::resource( 'user', 'Admin\UserController', ['as' => 'admin'] );
        Route::resource( 'project', 'Admin\ProjectController', ['as' => 'admin']  );
        Route::resource( 'plan', 'Admin\PlanController', ['as' => 'admin']  );
        Route::resource( 'template', 'Admin\TemplateController', ['as' => 'admin']  );
        Route::resource( 'section', 'Admin\SectionController', ['as' => 'admin']  );
        Route::resource( 'question', 'Admin\QuestionController', ['as' => 'admin']  );
    });
});