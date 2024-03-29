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

    Route::post('/send', 'ApiController@send');

    Route::get('/recive', 'ApiController@recive');

    Route::get('/message', 'ApiController@message');

    Route::get('/alldraft', 'ApiController@getAllDraft');

    Route::post('/changetype', 'ApiController@changeType');

    Route::post('/draft', 'ApiController@draft');

    Route::post('/draftupdate', 'ApiController@draftUpdate');

    Route::post('/changepassword', 'ApiController@changePassword');

    Route::get('/resetpassword', 'ApiController@resetPassword');

    Route::post('/senddraft', 'ApiController@sendDraft');

    Route::get('/sent', 'ApiController@sent');

    Route::post('/report', 'ApiController@reportMail');


});

Route::get('/admin/reports','ApiController@reports')->middleware('auth.verify','role:admin');
Route::post('/admin/resolve','ApiController@resolve')->middleware('auth.verify','role:admin');

Route::post('/contact', 'ApiController@conatctAdmin');


/*
Argument 1 passed to Illuminate\Routing\Middleware\ThrottleRequests::addHeaders() must be an instance of Symfony\Component\HttpFoundation\Response, null given, called in D:\LaravelTest\email\backend\vendor\laravel\framework\src\Illuminate\Routing\Middleware\ThrottleRequests.php on line 62


*/