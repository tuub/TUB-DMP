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

    Route::get('/test', function(){

        $project = \App\Project::find(1);
        $project->load(['metadata.metadata_field' => function ($q) use ( &$metadata_field ) {
            $metadata_field = $q->get()->unique();
        }]);

        //dd($metadata_field); // the collection we needed

        $project = \App\Project::find(1);
        $title_field = \App\MetadataRegistry::where('namespace','project')->where('identifier','title')->first();
        $titel = $project->metadata->where('metadata_field_id', $title_field->id);
        dd($titel);


    });

    Route::get('/test2', function()
    {
        $plan = \App\Plan::find(1);

        $plan->load(['template.questions.answers' => function ($q) use ( &$result ) {
            $result = $q->count();
        }]);

        dd($result);
        //dd($metadata_field); // the collection we needed

        $project = \App\Project::find(1);
        $title_field = \App\MetadataRegistry::where('namespace','project')->where('identifier','title')->first();
        $titel = $project->metadata->where('metadata_field_id', $title_field->id);
        dd($titel);


    });

    Route::get('/test3', function()
    {
        // This works
        if( false ) {
            $project = \App\Project::with('metadata', 'metadata.metadata_registry')->find(1);
            echo get_class($project->metadata);
            dd($project->metadata)->filter();
            dd($project->metadata()->where('metadata_registry_id', 3)->get());
        }

        // This works
        if( false ) {
            $project = \App\Project::find(1);
            $attribute = 'title';
            $language = 'de';

            $metadata_query = $project->metadata()->whereHas('metadata_registry',
                function ($q) use ($attribute, $language) {
                    $q->where('identifier', $attribute);
                    if (!is_null($language)) {
                        $q->where('project_metadata.language', $language);
                    }
                });

            //if( !is_null($language) ) {
            //    $metadata_query = $metadata_query->where('language', $language);
            //}

            $results = $metadata_query->get();

            foreach ($results as $project_metadatum) {
                var_dump($project_metadatum->metadata_registry->title);
            }

            //dd($results);
        }

        // This should work
        $project = \App\Project::with('metadata', 'metadata.metadata_registry')->find(1);

        $project->metadata()->each(function($item){
            print_r($item->metadata_registry->identifier);
            print_r($item->metadata_registry->content_type->identifier);
        });




    });

    Route::get('/test4', function(){
        $plan = new \App\Plan();
        /*
        $id = $plan->insertGetId([
            'project_id' => 1,
            'title' => 'foo',
            'version' => 1,
        ]);
        */

        /*
        $plan = $plan->create([
            'project_id' => 1,
            'title' => 'foo',
            'version' => 1,
        ]);

        dd($plan->id);
        */

        $plan = $plan->create([
            'project_id' => 1,
            'title' => 'foo',
            'version' => 1,
        ]);

        $survey = new \App\Survey;
        $survey->plan()->associate($plan);
        $survey->template_id = 1;
        $survey->save();

    });

    Route::get('/test5', function(){
        $survey = \App\Survey::find(1);
        $question = \App\Question::find(121);
        $answers = \App\Answer::check($survey, $question);

        foreach( $answers as $answer ) {
            $foo = json_decode($answer->value, true);
            var_dump($foo[0]);
        }

    });

    Route::get('/test6', function(){
        $answer = new \App\Answer;
        $answer->survey_id = 1;
        $answer->question_id = 122;
        $answer->value = json_encode(['value' => 'Goo Goo Gjoob!']);
        $answer->save();

        $answer = new \App\Answer;
        $answer->survey_id = 1;
        $answer->question_id = 130;
        $answer->value = json_encode(['value' => ['0' => 'Goo Goo Gjoob!', '1' => 'Across The Universe']]);
        $answer->save();

    });
});