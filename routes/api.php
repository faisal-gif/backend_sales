<?php

use App\Http\Controllers\Api\CustomerController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\PaketController;
use App\Http\Controllers\Api\PDFController;
use App\Http\Controllers\Api\UserController;
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



Route::apiResource('/paket', PaketController::class);
Route::apiResource('/customer', CustomerController::class);
Route::get('/rekap/customer', [CustomerController::class, 'rekapCustomer']);
Route::post('/login', LoginController::class)->name('login');
Route::get('/sales', [UserController::class, 'index']);
Route::post('/sales', [UserController::class, 'create']);
Route::get('/exportPdf', [PDFController::class, 'exportPDF']);

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/logout', LogoutController::class)->name('logout');








