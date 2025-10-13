<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InfrastructureObjectController;
use App\Http\Controllers\Auth\LoginController;
use App\Models\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'role:' . implode(',' , UserRole::ALLOWED_ADMIN_ROLES)])->group(function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::resource('objects', InfrastructureObjectController::class)->names('objects');
    });
});
