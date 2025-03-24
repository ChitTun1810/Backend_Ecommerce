<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Dashboard\RoleController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\BrandController;
use App\Http\Controllers\Dashboard\OrderController;
use App\Http\Controllers\Dashboard\BannerController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\ProductController;
use App\Http\Controllers\Dashboard\SettingController;
use App\Http\Controllers\Other\ApplicationController;
// use Illuminate\Foundation\Application;
use App\Http\Controllers\Dashboard\CategoryController;
use App\Http\Controllers\Dashboard\CustomerController;
use App\Http\Controllers\Dashboard\TownshipController;
use App\Http\Controllers\Dashboard\HomeController;
use App\Http\Controllers\Dashboard\ContactUsController;
use App\Http\Controllers\Dashboard\ProductInquiryController;
use App\Http\Controllers\Dashboard\ProductTypeController;
use App\Models\ProductInquiry;

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
    return to_route('login');
    // return Inertia::render('Welcome', [
    //     'canLogin'       => Route::has('login'),
    //     'canRegister'    => Route::has('register'),
    //     'laravelVersion' => Application::VERSION,
    //     'phpVersion'     => PHP_VERSION,
    // ]);
});


// Route::get('/dashboard', function () {
//     return Inertia::render('Dashboard');
// })
//     ->middleware(['auth'])
//     ->name('dashboard');

Route::get('/dashboard', [HomeController::class, 'index'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/notification', [ProfileController::class, 'storeToken'])->name('profile.storeToken');
});

Route::group(['middleware' => ['auth'], 'as' => 'admin.'], function () {
    Route::get('categories/by-parent', [CategoryController::class, 'filterByParent'])->name('categories.by-parent');
    Route::get('product-types/by-category', [ProductTypeController::class, 'filterByCategory'])->name('product-types.by-category');
    Route::get('/products/import', [ProductController::class, 'browse'])->name('products.browse');
    Route::post('/products/import', [ProductController::class, 'import'])->name('products.import');
    Route::get('/products/export', [ProductController::class, 'export'])->name('products.export');
    Route::delete('/products/delete-all', [ProductController::class, 'deleteAll'])->name('products.delete-all');
    Route::delete('/product-download-link/{id}', [ProductController::class, 'deleteLink'])->name('products.delete-link');

    Route::resources([
        'banners'       => BannerController::class,
        'categories'    => CategoryController::class,
        'brands'        => BrandController::class,
        'products'      => ProductController::class,
        'cities'        => CityController::class,
        'townships'     => TownshipController::class,
        'roles'         => RoleController::class,
        'users'         => UserController::class,
        'countries'     => CountryController::class,
        'product-types' => ProductTypeController::class,
    ]);

    Route::get('customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('customers/{id}', [CustomerController::class, 'show'])->name('customers.show');

    Route::get('/setting', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/setting-update', [SettingController::class, 'update'])->name('settings.update');
    Route::post('/setting-delivery-status', [SettingController::class, 'updateDeliveryStatus'])->name('setting.update-delivery-status');

    Route::post('/new-arrivals-products/{id}', [ProductController::class, 'newArrival'])->name('products.new-arrival');

    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
    Route::put('/orders/{id}/edit', [OrderController::class, 'update'])->name('orders.update');
    Route::post('/orders/{id}/refund', [OrderController::class, 'refund'])->name('orders.refund');
    Route::get('/contact-us', [ContactUsController::class, 'index'])->name('contact.index');
    Route::get('/contact-us/{id}', [ContactUsController::class, 'show'])->name('contact.show');
    Route::delete('/contact-us/{id}', [ContactUsController::class, 'destroy'])->name('contact.destroy');

    Route::get('/product-inquiries', [ProductInquiryController::class, 'index'])->name('product-inquiries.index');
    Route::delete('/product-inquiries/{id}', [ProductInquiryController::class, 'destroy'])->name('product-inquiries.destroy');
    Route::get('/product-inquiries/{id}', [ProductInquiryController::class, 'show'])->name('product-inquiries.show');
});

require __DIR__ . '/auth.php';

// Image For Show
Route::get('image/{filename}', [ApplicationController::class, 'image'])->where('filename', '.*');
