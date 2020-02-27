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
    return redirect()->route('pictures.list');
})->name('home');

// Picture Routes
Route::prefix('pictures')->group(function () {
    Route::get('/', 'Picture\PictureController@index')->name('pictures.list');
    Route::get('/create', 'Picture\PictureController@create')->name('pictures.create');
    Route::post('/store', 'Picture\PictureController@store')->name('pictures.store');
    Route::post('/store-by-url', 'Picture\PictureController@externalStore')->name('pictures.store-by-url');
    Route::get('/download/{hash}', 'Picture\PictureController@download')->name('pictures.download');
    Route::get('/{hash}', 'Picture\PictureController@view')->name('pictures.view');
});