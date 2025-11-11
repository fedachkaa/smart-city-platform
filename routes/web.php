<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DashboardRequestController;
use App\Http\Controllers\Admin\DashboardRoutesController;
use App\Http\Controllers\Admin\InfrastructureObjectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Map\MapController;
use App\Http\Controllers\User\ProfileController;
use App\Http\Controllers\User\RequestController;
use App\Models\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', [MapController::class, 'index'])->name('homepage');
Route::get('/api/map/objects', [MapController::class, 'getMapData'])->name('api.map.objects');

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('guest')->group(function () {
    Route::get('/forgot-password', [PasswordResetController::class, 'forgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [PasswordResetController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [PasswordResetController::class, 'resetPassword'])->name('password.update');
});
Route::get('/registration', [RegistrationController::class, 'showRegistrationForm'])->name('register');
Route::post('/registration', [RegistrationController::class, 'register'])->name('register.post');
Route::get('/cities/search', [RegistrationController::class, 'citiesList'])->name('cities.search');

Route::middleware(['auth', 'role:' . implode(',' , UserRole::ALLOWED_ADMIN_ROLES)])->group(function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');
        Route::resource('objects', InfrastructureObjectController::class)->names('objects');
        Route::get('api/objects', [InfrastructureObjectController::class, 'getInfrastructureObjectsList'])->name('api.objects');
        Route::resource('requests', DashboardRequestController::class)->only(['index', 'edit', 'update', 'destroy'])->names('requests');
        Route::resource('routes', DashboardRoutesController::class)->names('routes');
        Route::post('routes/preview', [DashboardRoutesController::class, 'previewRoute'])->name('routes.preview');
    });
});

Route::middleware(['auth', 'role:' . UserRole::USER_ROLE_GUEST])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('profile', [ProfileController::class, 'update'])->name('update');

    Route::get('requests/create', [RequestController::class, 'create'])->name('requests.create');
    Route::post('requests', [RequestController::class, 'store'])->name('requests.store');
    Route::get('requests/{userRequest}', [RequestController::class, 'show'])->name('profile.requests.show');
    Route::get('api/requests', [RequestController::class, 'getRequests'])->name('profile.api.requests');

    Route::get('api/objects', [RequestController::class, 'getInfrastructureObjectsList'])->name('api.objects');
});