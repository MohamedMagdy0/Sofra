<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OfferController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\PayemntMethodController;

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

Route::get('home', [HomeController::class, 'index'])->name('home');


//prefix('admin')->

Route::middleware(['auto-check-permission' ,'auth:web'])->group(function ()
{


// Cities
Route::resource('cities', CityController::class)->except('show');
Route::delete('city/softDelete/{id}', [CityController::class, 'softDelete'])->name('city.softDelete'); // city.softDelete
Route::get('city/trash', [CityController::class, 'cityTrash'])->name('city.trash'); // city.trash
Route::get('city/restore/{id}', [CityController::class, 'cityRestore'])->name('city.restore'); // city.restore

// Districts
Route::resource('districts', DistrictController::class)->except('show');
Route::delete('district/softDelete/{id}', [DistrictController::class, 'softDelete'])->name('district.softDelete'); // district.softDelete
Route::get('district/trash', [DistrictController::class, 'trash'])->name('district.trash'); // district.trash
Route::get('district/restore/{id}', [DistrictController::class, 'restore'])->name('district.restore'); // district.restore

// categories
Route::resource('categories', CategoryController::class)->except('show');
Route::delete('category/softDelete/{id}', [CategoryController::class, 'softDelete'])->name('category.softDelete'); // category.softDelete
Route::get('category/trash', [CategoryController::class, 'trash'])->name('category.trash'); // category.trash
Route::get('category/restore/{id}', [CategoryController::class, 'restore'])->name('category.restore'); // category.restore

// Offers
Route::resource('offers', OfferController::class) ;//->only('index','destroy');
Route::delete('offer/softDelete/{id}', [OfferController::class, 'softDelete'])->name('offer.softDelete'); // offer.softDelete
Route::get('offer/trash', [OfferController::class, 'trash'])->name('offer.trash'); // offer.trash
Route::get('offer/restore/{id}', [OfferController::class, 'restore'])->name('offer.restore'); // offer.restore

// contacts
Route::resource('contacts', ContactController::class)->only('index','destroy');
Route::delete('contact/softDelete/{id}', [ContactController::class, 'softDelete'])->name('contact.softDelete'); // contact.softDelete
Route::get('contact/trash', [ContactController::class, 'trash'])->name('contact.trash'); // contact.trash
Route::get('contact/restore/{id}', [ContactController::class, 'restore'])->name('contact.restore'); // contact.restore

// payments
Route::resource('payments', PaymentController::class)->except('store','show');
Route::delete('payment/softDelete/{id}', [PaymentController::class, 'softDelete'])->name('payment.softDelete'); // payment.softDelete
Route::get('payment/trash', [PaymentController::class, 'trash'])->name('payment.trash'); // payment.trash
Route::get('payment/restore/{id}', [PaymentController::class, 'restore'])->name('payment.restore'); // payment.restore

// settings
Route::get('setting/edit', [SettingController::class, 'edit'])->name('setting.edit'); // setting.edit
Route::put('setting/update', [SettingController::class, 'update'])->name('setting.update'); // setting.update


// restaurants
Route::resource('restaurants', RestaurantController::class)->except('store','edit','update');
Route::delete('restaurant/softDelete/{id}', [RestaurantController::class, 'softDelete'])->name('restaurant.softDelete'); // restaurant.softDelete
Route::get('restaurant/trash', [RestaurantController::class, 'trash'])->name('restaurant.trash'); // restaurant.trash
Route::get('restaurant/restore/{id}', [RestaurantController::class, 'restore'])->name('restaurant.restore'); // restaurant.restore
Route::post('restaurants/status/{id}', [RestaurantController::class, 'status'])->name('restaurants.status'); // restaurants.status


// payment-methods
Route::resource('payemnt-methods', PayemntMethodController::class);
Route::delete('payemnt-method/softDelete/{id}', [PayemntMethodController::class, 'softDelete'])->name('payemnt-method.softDelete'); // payemnt-method.softDelete
Route::get('payemnt-method/trash', [PayemntMethodController::class, 'trash'])->name('payemnt-method.trash'); // payemnt-method.trash
Route::get('payemnt-method/restore/{id}', [PayemntMethodController::class, 'restore'])->name('payemnt-method.restore'); // payemnt-method.restore



// clients
Route::resource('clients', ClientController::class)->except('store', 'edit', 'update');
Route::delete('client/softDelete/{id}', [ClientController::class, 'softDelete'])->name('client.softDelete'); // client.softDelete
Route::get('client/trash', [ClientController::class, 'trash'])->name('client.trash'); // client.trash
Route::get('client/restore/{id}', [ClientController::class, 'restore'])->name('client.restore'); // client.restore
Route::post('client/is-Active/{id}', [ClientController::class, 'isActive'])->name('client.is-Active'); // client.is-Active


// orders
Route::resource('orders', OrderController::class)->except('store', 'edit', 'update');
Route::delete('order/softDelete/{id}', [OrderController::class, 'softDelete'])->name('order.softDelete'); // order.softDelete
Route::get('order/trash', [OrderController::class, 'trash'])->name('order.trash'); // order.trash
Route::get('order/restore/{id}', [OrderController::class, 'restore'])->name('order.restore'); // order.restore
Route::get('order/export', [OrderController::class, 'export'])->name('order.export-excel'); // order.export-excel



// Users
Route::resource('users', UserController::class)->except('show');
Route::delete('user/softDelete/{id}', [UserController::class, 'softDelete'])->name('user.softDelete'); // user.softDelete
Route::get('user/trash', [UserController::class, 'trash'])->name('user.trash'); // user.trash
Route::get('user/restore/{id}', [UserController::class, 'restore'])->name('user.restore'); // user.restore

// change pass for admin
Route::get('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
Route::post('/change-password', [HomeController::class, 'updatePassword'])->name('update-password');


// roles - spatie
Route::resource('roles', RoleController::class)->except('show');
});





Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
