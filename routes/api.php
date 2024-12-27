<?php

use App\Http\Controllers\api\AuthController;
use App\Http\Controllers\api\BrandController;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\SalesController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//product
Route::apiResource('/product', ProductController::class);
Route::get('/cariproduct', [ProductController::class, 'cari']);
Route::put('product/{id}', [ProductController::class, 'update']);
Route::delete('product/{id}', [ProductController::class, 'destroy']);

//merek
Route::apiResource('/brand', BrandController::class);
Route::get('/caribrand', [BrandController::class, 'cari']);

//penjualan
Route::apiResource('/sales', SalesController::class);
Route::get('/countsales', [SalesController::class, 'count']);
Route::get('/sumsales', [SalesController::class, 'sum']);

//login
Route::get('user', [AuthController::class, 'index']);
Route::post('login', [AuthController::class, 'login']);

