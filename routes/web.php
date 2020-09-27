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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/privacy', function () {
    return view('project.privacy');
});
Route::get('/anleitung', function () {
    return view('project.instructions');
});


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::group(['prefix' => 'foodapp'], function () {
        Route::get('/', 'FoodAppManager@exportForm');
        Route::get('/logs', 'FoodAppManager@exportForm');
        Route::get('/export', 'FoodAppManager@export');
        Route::get('/studies', 'FoodAdminStudyBreadController@index');
        Route::get('/qrsignup', 'FoodAdminStudyBreadController@qrsignup')->name('admin.foodapp.qrsignup');
        Route::get('/questioncatalog', 'FoodAdminStudyBreadController@questioncatalog')->name('admin.foodapp.questioncatalog');
        Route::post('/questioncatalog', 'FoodAdminStudyBreadController@updatequestioncatalog');
    });
    
    
});
