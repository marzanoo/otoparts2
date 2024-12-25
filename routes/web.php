<?php

use App\Http\Controllers\BrandController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\DetailsController;
use App\Http\Controllers\DistributorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\PurchaseDetailController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\SalesController;
use App\Http\Controllers\SessionsController;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::get('rtl', function () {
		return view('rtl');
	})->name('rtl');

	//pembelian
	Route::get('/pembelian', [PurchaseController::class, 'index']);
	Route::post('/add-pembelian', [PurchaseController::class, 'add']);
	Route::delete('/delete-pembelian/{id}', [PurchaseController::class, 'delete']);
	Route::put('/edit-pembelian/{id}', [PurchaseController::class, 'edit']);


	//detail pembelian
	Route::get('/purchase-details/{id}', [PurchaseDetailController::class, 'index'])->name('purchase-details');
	Route::post('/add-purchase-details', [PurchaseDetailController::class, 'add']);
	Route::delete('/delete-purchase-details/{id_pembelian}/{id_barang}', [PurchaseDetailController::class, 'delete']);

	//detail penjualan
	Route::get('/details/{id}', [DetailsController::class, 'index'])->name('details');
	Route::post('/add-details', [DetailsController::class, 'add']);
	//Route::put('/edit-details/{id_penjualan}/{id_barang}', [DetailsController::class, 'edit']);
	Route::delete('/delete-details/{id_penjualan}/{id_barang}', [DetailsController::class, 'delete']);

	//penjualan
	Route::get('/penjualan', [SalesController::class, 'index']);
	Route::post('/add-penjualan', [SalesController::class, 'add']);
	Route::delete('/delete-penjualan/{id}', [SalesController::class, 'delete']);
	Route::put('/edit-penjualan/{id}', [SalesController::class, 'edit']);

	//distributor
	Route::get('/distributor', [DistributorController::class, 'index']);
	Route::post('/add-distributor', [DistributorController::class, 'add']);
	Route::delete('/delete-distributor/{id}', [DistributorController::class, 'delete']);
	Route::put('/edit-distributor/{id}', [DistributorController::class, 'edit']);

	//merek
	Route::get('/merek', [BrandController::class, 'index']);
	Route::post('/add-merek', [BrandController::class, 'add']);
	Route::delete('/delete-merek/{id}', [BrandController::class, 'delete']);
	Route::put('/edit-merek/{id}', [BrandController::class, 'edit']);

	//barang
	Route::get('/barang', [ProductController::class, 'index']);
	Route::post('/add-barang', [ProductController::class, 'add']);
	Route::delete('/delete-barang/{id}', [ProductController::class, 'delete']);
	Route::put('/edit-barang/{id}', [ProductController::class, 'edit']);


	Route::get('user-management', function () {
		return view('laravel-examples/user-management');
	})->name('user-management');

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('virtual-reality', function () {
		return view('virtual-reality');
	})->name('virtual-reality');

    Route::get('static-sign-in', function () {
		return view('static-sign-in');
	})->name('sign-in');

    Route::get('static-sign-up', function () {
		return view('static-sign-up');
	})->name('sign-up');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});



Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

Route::get('/login', function () {
    return view('session/login-session');
})->name('login');