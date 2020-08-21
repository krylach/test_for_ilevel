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

Route::get('/', 'HandlerController@show');

Route::group(['prefix' => 'products'], function () {
    Route::get('/', 'ProductController@show'); 
    Route::get('/create', 'ProductController@store'); 
    Route::get('/{id}/edit', 'ProductController@update');
    Route::get('/{id}/delete', 'ProductController@destroy'); 
});

Route::group(['prefix' => 'categories'], function () {
    Route::get('/', 'CategoryController@show'); 
    Route::get('/{id}/products', 'CategoryController@showProducts');
    Route::get('/create', 'CategoryController@store'); 
    Route::get('/{id}/edit', 'CategoryController@update');
    Route::get('/{id}/delete', 'CategoryController@destroy'); 
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
