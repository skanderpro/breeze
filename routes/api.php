<?php

use App\Http\Controllers\Api\CompanyController;
use App\Http\Controllers\Api\MerchantController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\PageController;
use App\Http\Controllers\Api\PoController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PoRequestController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\UserController;
use App\Http\Resources\UserResource;
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
    return UserResource::make($request->user());
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
        Route::post('/', [CompanyController::class, 'store'])->name('store');
        Route::put('/{company}/toggle', [CompanyController::class, 'toggle'])->name('toggle');
        Route::put('/{company}', [CompanyController::class, 'update'])->name('update');
        Route::get('/{parent_id}/by-parent',[CompanyController::class, 'findByParent'])->name('find-by-parent');
    });

    Route::name('merchants.')->prefix('/merchants')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [MerchantController::class, 'index'])->name('index');
        Route::post('/', [MerchantController::class, 'createMerchant'])->name('store');
        Route::put('/{id}', [MerchantController::class, 'updateMerchant'])->name('update');
        Route::put('/{merchant}/toggle', [MerchantController::class, 'toggle'])->name('toggle');
        Route::get('/{parent_id}/by-parent',[MerchantController::class, 'findByParentMerchant'])->name('find-by-parent');
    });

    Route::name('notifications.')->prefix('/notifications')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::patch('/{notification}', [NotificationController::class, 'markAsRead'])->name('markAsRead');
        Route::delete('/', [NotificationController::class, 'removeRead'])->name('removeRead');
        Route::get('/banner', [NotificationController::class, 'getBanner'])->name('getBanner');
        Route::post('/banner', [NotificationController::class, 'setBanner'])->name('setBanner');
    });

	Route::name('users.')->prefix('/users')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::post('/', [UserController::class, 'storeUser'])->name('store');
        Route::get('/account', [UserController::class, 'account'])->name('account');
        Route::get('/{user}/settings', [UserController::class, 'userSettings'])->name('settings');
        Route::patch('/{user}/settings', [UserController::class, 'updateUserSettings'])->name('updateUserSettings');
        Route::patch('/enable/{id}', [UserController::class, 'enableUser'])->name('enable');
        Route::patch('/disable/{id}', [UserController::class, 'disableUser'])->name('disable');
        Route::patch('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::put('/{user}/toggle', [UserController::class, 'toggle'])->name('toggle');
        Route::delete('/{id}', [UserController::class, 'removeUser'])->name('remove');
    });

    Route::name('po.')->prefix('/po')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [PoController::class, 'index'])->name('index');
        Route::get('/my-pos', [PoController::class, 'myPos'])->name('myPos');
        Route::get('/{id}', [PoController::class, 'show'])->name('show');
        Route::post('/', [PoController::class, 'storePo'])->name('storePo');
		Route::post('/visit/{id}', [PoController::class, 'visit'])->name('visitPo');
		Route::post('/upload-pod/{id}', [PoController::class, 'uploadPOD'])->name('uploadPOD');
		Route::post('/{id}/upload-pod', [PoController::class, 'podUpload'])->name('podUpload');
		Route::post('/{id}/delete-pod', [PoController::class, 'podDelete'])->name('podDelete');
        Route::patch('/{id}', [PoController::class, 'update'])->name('update');
        Route::patch('/{po}/update', [PoController::class, 'updatePo'])->name('update');
		Route::patch('/{id}/cancel',[PoController::class, 'cancel'])->name('cancel');
    });

    Route::name('poRequest.')->prefix('/po-request')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [PoRequestController::class, 'index'])->name('index');
        Route::get('/counts', [PoRequestController::class, 'getCounts'])->name('counts');
        Route::get('/{user}/user-counters', [PoRequestController::class, 'getUserCounters'])->name('userCounters');
        Route::get('/counts/{number}', [PoRequestController::class, 'getSingleCounts'])->name('singleCounts');
        Route::get('/{id}', [PoRequestController::class, 'show'])->name('show');
		Route::get('/by-number/{number}', [PoRequestController::class, 'getByNumber'])->name('showByNumber');
        Route::patch('/{id}/approve', [PoRequestController::class, 'approve'])->name('approve');
        Route::post('/', [PoRequestController::class, 'storePo'])->name('storePo');
        Route::post('/{poNumber}/upload-file', [PoRequestController::class, 'uploadRequestFile'])->name('up');
        Route::patch('/{id}/cancel',[PoRequestController::class, 'cancel'])->name('cancel');
        Route::patch('/{po}/set-status',[PoRequestController::class, 'setStatus'])->name('setStatus');
    });

    Route::name('setting.')->prefix('/setting')->middleware(['auth:sanctum'])->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('index');
        Route::get('/{setting}', [SettingController::class, 'show'])->name('show');
        Route::post('/', [SettingController::class, 'store'])->name('store');
        Route::patch('/{setting}',[SettingController::class, 'update'])->name('update');
        Route::delete('/{setting}',[SettingController::class, 'delete'])->name('delete');
    });

});
