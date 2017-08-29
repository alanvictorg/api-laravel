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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Route::group(array('prefix' => 'api'), function()
//{
//
//    Route::get('/', function () {
//        return "Welcome API";
//    });
//
//});
Route::get('/', function () {
    return "Welcome API";
});

$sharedRoutes = function () {

};
Route::group(['middleware' => 'cors'], function () use ($sharedRoutes) {
    Route::post('/auth/student-login', 'Auth\LoginController@login');

    Route::group([
        'middleware' => ['jwt.student', 'jwt.refresh'],
    ], function () use ($sharedRoutes) {

        $sharedRoutes();

    });

});