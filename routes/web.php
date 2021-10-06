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
    Route::get('/update_password', [PageController::class, 'updatePasswordForm'])->name('update_passwordform');
    Route::post('/update_password', [PageController::class, 'updatePassword'])->name('update_password');
});