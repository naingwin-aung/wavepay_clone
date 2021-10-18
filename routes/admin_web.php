<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\WalletController;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Backend\AdminUserController;

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

Route::get('/admin/login', [AdminLoginController::class, 'showAdminLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    Route::resource('admin', AdminUserController::class);
    Route::get('/admin/datatable/ssd', [AdminUserController::class, 'serverSide']);

    Route::resource('user', UserController::class);
    Route::get('/user/datatable/ssd', [UserController::class, 'serverSide']);

    Route::get('wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::get('/wallet/datatable/ssd', [WalletController::class, 'serverSide']);

    Route::get('/wallet/addAmount', [WalletController::class, 'addAmountForm'])->name('wallet.addamount');
    Route::post('/wallet/addAmount', [WalletController::class, 'addAmount'])->name('wallet.addAmountuser');
});
