<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\ItemController;
use App\Http\Controllers\Api\MainController;
use App\Http\Controllers\Api\OfferController;
use App\Http\Controllers\Api\RestaurantController;

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


Route::group(['prefix' => 'v1' , 'namespace' => 'Api'] , function(){



    ########## start restaurants ##########

    Route::post('restaurants/register', [RestaurantController::class, 'register'])->name('restaurants.register');
    Route::post('restaurants/login', [RestaurantController::class, 'login'])->name('restaurants.login');
    Route::post('restaurants/reset-password', [RestaurantController::class, 'resetPassword'])->name('restaurants.reset-password');
    Route::post('restaurants/new-password', [RestaurantController::class, 'newPassword'])->name('restaurants.new-password');


    Route::group(['middleware' => 'auth:api-restaurant' ], function () {

        Route::post('restaurants/register-tokens', [RestaurantController::class, 'registerTokens'])->name('restaurants.register-tokens');
        Route::post('restaurants/remove-token', [RestaurantController::class, 'removeToken'])->name('restaurants.new-password');

        Route::get('restaurants/profile', [RestaurantController::class, 'profile'])->name('restaurants.profile');
        Route::post('restaurants/profile-edit', [RestaurantController::class, 'editProfile'])->name('restaurants.profile-edit');

        Route::get('restaurants/my-orders', [RestaurantController::class, 'myOrders'])->name('restaurants.my-orders');
        Route::get('restaurants/previous-orders', [RestaurantController::class, 'previousOrders'])->name('restaurants.previous-orders');
        Route::get('restaurants/my-new-orders', [RestaurantController::class, 'myNewOrders'])->name('restaurants.my-New-Orders');
        Route::get('restaurants/current-Orders', [RestaurantController::class, 'currentOrders'])->name('restaurants.current-orders');

        Route::post('restaurants/accept-order/{id}', [RestaurantController::class, 'acceptOrder'])->name('restaurants.accept-order');
        Route::post('restaurants/reject-order/{id}', [RestaurantController::class, 'rejectOrder'])->name('restaurants.reject-order');
        Route::post('restaurants/delivered-order/{id}', [RestaurantController::class, 'deliveredOrder'])->name('restaurants.delivered-order');

        // route commission service
        Route::get('restaurants/commissions', [RestaurantController::class, 'commissions'])->name('restaurants.commissions');

        Route::get('restaurants/items', [ItemController::class, 'items'])->name('restaurants.items');
        Route::post('restaurants/items/add', [ItemController::class, 'addItem'])->name('restaurants.items-add');
        Route::put('restaurants/items/edit/{id}', [ItemController::class, 'editItem'])->name('restaurants.items-edit');

        Route::post('restaurants/offers/add', [OfferController::class, 'addOffer'])->name('restaurants.offers-add');
        Route::put('restaurants/offers/edit/{id}', [OfferController::class, 'editOffer'])->name('restaurants.offers-edit');

    });



});
