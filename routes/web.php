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
    return view('auth.login');
});

Auth::routes(['register' => 'false']);

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware(['auth'])->group(function () {

    Route::prefix('masterdata')->group(function () {
        Route::resource('product','ProductController');
        Route::resource('category', 'CategoryController');
        Route::resource('market', 'MarketController');
    });

    Route::resource('dataset', 'HistoryController');
    Route::get('chart', 'HistoryController@indexChart');

});
