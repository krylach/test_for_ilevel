<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/login', 'Api\Auth\LoginController@__invoke');
Route::post('/logout', 'Api\Auth\LogoutController@__invoke');

Route::group(['prefix' => 'products', 'middleware' => 'auth:api'], function () {
    Route::post('/', 'ProductController@show'); 
    Route::post('/create', 'ProductController@store'); 
    Route::post('/{id}/edit', 'ProductController@update');
    Route::post('/{id}/delete', 'ProductController@destroy'); 
});

Route::group(['prefix' => 'categories', 'middleware' => 'auth:api'], function () {
    Route::post('/', 'CategoryController@show'); 
    Route::post('/{id}/products', 'CategoryController@showProducts');
    Route::post('/create', 'CategoryController@store'); 
    Route::post('/{id}/edit', 'CategoryController@update');
    Route::post('/{id}/delete', 'CategoryController@destroy'); 
});
