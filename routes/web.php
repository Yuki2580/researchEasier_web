<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('main');
})->name('root');

Route::get('/hello/', 'App\Http\Controllers\HelloController@index');

Route::post('/logout', 'referenceController@index');
//Route::post('/mainEnglish/', function(){

  //   App::setLocale("en");

  //   return redirect('/mainEnglish');
//});

Route::get('lang/{lang}', function($lang)
{
    Session::put('my.locale', $lang);
    App::setLocale(Session::get('my.locale', Config::get('app.locale')));

    if($lang=="ja"){
      return Redirect::to('main');
    }
    else {
      return Redirect::to('mainEnglish');
    }
})->where(['lang'=>'ja|en']);



Route::post('/tryPython/try', 'App\Http\Controllers\tryPythonController@try')->name('tryPython');

Route::post('/tryPython/putData', 'App\Http\Controllers\tryPythonController@putData')->name('pythonForPut');


Route::get('/main/', 'App\Http\Controllers\MainController@index')->name('main');

Route::get('/main/lang', 'App\Http\Controllers\MainController@lang');


Route::get('/profile/', 'App\Http\Controllers\ProfileController@index')->name('profile');

Route::get('/profile/lang', 'App\Http\Controllers\ProfileController@lang');


Route::get('/createAccount/', 'App\Http\Controllers\createAccountController@index')->name('createAccount');

Route::get('/loginPage/', 'App\Http\Controllers\loginPageController@index')->name('loginPage');




//Route::get('/projectEnglish', 'App\Http\Controllers\projectEnglishController@index')->name('projectEnglish');
//Route::get('/projectEnglish/move', 'App\Http\Controllers\projectEnglishController@move')->name('projectEnglishMove');




Route::get('/explanation', 'App\Http\Controllers\explanationController@index')->name('explanation');

Route::get('/project', 'App\Http\Controllers\ProjectController@index')->name('project');

Route::get('/project/move', 'App\Http\Controllers\ProjectController@move')->name('projectMove');

Route::post('/project/select', 'App\Http\Controllers\ProjectController@select')->name('projectSelect');

Route::get('/projectCreate', 'App\Http\Controllers\projectCreateController@index')->name('projectCreate');

Route::post('/projectCreate/access', 'App\Http\Controllers\projectCreateController@access')->name('projectCreate.access');


Route::get('/projectCreate/lang', 'App\Http\Controllers\projectCreateController@lang');

Route::post('/projectCreate/add', 'App\Http\Controllers\projectCreateController@add')->name('projectCreate.add');

Route::post('/projectCreate/delete', 'App\Http\Controllers\projectCreateController@delete')->name('projectCreate.delete');

Route::post('/projectCreate/project_change', 'App\Http\Controllers\projectCreateController@project_change')->name('projectCreate.project.chenge');


Route::get('/makeFirstProject/index', 'App\Http\Controllers\makeFirstProjectController@index')->name('makeFirstProject');

Route::post('/makeFirstProject/add', 'App\Http\Controllers\makeFirstProjectController@add')->name('makeFirstProject.add');



Route::get('/failLogin/index', 'App\Http\Controllers\failLoginController@index');


Route::get('/introduction/index', 'App\Http\Controllers\introductionController@index') ->middleware('verified');

Route::get('/introduction/lang', 'App\Http\Controllers\introductionController@lang');

Route::get('/loginSelect/index', 'App\Http\Controllers\loginSelectController@index');

Route::post('/loginSelect/move', 'App\Http\Controllers\loginSelectController@move')->name('loginSelect.move');

Route::get('/reference/index', 'App\Http\Controllers\referenceController@index')->name('reference');

Route::get('/reference/lang', 'App\Http\Controllers\referenceController@lang');

Route::post('/reference/add', 'App\Http\Controllers\referenceController@add')->name('reference.add');


Route::post('/reference/download', 'App\Http\Controllers\referenceController@download')->name('reference.download');

Route::post('/reference/project_change', 'App\Http\Controllers\referenceController@project_change')->name('reference.project.chenge');

Route::get('/makeResearch/first', 'App\Http\Controllers\makeResearchController@first')->name('makeResearch_first');

Route::get('/makeResearch/index', 'App\Http\Controllers\makeResearchController@index')->name('makeResearch');


Route::get('/makeResearch/lang', 'App\Http\Controllers\makeResearchController@lang');

//Route::post('/makeResearch/index', 'App\Http\Controllers\makeResearchController@index')->name('makeResearch');

Route::post('/makeResearch/add', 'App\Http\Controllers\makeResearchController@add')->name('makeResearch.add');

Route::post('/makeResearch/project_change', 'App\Http\Controllers\makeResearchController@project_change')->name('makeResearch.project.chenge');

Route::get('/makeResearchManual/index', 'App\Http\Controllers\makeResearchManualController@index')->name('makeResearchManual');

Route::get('/makeMemo/lang', 'App\Http\Controllers\makeMemoController@lang');

Route::get('/makeMemo/index', 'App\Http\Controllers\makeMemoController@index')->name('makeMemo');

Route::post('/makeMemo/add', 'App\Http\Controllers\makeMemoController@add')->name('makeMemo.add');

Route::post('/makeMemo/show', 'App\Http\Controllers\makeMemoController@show')->name('makeMemo.show');

Route::post('/makeMemo/download', 'App\Http\Controllers\makeMemoController@download')->name('makeMemo.download');

Route::post('/makeMemo/project_change', 'App\Http\Controllers\makeMemoController@project_change')->name('makeMemo.project.chenge');

Route::get('/showProject/lang', 'App\Http\Controllers\showProjectController@lang');

Route::post('/showProject/pdf_change', 'App\Http\Controllers\showProjectController@pdf_change')->name('pdf_change');

Route::get('/showProject/index', 'App\Http\Controllers\showProjectController@index')->name('showProject');

Route::post('/showProject/download', 'App\Http\Controllers\showProjectController@download')->name('showProject.download');

Route::post('/showProject/delete', 'App\Http\Controllers\showProjectController@delete')->name('showProject.delete');

Route::post('/showProject/project_change', 'App\Http\Controllers\showProjectController@project_change')->name('showProject.project.chenge');

//Route::get('/researchForm/index', 'App\Http\Controllers\researchFormController@index')->name('researchForm');
//Auth::routes();
Auth::routes(['verify' => true]);


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
