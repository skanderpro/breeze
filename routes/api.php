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
use App\Http\Controllers\Api\PermissionController;
use App\Http\Controllers\Api\PoDocumentController;
use App\Http\Controllers\Api\PoHistoryController;
use App\Http\Controllers\Api\PoNoteController;
use App\Http\Controllers\Api\ReportController;
use App\Http\Controllers\Api\UserDeviceController;
use App\Http\Controllers\Api\BannerController;
use App\Http\Controllers\Api\ExportReport\ExportContractComplianceReportController;
use App\Http\Controllers\Api\ExportReport\ExportRebateReportController;
use App\Http\Controllers\Api\ExportReport\ExportSpendReportController;
use App\Http\Controllers\Api\ExportReport\ExportStatusReportController;
use App\Http\Controllers\Api\ExportReport\ExportSupplierReportController;
use App\Models\PoHistory;

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

Route::middleware("auth:api")->get("/user", function (Request $request) {
  return UserResource::make($request->user());
});

Route::prefix("v1")
  ->name("v1.")
  ->group(function () {
    Route::post("/login", [AuthController::class, "login"]);
    Route::post("/reset-password", [UserController::class, "resetPassword"]);

    Route::name("pages.")
      ->prefix("/pages")
      ->group(function () {
        Route::get("/", [PageController::class, "index"])->name("index");
        Route::get("/{page:slug}", [PageController::class, "single"])->name(
          "single"
        );
      });

    Route::name("companies.")
      ->prefix("/companies")
      ->group(function () {
        Route::get("/", [CompanyController::class, "index"])->name("index");
        Route::get("/admin-list", [
          CompanyController::class,
          "getAdminList",
        ])->name("admin-list");
        Route::get("/{company}", [CompanyController::class, "single"])->name(
          "single"
        );
        Route::post("/", [CompanyController::class, "store"])->name("store");
        Route::put("/{company}/toggle", [
          CompanyController::class,
          "toggle",
        ])->name("toggle");
        Route::put("/{company}", [CompanyController::class, "update"])->name(
          "update"
        );
        Route::get("/{parent_id}/by-parent", [
          CompanyController::class,
          "findByParent",
        ])->name("find-by-parent");
        Route::get("/{company}/lockout-validate", [
          CompanyController::class,
          "lockoutValidate",
        ])->name("lockout-validate");
      });

    Route::name("merchants.")
      ->prefix("/merchants")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/", [MerchantController::class, "index"])->name("index");
        Route::post("/", [MerchantController::class, "createMerchant"])->name(
          "store"
        );
        Route::get("/admin-list", [
          MerchantController::class,
          "getAdminList",
        ])->name("admin-list");
        Route::put("/{id}", [
          MerchantController::class,
          "updateMerchant",
        ])->name("update");
        Route::put("/{merchant}/toggle", [
          MerchantController::class,
          "toggle",
        ])->name("toggle");
        Route::get("/{parent_id}/by-parent", [
          MerchantController::class,
          "findByParentMerchant",
        ])->name("find-by-parent");
      });

    Route::name("notifications.")
      ->prefix("/notifications")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/", [NotificationController::class, "index"])->name(
          "index"
        );

        Route::get("/count-unread", [
          NotificationController::class,
          "countUnread",
        ])->name("count-unread");
        Route::get("/{notification}", [
          NotificationController::class,
          "show",
        ])->name("show");
        Route::patch("/{notification}", [
          NotificationController::class,
          "markAsRead",
        ])->name("markAsRead");
        Route::delete("/", [NotificationController::class, "removeRead"])->name(
          "removeRead"
        );

        Route::post("/send-to-all", [
          NotificationController::class,
          "sendToAll",
        ])->name("sendToAll");
      });

    Route::name("banners")
      ->prefix("/banners")
      ->middleware("auth:sanctum")
      ->group(function () {
        Route::get("/", [BannerController::class, "show"])->name("show");
        Route::post("/", [BannerController::class, "store"])->name("store");
      });

    Route::name("export")
      ->prefix("/export")
      ->middleware("auth:sanctum")
      ->group(function () {
        Route::post("/by-company", [
          ExportSpendReportController::class,
          "byCompany",
        ])->name("byCompany");
        Route::post("/by-contract", [
          ExportSpendReportController::class,
          "byContract",
        ])->name("byContract");
        Route::post("/by-user", [
          ExportSpendReportController::class,
          "byUser",
        ])->name("byUser");
        Route::post("/by-company-rebate", [
          ExportRebateReportController::class,
          "byCompanyRebate",
        ])->name("byCompanyRebate");
        Route::post("/by-contract-rebate", [
          ExportRebateReportController::class,
          "byContractRebate",
        ])->name("byContractRebate");
        Route::post("/company-compliens-report", [
          ExportContractComplianceReportController::class,
          "companyCompliensReport",
        ])->name("companyCompliensReport");
        Route::post("/contract-compliens-report", [
          ExportContractComplianceReportController::class,
          "contractCompliensReport",
        ])->name("contractCompliensReport");
        Route::post("/user-compliens-report", [
          ExportContractComplianceReportController::class,
          "userCompliensReport",
        ])->name("userCompliensReport");
        Route::post("/supplier-supplier-report", [
          ExportSupplierReportController::class,
          "supplierSupplierReport",
        ])->name("supplierSupplierReport");
        Route::post("/supplier-type-report", [
          ExportSupplierReportController::class,
          "supplierTypeReport",
        ])->name("supplierTypeReport");
        Route::post("/company-status-report", [
          ExportStatusReportController::class,
          "companyStatusReport",
        ])->name("companyStatusReport");
        Route::post("/contract-status-report", [
          ExportStatusReportController::class,
          "contractStatusReport",
        ])->name("contractStatusReport");
        Route::post("/user-status-report", [
          ExportStatusReportController::class,
          "userStatusReport",
        ])->name("userStatusReport");
      });

    Route::name("users.")
      ->prefix("/users")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/", [UserController::class, "index"])->name("index");
        Route::post("/", [UserController::class, "storeUser"])->name("store");
        Route::get("/account", [UserController::class, "account"])->name(
          "account"
        );
        Route::get("/{user}/settings", [
          UserController::class,
          "userSettings",
        ])->name("settings");

        Route::get("/{user}/is-email-unique/{email}", [
          UserController::class,
          "isEmailUnique",
        ])->name("is-email-unique");
        Route::patch("/{user}/settings", [
          UserController::class,
          "updateUserSettings",
        ])->name("updateUserSettings");
        Route::patch("/enable/{id}", [
          UserController::class,
          "enableUser",
        ])->name("enable");
        Route::patch("/disable/{id}", [
          UserController::class,
          "disableUser",
        ])->name("disable");
        Route::patch("/update/{id}", [UserController::class, "update"])->name(
          "update"
        );
        Route::put("/{user}/toggle", [UserController::class, "toggle"])->name(
          "toggle"
        );
        Route::delete("/{id}", [UserController::class, "removeUser"])->name(
          "remove"
        );
      });

    Route::name("user-device.")
      ->prefix("/user-device")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::post("/", [UserDeviceController::class, "store"])->name("store");
      });

    Route::name("po.")
      ->prefix("/po")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/", [PoController::class, "index"])->name("index");
        Route::get("/my-pos", [PoController::class, "myPos"])->name("myPos");
        Route::get("/admin-pos", [PoController::class, "adminPos"])->name(
          "adminPos"
        );
        Route::get("/{user}/by-user", [PoController::class, "byUser"])->name(
          "by-user"
        );
        Route::get("export", [PoController::class, "export"])->name("export");
        Route::get("/{id}", [PoController::class, "show"])->name("show");
        Route::post("/", [PoController::class, "storePo"])->name("storePo");
        Route::post("/update-company-po/{po}", [
          PoController::class,
          "updateCompanyPo",
        ])->name("updateCompanyPo");
        Route::patch("/{id}/visit", [PoController::class, "visit"])->name(
          "visitPo"
        );
        Route::post("/upload-pod/{id}", [
          PoController::class,
          "uploadPOD",
        ])->name("uploadPOD");
        Route::post("/{id}/upload-pod", [
          PoController::class,
          "podUpload",
        ])->name("podUpload");
        Route::post("/{id}/delete-pod", [
          PoController::class,
          "podDelete",
        ])->name("podDelete");
        Route::patch("/{po}/update", [PoController::class, "updatePo"])->name(
          "update"
        );
        Route::patch("/{po}/cancel", [PoController::class, "cancel"])->name(
          "cancel"
        );
        Route::put("po-note", [PoController::class, "addNote"])->name(
          "add-note"
        );
        Route::put("po-document", [PoController::class, "addDocument"])->name(
          "add-document"
        );
      });

    Route::name("poNote.")
      ->prefix("/po-note")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::post("/", [PoNoteController::class, "store"])->name("store");
      });

    Route::name("poDocument.")
      ->prefix("/po-document")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::post("/", [PoDocumentController::class, "store"])->name("store");
      });

    Route::name("poHistory.")
      ->prefix("/po-history")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/{po}", [PoHistoryController::class, "index"])->name(
          "index"
        );
        Route::post("/", [PoHistoryController::class, "store"])->name("store");
      });

    Route::name("poRequest.")
      ->prefix("/po-request")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        // Route::get("/", [PoRequestController::class, "index"])->name("index");
        Route::get("/my-requests", [
          PoRequestController::class,
          "myRequests",
        ])->name("myRequests");
        Route::get("/admin-requests", [
          PoRequestController::class,
          "adminRequests",
        ])->name("adminsRequests");
        Route::get("/counts", [PoRequestController::class, "getCounts"])->name(
          "counts"
        );
        Route::get("/{user}/user-counters", [
          PoRequestController::class,
          "getUserCounters",
        ])->name("userCounters");
        Route::get("/counts/{number}", [
          PoRequestController::class,
          "getSingleCounts",
        ])->name("singleCounts");
        Route::get("/{id}", [PoRequestController::class, "show"])->name("show");
        Route::get("/by-number/{number}", [
          PoRequestController::class,
          "getByNumber",
        ])->name("showByNumber");
        Route::patch("/{id}/approve", [
          PoRequestController::class,
          "approve",
        ])->name("approve");
        Route::post("/", [PoRequestController::class, "storePo"])->name(
          "storePo"
        );
        Route::post("/{poNumber}/upload-file", [
          PoRequestController::class,
          "uploadRequestFile",
        ])->name("up");
        Route::post("/upload-file", [
          PoRequestController::class,
          "uploadFile",
        ])->name("uploadFile");
        Route::patch("/{id}/cancel", [
          PoRequestController::class,
          "cancel",
        ])->name("cancel");
        Route::patch("/{po}/set-status", [
          PoRequestController::class,
          "setStatus",
        ])->name("setStatus");
        Route::patch("/{po}/upload", [
          PoRequestController::class,
          "uploadRequest",
        ])->name("uploadRequest");
      });

    Route::name("setting.")
      ->prefix("/setting")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/", [SettingController::class, "index"])->name("index");
        Route::get("/{setting}", [SettingController::class, "show"])->name(
          "show"
        );
        Route::post("/", [SettingController::class, "store"])->name("store");
        Route::patch("/{setting}", [SettingController::class, "update"])->name(
          "update"
        );
        Route::delete("/{setting}", [SettingController::class, "delete"])->name(
          "delete"
        );
      });

    Route::name("permission.")
      ->prefix("/permission")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::post("/check", [PermissionController::class, "check"])->name(
          "check"
        );
      });

    Route::name("report.")
      ->prefix("/report")
      ->middleware(["auth:sanctum"])
      ->group(function () {
        Route::get("/", [ReportController::class, "index"])->name("index");
      });
  });
