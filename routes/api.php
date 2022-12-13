<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\ClientController;
use App\Http\Controllers\Api\AuthRestaurantController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'v1' , 'namespace' => 'Api'] , function(){

    Route::get('categories', [MainController::class, 'categories'])->name('categories');
    Route::get('cities', [MainController::class, 'cities'])->name('cities');
    Route::get('districts', [MainController::class, 'districts'])->name('districts');
    Route::get('items/{id}', [MainController::class, 'items'])->name('items');
    Route::get('offers', [MainController::class, 'offers'])->name('offers');



    Route::get('clients', [MainController::class, 'clients'])->name('clients');
    Route::post('contacts', [MainController::class, 'contacts'])->name('contacts.api');
    Route::get('notifications', [MainController::class, 'notifications'])->name('notifications');
    // Route::post('offers', [MainController::class, 'offers'])->name('offers');

######### error here postman ###########
    Route::get('payments', [MainController::class, 'payments'])->name('payments');
    Route::get('payment-method', [MainController::class, 'paymentMethod'])->name('payment-method');
    Route::get('restaurants', [MainController::class, 'restaurants'])->name('restaurants');
##########################################

    Route::get('reviews', [MainController::class, 'Reviews'])->name('reviews');
    Route::get('settings', [MainController::class, 'settings'])->name('settings');



    // });






});
