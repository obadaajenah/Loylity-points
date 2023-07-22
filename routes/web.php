<?php

use Illuminate\Support\Facades\Route;
use App\Models\PartnerBundle;
use App\Models\CommandHistory;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('login',function(){
    return response()->json(['message'=>'please login first!'],401);
})->name('login');
