<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\InfrastructureObjectController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordResetController;
use App\Http\Controllers\Auth\RegistrationController;
use App\Http\Controllers\Map\MapController;
use App\Http\Controllers\UserProfile\ProfileController;
use App\Models\UserRole;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('homepage');

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

Route::get('/api/map/objects', [MapController::class, 'index'])->name('api.map.objects');

Route::middleware(['auth', 'role:' . implode(',' , UserRole::ALLOWED_ADMIN_ROLES)])->group(function () {
    Route::group(['prefix' => 'dashboard', 'as' => 'dashboard.'], function () {
        Route::get('/', [DashboardController::class, 'index'])->name('index');

        Route::resource('objects', InfrastructureObjectController::class)->names('objects');
    });
});

Route::middleware(['auth', 'role:' . UserRole::USER_ROLE_GUEST])->prefix('profile')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'index'])->name('index');
    Route::post('profile', [ProfileController::class, 'update'])->name('update');
    Route::get('/partial/{section}', [ProfileController::class, 'partial'])->name('partial');
});