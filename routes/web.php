<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\PageController;

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

Auth::routes([
    'reset' => false,
    'confirm' => false
]);

Route::middleware(['auth'])->name('user.')->group(function () {
    Route::get('/', [PageController::class, 'home'])->name('home');
    Route::get('/user-info', [PageController::class, 'userInfo'])->name('info');
    Route::get('/user-updateinfo', [PageController::class, 'userUpdateInfo'])->name('userUpdateInfo');
    Route::post('/update_password', [PageController::class, 'updatePassword'])->name('update_password');
    Route::get('/transfer', [PageController::class, 'transferForm'])->name('transferForm');
    Route::get('/transfer-amount', [PageController::class, 'transferAmountForm'])->name('transferAmountForm');
    Route::get('/transfer-confirm', [PageController::class, 'transferConfirmForm'])->name('transferConfirmForm');
    Route::get('/password-check', [PageController::class, 'passwordCheck'])->name('passwordCheck');
    Route::post('/transfer-complete', [PageController::class, 'transferComplete'])->name('transferComplete');
    Route::get('/transaction-detail/{trx_id}', [PageController::class, 'transactionDetail'])->name('transactionDetail');
    Route::get('/transaction', [PageController::class, 'transaction'])->name('transaction');
    Route::get('/receive-qr', [PageController::class, 'receiveQr'])->name('receiveQr');
    Route::get('/top-up', [PageController::class, 'topUp'])->name('topUp');
    Route::post('/top-up', [PageController::class, 'fillTopUp'])->name('topUp');
});