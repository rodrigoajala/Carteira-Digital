<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\AuthenticationTokenController;
use App\Http\Controllers\API\InvoiceController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::controller(AuthenticationTokenController::class)->group(function(){
    Route::post('auth/login', 'login');
    Route::middleware('auth:sanctum')->post('auth/logout', 'logout');
});


Route::middleware('auth:sanctum')->group(function (){
    Route::post('/users/invoices/register', [InvoiceController::class, 'register']);
    Route::get('/users/list', [AccountController::class, 'listUsers']);
    Route::post('/user/{userId}/add-credits/{amount}', [AccountController::class, 'addCredits']);
    Route::get('/users/me', [AccountController::class, 'me']);
    Route::get('/list/invoices', [InvoiceController::class, 'listInvoices']);
    Route::put('/invoice/{invoiceId}/pay', [InvoiceController::class, 'payInvoice']);
});

Route::post('/users/register', [AccountController::class, 'register']);




Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
