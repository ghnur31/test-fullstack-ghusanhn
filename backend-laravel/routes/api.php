<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\AddressController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Customer routes
Route::get('customers', [CustomerController::class, 'index']);
Route::post('customers', [CustomerController::class, 'store']);
Route::get('customers/{id}', [CustomerController::class, 'show']);
Route::get('customers/{id}/edit', [CustomerController::class, 'edit']);
Route::put('customers/{id}/edit', [CustomerController::class, 'update']);
Route::delete('customers/{id}/delete', [CustomerController::class, 'destroy']);

// Address routes
Route::get('addresses', [AddressController::class, 'index']);
Route::post('addresses', [AddressController::class, 'store']);
Route::get('addresses/{id}/edit', [AddressController::class, 'show']);
Route::put('addresses/{id}/edit', [AddressController::class, 'update']);
Route::delete('addresses/{id}/delete', [AddressController::class, 'destroy']);