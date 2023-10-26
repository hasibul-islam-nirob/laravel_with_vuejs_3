<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\CustomersController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/get_all_invoices', [InvoiceController::class, 'get_all_invoices']);
Route::get('/search_invoice', [InvoiceController::class, 'search_invoice']);
Route::get('/create_invoice', [InvoiceController::class, 'create_invoice']);


Route::post('/add_invoice', [InvoiceController::class, 'add_invoice']);

Route::get('/show_invoice/{id}', [InvoiceController::class, 'show_invoice']);


Route::get('/customers', [CustomersController::class, 'get_all_customers']);

Route::get('/products', [ProductsController::class, 'get_all_products']);