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


    Route::post('clients/register', [ClientController::class, 'register'])->name('clients.register');
    Route::post('clients/login', [ClientController::class, 'login'])->name('clients.login');
    Route::post('clients/reset-password', [ClientController::class, 'resetPassword'])->name('clients.reset-password');
    Route::post('clients/new-password', [ClientController::class, 'newPassword'])->name('clients.new-password');


    Route::group(['middleware' => 'auth:api-client' ], function () {
        Route::post('clients/register-tokens', [ClientController::class, 'registerTokens'])->name('clients.register-tokens');
        Route::get('clients/remove-tokens', [ClientController::class, 'removeToken'])->name('clients.remove-tokens');

        Route::get('clients/profile', [ClientController::class, 'profile'])->name('clients.profile');
        Route::post('clients/profile/edit/{id}', [ClientController::class, 'editProfile'])->name('clients.edit-profile');

        Route::post('clients/new-order', [ClientController::class, 'newOrder'])->name('clients.new-order');
        Route::get('clients/previous-orders', [ClientController::class, 'previousOrders'])->name('clients.previous-orders');
        Route::get('clients/current-orders', [ClientController::class, 'currentOrders'])->name('clients.current-orders');

        Route::post('clients/add-review', [ClientController::class, 'addReview'])->name('clients.add-review');
    }); // ['middleware' => 'auth:api-client' ]

});
