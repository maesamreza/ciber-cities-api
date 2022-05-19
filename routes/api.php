<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register',[App\Http\Controllers\passportAuthController::class,'registerUserExample']);
Route::post('seller/register',[App\Http\Controllers\passportAuthController::class,'registerSellerExample']);
Route::post('login',[App\Http\Controllers\passportAuthController::class,'loginUserExample']);
Route::post('seller/login',[App\Http\Controllers\passportAuthController::class,'loginSellerExample']);
Route::post('admin/login',[App\Http\Controllers\passportAuthController::class,'loginAdminExample']);



//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->group(function(){
    Route::get('user', [App\Http\Controllers\passportAuthController::class,'authenticatedUserDetails']);
    Route::get('seller', [App\Http\Controllers\passportAuthController::class,'authenticatedSellerDetails']);
    Route::post('update/seller', [App\Http\Controllers\passportAuthController::class,'updateSeller']);
    Route::post('update/user', [App\Http\Controllers\passportAuthController::class,'updateUser']);
    Route::get('vendor/products',[App\Http\Controllers\ProductController::class,'vendorProduct']);
    Route::get('vendor/featured/products',[App\Http\Controllers\ProductController::class,'vendorFeaturedProduct']);
    Route::get('admin/user', [App\Http\Controllers\passportAuthController::class,'userDetails']);
    Route::get('admin/seller', [App\Http\Controllers\passportAuthController::class,'sellerDetails']);
    Route::get('admin/user/delete/{id}', [App\Http\Controllers\passportAuthController::class,'userDelete']);
    Route::get('admin/seller/delete/{id}', [App\Http\Controllers\passportAuthController::class,'sellerDelete']);
    Route::get('admin/seller/prod/featured', [App\Http\Controllers\ProductController::class,'featureProduct']);
    Route::get('admin/seller/prod/featured/{id}', [App\Http\Controllers\ProductController::class,'featureProductStatusChange']);
    
    Route::post('add/product',[App\Http\Controllers\ProductController::class,'add']);
    Route::post('update/product',[App\Http\Controllers\ProductController::class,'update']);
    Route::post('delete/product',[App\Http\Controllers\ProductController::class,'delete']);
    Route::get('image/{id}',[App\Http\Controllers\ProductController::class,'image']);
    Route::post('delete/image',[App\Http\Controllers\ProductController::class,'deleteImage']);
    Route::post('add/image',[App\Http\Controllers\ProductController::class,'addImage']);
    Route::post('show/product',[App\Http\Controllers\ProductController::class,'showProduct']);
    Route::post('order',[App\Http\Controllers\OrderController::class,'order']);
    Route::post('order/review',[App\Http\Controllers\OrderController::class,'review']);
    Route::get('order/rating',[App\Http\Controllers\OrderController::class,'rating']);
    Route::get('order/sales',[App\Http\Controllers\OrderController::class,'sales']);

    Route::post('payment',[App\Http\Controllers\PaymentController::class,'payment']);
    // Route::post('add/product/seller',[App\Http\Controllers\ProductController::class,'sellerAddProd']);

    Route::get('user-orders',[App\Http\Controllers\OrderController::class,'user_orders']);
    Route::get('seller-orders',[App\Http\Controllers\OrderController::class,'seller_orders']);
    
    Route::get('user-orders-details/{id}',[App\Http\Controllers\OrderController::class,'user_orders_details']);
    Route::get('seller-orders-details/{id}',[App\Http\Controllers\OrderController::class,'seller_orders_details']);
    
    Route::get('seller-products-count',[App\Http\Controllers\ProductController::class,'seller_products_count']);
    Route::get('seller-top-products',[App\Http\Controllers\ProductController::class,'seller_top_products']);
    Route::get('seller-totalsales-count',[App\Http\Controllers\ProductController::class,'seller_totalsales_count']);
    Route::get('seller-top-costomers',[App\Http\Controllers\ProductController::class,'seller_top_customers']);
    Route::get('seller-line-chart',[App\Http\Controllers\ProductController::class,'seller_line_chart']);
    
    Route::get('admin-vendor-count',[App\Http\Controllers\ProductController::class,'admin_vendor_count']);
    Route::get('admin-vendor-sales',[App\Http\Controllers\ProductController::class,'admin_vendor_sales']);
    Route::get('admin-totalsales-count',[App\Http\Controllers\ProductController::class,'admin_totalsales_count']);
    Route::get('admin-customer-count',[App\Http\Controllers\ProductController::class,'admin_customer_count']);
});

Route::get('search/{name}', [App\Http\Controllers\ProductController::class,'search']);
// Route::get('search/{id}', [App\Http\Controllers\ProductController::class,'search']);
Route::get('products',[App\Http\Controllers\ProductController::class,'show']);
Route::get('category',[App\Http\Controllers\CategoryController::class,'show']);
Route::post('search/category', [App\Http\Controllers\CategoryController::class,'searchCategory']);






