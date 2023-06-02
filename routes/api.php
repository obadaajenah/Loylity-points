<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

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

Route::post('loginByEmail',['App\Http\Controllers\AuthController','loginByEmail']);

Route::get('/roles',['App\Http\Controllers\RoleController','index']);
Route::get('/segmentations',['App\Http\Controllers\SegmentationController','index']);
Route::get('/customers',['App\Http\Controllers\CustomerController','index']);

Route::post('/loginByEmail','AuthController@loginByEmail,'loginByEmail']);

**************************
