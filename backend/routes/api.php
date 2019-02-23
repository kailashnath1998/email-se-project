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


Route::post('/login', 'ApiController@login');
Route::post('/register', 'ApiController@register');

Route::get('/', 'ApiController@check');
 
Route::group(['middleware' => 'auth.verify'], function () {

    Route::get('/logout', 'ApiController@logout');
 
    Route::get('/user', 'ApiController@getAuthUser');
 
});

Route::get('/admin', function () {
    //
})->middleware('auth.verify','role:admin');

Route::post('/contact', 'ApiController@conatctAdmin');