<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ManagerController;

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

Route::middleware('guest:web')->group(function () {
    Route::get('/login', [UserController::class, 'login'])->name('user_login');
    Route::post('/login', [UserController::class, 'check']);
});
Route::middleware('auth:web')->group(function () {
    Route::post('/logout', [UserController::class, 'destroy']);
    Route::get('/attendance', [UserController::class, 'index']);
    Route::post('/attendance', [UserController::class, 'work']);
    Route::get('/attendance/list', [UserController::class, 'list'])->name('list');
    Route::get('/attendance/detail/{id}', [UserController::class, 'detail'])->name('user_detail');
    Route::post('/attendance/detail/{id}', [UserController::class, 'request'])->name('request');
});
Route::prefix('admin')->group(function () {
    Route::middleware('guest:manager')->group(function () {
        Route::get('/login', [ManagerController::class, 'login'])->name('manager_login');
        Route::post('/login', [ManagerController::class, 'check']);
    });
    Route::middleware('auth:manager')->group(function () {
        Route::post('/logout', [ManagerController::class, 'destroy']);
        Route::get('/attendance/list', [ManagerController::class, 'index'])->name('index');
        Route::get('/attendance/{id}', [ManagerController::class, 'detail'])->name('manager_detail');
        Route::get('/staff/list', [ManagerController::class, 'list']);
        Route::get('/attendance/staff/{id}', [ManagerController::class, 'staff'])->name('staff');
    });
});
Route::middleware('auth:manager')->group(function () {
    Route::get('/stamp_correction_request/list', [ManagerController::class, 'request_list']);
    Route::get('/stamp_correction_request/approve/{attendance_correct_request_id}', [ManagerController::class, 'request_approve'])->name('manager_approve');
    Route::post('/stamp_correction_request/approve/{attendance_correct_request_id}', [ManagerController::class, 'approve'])->name('approve');
});

