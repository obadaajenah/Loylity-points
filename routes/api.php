<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CustomerController;


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

Route::post('register' , ['App\Http\Controllers\CustomerController','register']);
Route::post('loginByEmail',['App\Http\Controllers\AuthController','loginByEmail']);
Route::post('loginByNumber',['App\Http\Controllers\AuthController','loginByPhoneNumber']);

Route::get('/roles',['App\Http\Controllers\RoleController','index']);
Route::get('/segmentations',['App\Http\Controllers\SegmentationController','index']);
Route::get('/customers',['App\Http\Controllers\CustomerController','index']);

Route::controller(CustomerController::class)->group(function(){
    Route::prefix('customers')->group(function(){
        Route::middleware(['auth:sanctum','checkCustomer'])->group(function(){

            Route::get('profile','show');
            Route::put('update', 'update');

        });
    });
});

Route::controller(PartnerController::class)->group(function(){
    Route::prefix('partners')->group(function(){
        Route::get('/index','index')->name('partners.index');
        Route::get('/indexName','indexName')->name('partners.indexName');
    });
});

Route::controller(BundleController::class)->group(function(){
    Route::prefix('bundles')->group(function(){

        Route::middleware(['auth:sanctum','checkPartner'])->group(function(){
            Route::get('/index','index')->name('bundles.index');
        });

        Route::middleware('auth:sanctum','checkAdmin')->group(function(){
            Route::post('/store','store')->name('bundles.store');
        });
    });
});




Route::group(['prefix'=>'admin'],function(){

Route::post('Add_Bundle',['App\Http\Controllers\BundleController'::class,'store'])->middleware('checkAdmin:admin-api');

Route::delete('Delete_Bundle/{bundle_name}',['App\Http\Controllers\BundleController'::class,'destroy']);
});
