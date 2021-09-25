<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;

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

// Auth::routes();

Route::get('/admin/login', [AdminLoginController::class, 'showAdminLoginForm']);
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login');

Route::middleware(['auth:admin'])->group(function () {
    Route::get('/admin', function() {
        return 'admin_login';
    });
});
