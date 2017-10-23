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
    //Route::get('/login', ['uses' => 'UserController@getLogin']);
    //Route::post('/login', ['uses' => 'UserController@postLogin', 'as' => 'login']);

    Route::name('shibboleth-login')->get('/login', '\StudentAffairsUwm\Shibboleth\Controllers\ShibbolethController@login');
    Route::name('shibboleth-authenticate')->get('/shibboleth-authenticate', '\StudentAffairsUwm\Shibboleth\Controllers\ShibbolethController@idpAuthenticate');
});

Route::group(['middleware' => 'auth'], function()
{
    // DASHBOARD
    Route::get('/my/dashboard', [
        'uses' => 'ProjectController@index',
        'as' => 'dashboard'
    ]);

    // LOGOUT
    Route::name('shibboleth-logout')->get('/logout', '\StudentAffairsUwm\Shibboleth\Controllers\ShibbolethController@destroy');

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
    /* DELETE */
    Route::get('/plan/{id}/delete', [
        'uses' => 'PlanController@delete',
        'as' => 'plan.delete'
    ]);
    /* DESTROY */
    Route::delete('/plan/destroy', [
        'uses' => 'PlanController@destroy',
        'as' => 'plan.destroy'
    ]);
    /* TOGGLE FINAL STATE */
    Route::get('/plan/{id}/toggle', [
        'uses' => 'PlanController@toggleState',
        'as' => 'plan.toggle'
    ]);
    /* VERSION */
    Route::post('/plan/snapshot', [
        'uses' => 'PlanController@snapshot',
        'as' => 'plan.snapshot'
    ]);
    /* EMAIL */
    Route::post('/plan/email', [
        'uses' => 'PlanController@email',
        'as' => 'plan.email'
    ]);
    /* EXPORT */
    Route::get('/plan/{id}/export', [
        'uses' => 'PlanController@export',
        'as' => 'plan.export'
    ]);


    /* Project */

    /* REQUEST */
    Route::post('/my/project/request',[
        'uses' => 'ProjectController@request',
        'as' => 'project.request'
    ]);
    /* SHOW */
    Route::get('/my/project/{uuid}/show',[
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
    Route::get('/my/project/{id}/import', [
        'uses' => 'ProjectController@import',
        'as' => 'project.import'
    ]);


    Route::group(['middleware' => 'admin', 'prefix' => 'admin'], function()
    {
        Route::get( '/', 'Admin\DashboardController@index', ['as' => 'admin'])->name('admin.dashboard');

        Route::get('/phpinfo', function () {
            phpinfo();
        })->name('admin.phpinfo');

        Route::get( '/project/lookup', 'Admin\ProjectController@getLookup', ['as' => 'admin'])->name('admin.project.get_lookup');
        Route::post( '/project/lookup', 'Admin\ProjectController@postLookup', ['as' => 'admin'])->name('admin.project.post_lookup');

        Route::get( '/logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index', ['as' => 'admin'] )->name('admin.log_viewer');
        Route::get( '/project/{project_number}/raw_ivmc', 'Admin\ProjectController@raw_ivmc', ['as' => 'admin'])->name('admin.raw_ivmc');
        Route::get( '/project/random_ivmc', 'Admin\ProjectController@random_ivmc', ['as' => 'admin'])->name('admin.random_ivmc');

        /* REST ENTITIES */
        Route::resource( 'template', 'Admin\TemplateController', ['as' => 'admin']  );
        Route::resource( 'template.sections', 'Admin\SectionController', ['as' => 'admin']  );
        Route::resource( 'user', 'Admin\UserController', ['as' => 'admin'] );
        Route::resource( 'user.projects', 'Admin\ProjectController', ['as' => 'admin']  );
        Route::resource( 'project', 'Admin\ProjectController', ['as' => 'admin']  );
        Route::resource( 'project.plans', 'Admin\PlanController', ['as' => 'admin']  );
        Route::resource( 'section', 'Admin\SectionController', ['as' => 'admin']  );
        Route::resource( 'section.questions', 'Admin\QuestionController', ['as' => 'admin']  );
        Route::resource( 'plan.survey', 'Admin\SurveyController', ['as' => 'admin']  );

        Route::resource( 'project_metadata', 'Admin\ProjectMetadataController', ['as' => 'admin']  );
        Route::resource( 'plan', 'Admin\PlanController', ['as' => 'admin']  );
        Route::resource( 'question', 'Admin\QuestionController', ['as' => 'admin']  );
        Route::resource( 'data_source', 'Admin\DataSourceController', ['as' => 'admin'] );

        Route::post('/section/sort', array ('as' => 'admin.section.sort', 'uses' => 'Admin\SectionController@sort'));
        Route::post('/question/sort', array ('as' => 'admin.question.sort', 'uses' => 'Admin\QuestionController@sort'));

    });
});