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


Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::group(['prefix' => 'foodapp'], function () {
        Route::get('/', 'FoodAppManager@exportForm');
        Route::get('/export', 'FoodAppManager@export');
        Route::get('/studies', 'FoodAdminStudyBreadController@index');
        Route::get('/qrsignup', 'FoodAdminStudyBreadController@qrsignup')->name('admin.foodapp.qrsignup');
    });
    
    
});
