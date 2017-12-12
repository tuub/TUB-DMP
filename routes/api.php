<?php
use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/sections', function (Request $request) {
    return \App\Section::where('template_id', $request->template)->orderBy('order')->get(['name', 'id'])->toJson();
});

Route::get('/questions', function (Request $request) {
    return \App\Question::where('section_id', $request->section)->orderBy('order')->get(['text', 'id'])->toJson();
});

Route::get('/question/possible_parents', function (Request $request) {
    $my_parents = collect([]);
    $section = $request->section;

    $all_parents = \App\Question::where('section_id', $section)->orderBy('order')->get(['text', 'id']);

    if ($request->question) {
        $question = \App\Question::find($request->question);
        $no_parents = $question->descendantsAndSelf()->get(['text', 'id']);
        $my_parents = $all_parents->diff($no_parents);
    } else {
        $my_parents = $all_parents;
    }

    return $my_parents->toJson();
});
//->middleware('auth:api');