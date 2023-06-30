<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\BundleController;

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
Route::post('loginByNumber',['App\Http\Controllers\AuthController','loginByPhoneNumber']);

Route::get('/roles',['App\Http\Controllers\RoleController','index']);
Route::get('/segmentations',['App\Http\Controllers\SegmentationController','index']);
Route::get('/customers',['App\Http\Controllers\CustomerController','index']);

Route::controller(PartnerController::class)->group(function(){
    Route::prefix("partners")->group(function(){
        Route::get('/index','index')->name('partners.index');
        Route::get('/indexName','indexName')->name('partners.indexName');
    });
});

Route::controller(BundleController::class)->group(function(){
    Route::prefix("bundles")->group(function(){
        Route::middleware(['checkPartner','checkAdmin'])->group(function(){
            Route::get('/index','index')->name('bundles.index');
        });
        Route::middleware("checkAdmin")->group(function(){
            Route::post('/store','store')->name('bundles.store');
        });
    });
});
