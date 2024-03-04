<?php

use App\Http\Controllers\Api\Admin\Auth\AdminLoginApiController;
use App\Http\Controllers\Api\Customer\CustomerApiController;
use App\Http\Controllers\Api\EcommerceIntegration\EcommerceApiController;
use App\Http\Controllers\Api\Order\OrderApiController;
use App\Http\Controllers\Api\Product\ProductApiController;
use App\Http\Controllers\Api\Store\StoreApiController;
use App\Http\Controllers\Api\User\Auth\UserLoginApiController;
use App\Http\Controllers\Api\User\Auth\UserRegisterApiController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\User\Auth\UserLogoutApiController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Users auth routes
Route::post('/register', [UserRegisterApiController::class, 'register']);
Route::post('/login', [UserLoginApiController::class, 'login']);

// Admin auth route
Route::post('/admin/login', [AdminLoginApiController::class, 'login']);

Route::get('/ecommerce/callback', [EcommerceApiController::class, 'callback']);
//Routes for admin.
Route::middleware('admin')->group(function () {

    //ecommerce integration auth
    Route::get('/ecommerce/auth', [EcommerceApiController::class, 'sendAuthRequest']);

    //store info details
    Route::get('store/details', [StoreApiController::class, 'getStoreDetails']);

    //customers
    Route::post('customers',[CustomerApiController::class,'create']);

});

//Routes for users.
Route::middleware(['auth:api'])->group(function (){

    //Products
    Route::get('products', [ProductApiController::class, 'index']);
    Route::get('products/{id}', [ProductApiController::class, 'show']);

    //orders
    Route::post('orders',[OrderApiController::class,'create']);

    //logout
    Route::post('/logout', [UserLogoutApiController::class, 'logout']);
});
