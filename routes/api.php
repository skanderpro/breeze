<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\AuthController;
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

});
