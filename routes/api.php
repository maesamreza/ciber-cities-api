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
    
    Route::post('add/product',[App\Http\Controllers\ProductController::class,'add']);
    // Route::post('add/product/seller',[App\Http\Controllers\ProductController::class,'sellerAddProd']);
    
});
Route::get('search/{name}', [App\Http\Controllers\ProductController::class,'search']);
    Route::get('products',[App\Http\Controllers\ProductController::class,'show']);
