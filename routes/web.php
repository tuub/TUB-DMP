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
        'uses' => 'ProjectController@index',
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
    Route::post('/my/profile', [
        'uses' => 'UserController@postProfile',
        'as' => 'update_profile'
    ]);

    // FEEDBACK
    Route::post('/my/feedback', [
        'uses' => 'DashboardController@feedback',
        'as' => 'feedback'
    ]);


    /* SURVEY*/

    /* SHOW */
    Route::get('/survey/{id}/show',[
        'uses' => 'SurveyController@show',
        'as' => 'survey.show'
    ]);
    /* STORE */
    Route::put('/survey/store', [
        'uses' => 'SurveyController@store',
        'as' => 'survey.store'
    ]);
    /* EDIT */
    Route::get('/survey/{id}/edit', [
        'uses' => 'SurveyController@edit',
        'as' => 'survey.edit'
    ]);
    /* UPDATE */
    Route::put('/survey/{id}/update', [
        'uses' => 'SurveyController@update',
        'as' => 'survey.update'
    ]);



    /* PLAN */

    /* SHOW */
    Route::get('/plan/{id}/show',[
        'uses' => 'PlanController@show',
        'as' => 'plan.show'
    ]);
    /* STORE */
    Route::put('/plan/store', [
        'uses' => 'PlanController@store',
        'as' => 'plan.store'
    ]);
    /* EDIT */
    Route::get('/plan/{id}/edit', [
        'uses' => 'PlanController@edit',
        'as' => 'plan.edit'
    ]);
    /* UPDATE */
    Route::put('/plan/update', [
        'uses' => 'PlanController@update',
        'as' => 'plan.update'
    ]);
    /* TOGGLE FINAL STATE */
    Route::get('/plan/{id}/toggle', [
        'uses' => 'PlanController@toggleState',
        'as' => 'plan.toggle'
    ]);
    /* VERSION */
    Route::post('/plan/version', [
        'uses' => 'PlanController@version',
        'as' => 'plan.version'
    ]);
    /* EMAIL */
    Route::post('/plan/email', [
        'uses' => 'PlanController@email',
        'as' => 'plan.email'
    ]);


    /* EXPORT */
    Route::get('/plan/{id}/export/{format?}', [
        'uses' => 'PlanController@export',
        'as' => 'export_plan'
    ]);


    /* Project */

    /* SHOW */
    Route::get('/my/project/{id}/show',[
        'uses' => 'ProjectController@show',
        'as' => 'project.show'
    ]);
    /* STORE */
    Route::put('/my/project/store', [
        'uses' => 'ProjectController@store',
        'as' => 'project.store'
    ]);
    /* EDIT */
    Route::get('/my/project/{id}/edit', [
        'uses' => 'ProjectController@edit',
        'as' => 'project.edit'
    ]);
    Route::put('/my/project/update', [
        'uses' => 'ProjectController@update',
        'as' => 'project.update'
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
        Route::resource( 'project_metadata', 'Admin\ProjectMetadataController', ['as' => 'admin']  );
        Route::resource( 'plan', 'Admin\PlanController', ['as' => 'admin']  );
        Route::resource( 'template', 'Admin\TemplateController', ['as' => 'admin']  );
        Route::resource( 'section', 'Admin\SectionController', ['as' => 'admin']  );
        Route::resource( 'question', 'Admin\QuestionController', ['as' => 'admin']  );
    });
});