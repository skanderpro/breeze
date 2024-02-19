<?php

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

use App\Http\Controllers\CompanyController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MerchantController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('home');

    Route::get('/home', [HomeController::class, 'index'])->name('home');

//user routes
    Route::get('/account', [UserController::class, 'account']);
    Route::get('/newuser', [UserController::class, 'index'])->name('newuser');
    Route::get('/userlist', [UserController::class, 'showUserList'])->name('userlist');
    Route::get('/delete-user/{id}', [UserController::class, 'removeUser']);
    Route::get('/disable-user/{id}', [UserController::class, 'disableUser']);
    Route::get('/enable-user/{id}', [UserController::class, 'enableUser']);

    Route::get('users/{id}', [UserController::class, 'edit']);
    Route::post('users/{id}', [UserController::class, 'update']);

//company routes
    Route::get('pages', [PageController::class, 'index'])->name('pages');
    Route::get('page/create', [PageController::class, 'create'])->name('create-page');
    Route::post('page/create', [PageController::class, 'store'])->name('store-page');
    Route::get('page/{page}/edit', [PageController::class, 'edit'])->name('edit-page');
    Route::post('page/{page}/edit', [PageController::class, 'update'])->name('update-page');
//    Route::get('/company-delete/{id}', [CompanyController::class, 'removeCompany']);
//    Route::get('/company-edit/{id}', [CompanyController::class, 'detailsCompany']);
//    Route::post('company-edit/{id}', [CompanyController::class, 'editCompany']);
//    Route::get('/company-disable/{id}', [CompanyController::class, 'disableCompany']);
//    Route::get('/company-enable/{id}', [CompanyController::class, 'enableCompany']);


//company routes
    Route::get('company-list', [CompanyController::class, 'showCompany']);
    Route::get('company-create', [CompanyController::class, 'addCompany']);
    Route::post('company-create', [CompanyController::class, 'createCompany']);
    Route::get('/company-delete/{id}', [CompanyController::class, 'removeCompany']);
    Route::get('/company-edit/{id}', [CompanyController::class, 'detailsCompany']);
    Route::post('company-edit/{id}', [CompanyController::class, 'editCompany']);
    Route::get('/company-disable/{id}', [CompanyController::class, 'disableCompany']);
    Route::get('/company-enable/{id}', [CompanyController::class, 'enableCompany']);

//merchant routes
    Route::get('merchant-find', [MerchantController::class, 'findMerchant']);
    Route::post('merchant-find', [MerchantController::class, 'resultsMerchant']);
    Route::get('merchant-list', [MerchantController::class, 'showMerchant']);
    Route::get('merchant-create', [MerchantController::class, 'addMerchant']);
    Route::post('merchant-create', [MerchantController::class, 'createMerchant']);
    Route::get('/merchant-delete/{id}', [MerchantController::class, 'removeMerchant']);
    Route::get('/merchant-edit/{id}', [MerchantController::class, 'detailsMerchant']);
    Route::post('merchant-edit/{id}', [MerchantController::class, 'editMerchant']);

//purchase order routes
    Route::get('po-export', [PoController::class, 'export']);
    Route::get('po-export-engineer', [PoController::class, 'exportEngineer']);
    Route::get('po-export-site', [PoController::class, 'exportSite']);
    Route::get('po-export-task', [PoController::class, 'exportTask']);
    Route::get('po-export-merchant', [PoController::class, 'exportMerchant']);
    Route::get('po-export-finance', [PoController::class, 'exportFinance']);
    Route::get('po-export-no-date', [PoController::class, 'exportNoDate']);

    Route::get('po-list', [PoController::class, 'listFilter']);
    Route::get('po-list', [PoController::class, 'listPo']);
    Route::get('po-create', [PoController::class, 'addPo']);
    Route::post('po-create', [PoController::class, 'createPo']);
    Route::get('po-created', [PoController::class, 'createdPo']);
    Route::get('po-edit/{id}', [PoController::class, 'showPo']);
    Route::post('po-edit/{id}', [PoController::class, 'editPo']);

//notification routes
    Route::get('notification-create', [NotificationController::class, 'addNotification']);
    Route::post('notification-create', [NotificationController::class, 'createNotification']);

    Route::get('notification-list', [NotificationController::class, 'showNotification']);

    Route::get('notification-edit/{id}', [NotificationController::class, 'detailsNotification']);
    Route::post('notification-edit/{id}', [NotificationController::class, 'editNotification']);

});
