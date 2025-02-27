<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admin\Auth\NewPasswordController;
use App\Http\Controllers\Admin\Auth\PasswordResetLinkController;
use App\Http\Controllers\Admin\Auth\RegisteredUserController;
use App\Http\Controllers\UserResourseController;
use App\Http\Controllers\ProductResourseController;
use App\Http\Controllers\BrandResourseController;
use App\Http\Controllers\CategoryResourseController;
use App\Http\Controllers\SubCategoryResourseController;
use App\Http\Controllers\UnitResourseController;
use App\Http\Controllers\ShopResourseController;
use App\Http\Controllers\InventoryResourseController;
use App\Http\Controllers\OrderResourseController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->middleware('guest:admin')->group(function () {

    Route::get('login', [AuthenticatedSessionController::class, 'create'])
                ->name('admin.login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);

    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])
                ->name('password.request');

    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])
                ->name('password.email');

    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])
                ->name('password.reset');

    Route::post('reset-password', [NewPasswordController::class, 'store'])
                ->name('password.update');

   
});

Route::get('/brand_dropdown', [BrandResourseController::class, 'brand_dropdown']);
Route::get('/category_dropdown', [SubCategoryResourseController::class, 'category_dropdown']);
Route::get('/subcategory_dropdown', [SubCategoryResourseController::class, 'subcategory_dropdown']);
Route::get('/product_dropdown', [ProductResourseController::class, 'product_dropdown']);
Route::get('/unit_dropdown', [UnitResourseController::class, 'unit_dropdown']);
Route::get('/inventory_dropdown', [InventoryResourseController::class, 'inventory_dropdown']);
Route::get('/inventory_dropdown_change', [InventoryResourseController::class, 'inventory_dropdown_change']);
Route::post('/order_summary', [OrderResourseController::class, 'orderSummary']);
Route::post('/orders/create', [OrderResourseController::class, 'create']);
Route::get('/cancel_order/{id}', [OrderResourseController::class, 'cancel_order']);

Route::prefix('admin')->middleware('auth:admin')->group(function () {

   
    Route::get('profile', [UserResourseController::class, 'profile'])
                ->name('admin.profile');
    Route::post('profile/{id}', [UserResourseController::class, 'profileUpdate']);
    Route::get('users', [UserResourseController::class, 'index'])
    ->name('admin.users');
 
  
    Route::resource('users', UserResourseController::class);
    Route::resource('brands', BrandResourseController::class);
    Route::resource('products', ProductResourseController::class);
    Route::resource('categories', CategoryResourseController::class);
    Route::resource('subcategories', SubCategoryResourseController::class);
    Route::resource('units', UnitResourseController::class);
    Route::resource('shops', ShopResourseController::class);
    Route::resource('inventories', InventoryResourseController::class);
    Route::resource('orders', OrderResourseController::class);
    

    
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
                ->name('admin.logout');
    Route::get('/dashboard', [UserResourseController::class, 'adminDashboard'])->name('admin.dashboard');
});
