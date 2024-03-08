<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PoController;
use App\Http\Controllers\Api\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('v1.')->group(function () {
   Route::post('/login', [AuthController::class, 'login']);

   Route::name('pages.')->prefix('/pages')->group(function () {
       Route::get('/', [PageController::class, 'index'])->name('index');
       Route::get('/{page:slug}', [PageController::class, 'single'])->name('single');
   });

    Route::name('companies.')->prefix('/companies')->group(function () {
        Route::get('/', [CompanyController::class, 'index'])->name('index');
        Route::get('/{company}', [CompanyController::class, 'single'])->name('single');
    });

    Route::name('merchants.')->prefix('/merchants')->group(function () {
        Route::get('/', [MerchantController::class, 'index'])->name('index');
    });

    Route::name('notifications.')->prefix('/notifications')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{notification}', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::delete('/', [NotificationController::class, 'removeRead'])->name('removeRead');
    });

    Route::name('users.')->prefix('/users')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/account', [UserController::class, 'account'])->name('account');
        Route::patch('/enable/{id}', [UserController::class, 'enableUser'])->name('enable');
        Route::patch('/disable/{id}', [UserController::class, 'disableUser'])->name('disable');
        Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'removeUser'])->name('remove');
    });

    Route::name('po.')->prefix('/po')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [PoController::class, 'index'])->name('index');
    });
});
