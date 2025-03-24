<?php

use App\Http\Controllers\DeliveryAddressController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\DeliveryController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Platform\PageController;
use App\Http\Controllers\Platform\ProductController;
use App\Http\Controllers\Platform\CategoryController;
use App\Http\Controllers\Platform\ContactUsController;

//auth
Route::prefix('auth')->group(function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::put('/change-password', [AuthController::class, 'changePassword']);
    Route::put('/edit', [AuthController::class, 'edit']);
});


Route::get('banners', [BannerController::class, 'listing']);

Route::get('categories', [CategoryController::class, 'listing']);

Route::get('pages', [PageController::class, 'index']);
Route::get('product-pages', [PageController::class, 'productPage']); // product filter

Route::get('products', [ProductController::class, 'listing']);
Route::get('products/{id}', [ProductController::class, 'detail']);

Route::get('/product-search', [ProductController::class, 'searchProduct']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', [AuthController::class, 'authUser']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::post('/product-inquiry', [ProductController::class, 'sendProductInQuiry']);
    Route::get('/favourite_products', [ProductController::class, 'getFavouriteProducts']);
    Route::post('/toggle_favourites/{productId}', [ProductController::class, 'saveProduct']);
    Route::delete('/favourite_products/all_remove', [ProductController::class, 'removeAllFavouriteProduct']);

    Route::apiResource('/carts', CartController::class)->except(['show']);
    Route::get('/carts-count', [CartController::class, 'cartCount']);

    Route::delete('/carts-clear', [CartController::class, 'allClear']);

    Route::get('/cities', [DeliveryController::class, 'getAllCity']);
    Route::get('/city/{cityId}/townships', [DeliveryController::class, 'getTownships']);
    Route::get('/city/{cityId}/townships/{townshipId}/delivery_fee', [DeliveryController::class, 'getDeliveryFees']);

    Route::get('/checkout', [CheckoutController::class, 'getCheckout']);
    Route::post('/checkout', [CheckoutController::class, 'checkout']);

    Route::get('/orders', [OrderController::class, 'listing']);
    Route::get('/orders/{id}', [OrderController::class, 'detail']);

    Route::get('/city/{cityId}/township/{townshipId}/delivery-address', [DeliveryAddressController::class, 'address']);
});

Route::post('/contact-us/send', [ContactUsController::class, 'send']);
