<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use Illuminate\Support\Facades\Route;

//login routes
Route::post('/login', [AuthController::class, 'login']);

//Routes accessible to all authenticated users
Route::middleware('auth:sanctum')->group(function () {

    //Owner-only routes
    Route::middleware('role:1')->group(function () {
        Route::post('/medicine', [ProductController::class, 'addItem']);
        Route::post('/customer', [CustomerController::class, 'addCustomer']);
        Route::put('/customer/{id}', [CustomerController::class, 'updateCustomer']);
        Route::delete('/customer/{id}', [CustomerController::class, 'deleteCustomer']);
        Route::delete('/medicine/{id}', [ProductController::class, 'removeItem']);
        Route::put('/medicine/{id}', [ProductController::class, 'editItem']);
    });

    //Manager-only routes
    Route::middleware('role:2')->group(function () {
        Route::put('/customer/{id}', [CustomerController::class, 'updateCustomer']);
        Route::delete('/customer/{id}', [CustomerController::class, 'deleteCustomer']);
    });

    //Cashier-only routes
    Route::middleware('role:3')->group(function () {
        Route::delete('/medicine/{id}', [ProductController::class, 'removeItem']);
        Route::put('/medicine/{id}', [ProductController::class, 'editItem']);
    });
});
