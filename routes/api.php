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

Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
    Route::get('/roles',['App\Http\Controllers\RoleController','index']);
    Route::get('/segmentations',['App\Http\Controllers\SegmentationController','index']);
});

Route::controller(CustomerController::class)->group(function(){
    Route::prefix('customers')->group(function(){
        Route::post('/register','register')->name('customers.register');
        
        Route::middleware(['auth:sanctum','checkCustomer'])->group(function(){
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

        Route::middleware(['auth:sanctum','checkPartner'])->group(function(){
            Route::get('profile','show')->name('partners.profile');
            Route::post('update', 'update')->name('partners.update');
        });
    });
});

Route::controller(BundleController::class)->group(function(){
    Route::prefix('bundles')->group(function(){

        Route::middleware(['auth:sanctum','adminOrPartner'])->group(function(){
            Route::get('/','index')->name('bundles.index');
            Route::get('/{id}','show')->name('bundles.show');
        });

        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::post('/store','store')->name('bundles.store');
        });
    });
});

Route::controller(RequestsPartnerController::class)->group(function(){
    Route::prefix('requestPartners')->group(function(){
        Route::post('/','store')->name('requestPartners.store');
        
        
        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::get('','index')->name('requestPartners.index');
            Route::get('/{id}','show')->name('requestPartners.show');
        });
        
        Route::middleware(['auth:sanctum','checkPending'])->group(function(){
            Route::post('/{id}','update')->name('requestPartners.update');
        });
    });
    Route::get('/myrequests','myrequests')->name('my.requests')->middleware(['auth:sanctum','checkPending']);
});

Route::controller(BonusTransferController::class)->group(function(){
    Route::prefix('BonusTransfer')->group(function(){
        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::get('/all','index');
            Route::get('/{id}','show');
        });
        Route::get('/','store')->middleware(['auth:sanctum','partnerOrCustomer']);
    });
    Route::get('/mybtransfers','myTransfer')->middleware(['auth:sanctum','partnerOrCustomer']);
});

Route::controller(GemsTransferController::class)->group(function(){
    Route::prefix('GemsTransfer')->group(function(){
        Route::get('/all','index')->middleware(['auth:sanctum','checkAdmin']);
        Route::get('/{id}','show')->middleware(['auth:sanctum','checkAdmin']);
        Route::get('/','store')->middleware(['auth:sanctum','partnerOrCustomer']);
    });
    Route::get('/mygtransfers','myTransfer')->middleware(['auth:sanctum','partnerOrCustomer']);
});

Route::controller(OfferController::class)->group(function(){
    Route::prefix('offers')->group(function(){
        Route::get('/','index')->name('offers.index')->middleware('auth:sanctum','checkAdmin');
        Route::get('/seg/{segmentation_id}','indexBySegmentation')->name('offers.indexBySegmentation')->middleware(['auth:sanctum','checkAdmin']);
        Route::get('/{id}','show')->name('offers.show')->middleware(['auth:sanctum','adminOrPartner']);
        Route::post('/','store')->name('offers.store')->middleware(['auth:sanctum','checkPartner']);
   });
    Route::get('/myoffers','myoffers')->middleware(['auth:sanctum','checkCustomer']);
});

//Route::group(['prefix'=>'admin'],function(){
Route::group(['prefix'=>'admin'],function(){

    Route::post('Add_Bundle',['App\Http\Controllers\BundleController'::class,'store']);//->middleware(['auth:sanctum','checkAdmin']);
    // Route::post('Add_Bundle',function(){
    //     return response()->json(['message'=>'Welcome to Add Bundle !']);
    // });//['App\Http\Controllers\BundleController'::class,'store'])->middleware(['auth:sanctum','checkAdmin']);

    Route::delete('Delete_Bundle/{bundle_name}',['App\Http\Controllers\BundleController'::class,'destroy']);
});
