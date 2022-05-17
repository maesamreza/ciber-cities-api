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



//add this middleware to ensure that every request is authenticated
Route::middleware('auth:api')->group(function(){
    Route::get('user', [App\Http\Controllers\passportAuthController::class,'authenticatedUserDetails']);
    Route::get('seller', [App\Http\Controllers\passportAuthController::class,'authenticatedSellerDetails']);
    Route::post('update/seller', [App\Http\Controllers\passportAuthController::class,'updateSeller']);
    Route::get('vendor/products',[App\Http\Controllers\ProductController::class,'vendorProduct']);
    
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

        Route::get('seller-totlasales-count',[App\Http\Controllers\ProductController::class,'seller_totalsales_count']);
    
});
    Route::get('search/{name}', [App\Http\Controllers\ProductController::class,'search']);
    // Route::get('search/{id}', [App\Http\Controllers\ProductController::class,'search']);
    Route::get('products',[App\Http\Controllers\ProductController::class,'show']);
    Route::get('category',[App\Http\Controllers\CategoryController::class,'show']);
    Route::post('search/category', [App\Http\Controllers\CategoryController::class,'searchCategory']);








