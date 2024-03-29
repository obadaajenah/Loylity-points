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
use App\Http\Controllers\DefaultValueController;
use App\Http\Controllers\Bonus2GemsController;
use App\Http\Controllers\Gems2CashController;
use App\Http\Controllers\PartnerBundleController;

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
        Route::get('/myRole','myRole');
    });
});

Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
    Route::get('/roles',['App\Http\Controllers\RoleController','index']);
    Route::get('/segmentations',['App\Http\Controllers\SegmentationController','index']);
    Route::post('/segmentations/{id}',['App\Http\Controllers\SegmentationController','update']);
});

Route::controller(CustomerController::class)->group(function(){
    Route::prefix('customers')->group(function(){
        Route::post('/register','register')->name('customers.register');

        Route::middleware(['auth:sanctum','checkCustomer'])->group(function(){
            Route::get('/profile','show')->name('customers.profile');
            Route::post('update', 'update')->name('customers.update');
        });
        Route::get('/','index')->middleware(['auth:sanctum','checkAdmin'])->name('customers.index');
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

        Route::get('/admin','indexAdmin')->middleware(['auth:sanctum','checkAdmin']);
    });
});

Route::controller(BundleController::class)->group(function(){
    Route::prefix('bundles')->group(function(){

        Route::get('/','index')->name('bundles.index');
        Route::get('/{id}','show')->name('bundles.show');
        
        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::post('/store','store')->name('bundles.store');
        });
    });
});

Route::controller(PartnerBundleController::class)->group(function(){
    Route::middleware(['auth:sanctum','checkPartner'])->group(function(){
        Route::post('buyBundle','buyBundle');
    });
});

Route::controller(RequestsPartnerController::class)->group(function(){
    Route::prefix('requestPartners')->group(function(){
        Route::post('/','store')->name('requestPartners.store');


        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::get('','index')->name('requestPartners.index');
            Route::get('/pending','pendingRequests')->name('requestPartners.pending');
            Route::get('/{id}','show')->name('requestPartners.show');
        });

        Route::middleware(['auth:sanctum','checkPending'])->group(function(){
            Route::post('/{id}','update')->name('requestPartners.update');
            Route::delete('/{id}','destroy')->name('requestPartners.destroy');
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
        Route::get('sellOffer/{id}','sellOffer')->name('offer.buy')->middleware(['auth:sanctum','checkCustomer']);
        Route::get('/{id}','show')->name('offers.show')->middleware(['auth:sanctum','adminOrPartner']);
        Route::post('/','store')->name('offers.store')->middleware(['auth:sanctum','checkPartner']);
        Route::post('/{id}','update')->name('offers.update')->middleware(['auth:sanctum','checkPartner']);
        Route::delete('/{id}','destroy')->name('offers.delete')->middleware(['auth:sanctum','checkPartner']);
    });
    Route::get('/myoffers','myoffers')->middleware(['auth:sanctum','checkCustomer']);
});

Route::controller(DefaultValueController::class)->group(function(){
    Route::prefix('default')->group(function(){
        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::get('/','index')->name('defaultValus.index');
            Route::post('/{id}','update')->name('defaultValus.update');
        });
    });
});

Route::controller(Bonus2GemsController::class)->group(function(){
    Route::prefix('B2G')->group(function(){

        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::get('/','index')->name('B2G.index');
        });

        Route::middleware(['auth:sanctum','checkCustomer'])->group(function(){
            Route::post('/','store')->name('B2G.store');
            Route::get('/mine','mine')->name('B2G.mine');

        });
    });
});

Route::controller(Gems2CashController::class)->group(function(){
    Route::prefix('G2C')->group(function(){

        Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){
            Route::get('/','index')->name('G2C.index');
        });

        Route::middleware(['auth:sanctum','checkCustomer'])->group(function(){
            Route::post('/','store')->name('G2C.store');
            Route::get('/mine','mine')->name('G2C.mine');
        });
    });
});

Route::group(['prefix'=>'admin'],function(){

    Route::middleware(['auth:sanctum','checkAdmin'])->group(function(){

        Route::post('Add_Bundle',['App\Http\Controllers\BundleController'::class,'store']);
    
        Route::delete('Delete_Bundle/{id}',['App\Http\Controllers\BundleController'::class,'destroy']);
    
        Route::post('update_Bundle/{id}',['App\Http\Controllers\BundleController'::class,'update']);
    
        Route::get('Show_Bundles',['App\Http\Controllers\BundleController'::class,'index']);
    
        Route::post('Modify_Request/{id}',['App\Http\Controllers\Admin\AdminController'::class,'modfiy']);
    
        Route::post('Edit_password',['App\Http\Controllers\Admin\AdminController'::class,'changePassword']);
    
        Route::post('sort_partner/{sort_by}',['App\Http\Controllers\Admin\AdminController'::class,'sort_partner']);
    
        Route::post('search_user/{fname}',['App\Http\Controllers\Admin\AdminController'::class,'search_user']);

        Route::get('commands',['App\Http\Controllers\Admin\AdminController'::class,'commands']);

    });    

});
