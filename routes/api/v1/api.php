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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

//Users
Route::prefix('/user')->group( function() {
    Route::post('/login', 'api\v1\LoginController@login');
    Route::post('/register', 'api\v1\RegisterController@register');
    Route::middleware('auth:api')->get('/all', 'api\v1\user\UserController@index');
    Route::middleware('auth:api')->get('/current', 'api\v1\user\UserController@currentUser');
    Route::middleware('auth:api')->get('/permission/{id}', 'api\v1\user\UserController@permission');
    Route::middleware('auth:api')->post('/store', 'api\v1\user\UserController@store');
    Route::middleware('auth:api')->put('/update/{id}', 'api\v1\user\UserController@update');
    Route::middleware('auth:api')->delete('/destroy/{id}', 'api\v1\user\UserController@destroy');
});

Route::prefix('/product')->group( function() {
    Route::middleware('auth:api')->get('/all', 'api\v1\product\ProductController@index');
    Route::middleware('auth:api')->post('/store', 'api\v1\product\ProductController@store');
    Route::middleware('auth:api')->put('/update/{id}', 'api\v1\product\ProductController@update');
});

Route::prefix('/role')->group( function() {
    Route::middleware('auth:api')->get('/all', 'api\v1\role\RoleController@index');
    Route::middleware('auth:api')->get('/permission/{id}', 'api\v1\role\RoleController@permission');
    Route::middleware('auth:api')->post('/store', 'api\v1\role\RoleController@store');
    Route::middleware('auth:api')->put('/update/{id}', 'api\v1\role\RoleController@update');
    Route::middleware('auth:api')->delete('/destroy/{id}', 'api\v1\role\RoleController@destroy');
});

Route::prefix('/permission')->group( function() {
    Route::middleware('auth:api')->get('/all', 'api\v1\permission\PermissionController@index');
    Route::middleware('auth:api')->post('/store', 'api\v1\permission\PermissionController@store');
    Route::middleware('auth:api')->put('/update/{id}', 'api\v1\permission\PermissionController@update');
    Route::middleware('auth:api')->delete('/destroy/{id}', 'api\v1\permission\PermissionController@destroy');
});