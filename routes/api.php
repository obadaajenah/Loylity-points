<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PartnerController;
use App\Http\Controllers\BundleController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\RequestsPartnerController;
use App\Http\Controllers\BonusTransferController;
use App\Http\Controllers\GemsTransferController;
use App\Http\Controllers\OfferController;

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

Route::controller(AuthController::class)->group(function(){
    //public routes :
    Route::post('loginByEmail','loginByEmail');
    Route::post('loginByNumber','loginByPhoneNumber');
    
    //private routes :
    Route::middleware('auth:sanctum')->group(function(){
        Route::get('/logout','logout');
        Route::get('/logoutAll','logoutAll');
    });
});

Route::middleware('admin')->group(function(){
    Route::get('/roles',['App\Http\Controllers\RoleController','index']);
    Route::get('/segmentations',['App\Http\Controllers\SegmentationController','index']);
});

Route::controller(CustomerController::class)->group(function(){
    Route::prefix('customers')->group(function(){
        Route::post('/register','register')->name('customers.register');
        
        Route::middleware('customer')->group(function(){
            Route::get('/profile','show')->name('customers.profile');
            Route::post('update', 'update')->name('customers.update');
        });
        Route::get('/','index')->middleware('admin')->name('customers.index');
    });
});

Route::controller(PartnerController::class)->group(function(){
    Route::prefix('partners')->group(function(){
        Route::get('/','index')->name('partners.index');
        Route::get('/names','indexName')->name('partners.indexName');

        Route::middleware('partner')->group(function(){
            Route::get('profile','show')->name('partners.profile');
            Route::post('update', 'update')->name('partners.update');
        });
    });
});

Route::controller(BundleController::class)->group(function(){
    Route::prefix('bundles')->group(function(){

        Route::middleware('adminOrPartner')->group(function(){
            Route::get('/','index')->name('bundles.index');
            Route::get('/{id}','show')->name('bundles.show');
        });

        Route::middleware('admin')->group(function(){
            Route::post('/store','store')->name('bundles.store');
        });
    });
});

Route::controller(RequestsPartnerController::class)->group(function(){
    Route::prefix('requestPartners')->group(function(){
        Route::post('/','store')->name('requestPartners.store');

        Route::middleware('admin')->group(function(){
            Route::get('','index')->name('requestPartners.index');
            Route::get('/{id}','show')->name('requestPartners.show');
        });

        Route::middleware('pending')->group(function(){
            Route::post('/{id}','update')->name('requestPartners.update');
            Route::get('/myrequests','myrequests')->name('my.requests');
        });
    });
});

Route::controller(BonusTransferController::class)->group(function(){
    Route::prefix('BonusTransfer')->group(function(){
        Route::middleware('admin')->group(function(){
            Route::get('/all','index');
            Route::get('/{id}','show');
        });
        Route::get('/','store')->middleware('partnerOrCustomer');
    });
});

Route::controller(GemsTransferController::class)->group(function(){
    Route::prefix('GemsTransfer')->group(function(){
        Route::get('/all','index')->middleware('admin');
        Route::get('/{id}','show')->middleware('admin');
        Route::get('/','store')->middleware('partnerOrCustomer');
    });
});

Route::controller(OfferController::class)->group(function(){
    Route::prefix('offers')->group(function(){
        Route::get('/','index')->name('offers.index')->middleware('admin');
        Route::get('/seg/{segmentation_id}','indexBySegmentation')->name('offers.indexBySegmentation')->middleware(['auth:sanctum']);
        Route::get('/{id}','show')->name('offers.show')->middleware('auth:sanctum');
        Route::get('/myoffers','myoffers')->name('myoffers')->middleware('customer');
        Route::post('/','store')->name('offers.store')->middleware('partner');
   });
    Route::get('/myoffers','myoffers')->middleware('customer');
});

//Route::group(['prefix'=>'admin'],function(){
Route::group(['prefix'=>'admin'],function(){

    Route::post('Add_Bundle',['App\Http\Controllers\BundleController'::class,'store'])->middleware('checkAdmin:admin-api');

    Route::delete('Delete_Bundle/{bundle_name}',['App\Http\Controllers\BundleController'::class,'destroy']);
});