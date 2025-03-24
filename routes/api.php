<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\BrandController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DeliveryController;

//auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('banners', [BannerController::class, 'listing']);

Route::get('categories', [CategoryController::class, 'listing']);
Route::get('categories/{id}', [CategoryController::class, 'detail']);

Route::get('brands', [BrandController::class, 'listing']);
Route::get('brands/{id}', [BrandController::class, 'detail']);

Route::get('new-arrival/products', [ProductController::class, 'newArrivalListing']);

Route::get('products', [ProductController::class, 'listing']);
Route::get('products/{id}', [ProductController::class, 'detail']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'authUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('/favourite_products', [ProductController::class, 'getFavouriteProducts']);
    Route::post('/toggle_favourites/{productId}', [ProductController::class, 'saveProduct']);
    Route::delete('/favourite_products/all_remove', [ProductController::class, 'removeAllFavouriteProduct']);

    Route::apiResource('/carts', CartController::class)->except([
        'show'
    ]);
    Route::delete('/carts-clear', [CartController::class, 'allClear']);

    Route::get('/cities', [DeliveryController::class, 'getAllCity']);
    Route::get('/city/{cityId}/townships', [DeliveryController::class, 'getTownships']);
    Route::get('/city/{cityId}/townships/{townshipId}/delivery_fee', [DeliveryController::class, 'getDeliveryFees']);

    Route::get('/checkout', [CheckoutController::class, 'getCheckout']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    Route::get('/orders', [OrderController::class, 'listing']);
    Route::get('/orders/{id}', [OrderController::class, 'detail']);
});

Route::any('callback/ccpp', [CheckoutController::class, 'callback']);
Route::any('webhook/ccpp', [CheckoutController::class, 'webhook']);
