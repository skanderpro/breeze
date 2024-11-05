<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use App\Events\CheckOrderLimit;
use Illuminate\Support\Facades\Log;

class Po extends Model
{
  protected $fillable = [
    "u_id",
    "companyId",
    "selectMerchant",
    "inputMerchant",
    "poType",
    "status",
    "is_request",
    "poPurpose",
    "poMaterials",
    "poProject",
    "poProjectLocation",
    "poValue",
    "poCostSheet",
    "poInvoice",
    "poEMInvoice",
    "poPod",
    "poJobStatus",
    "poFinanceStatus",
    "poCompanyPo",
    "poCancelled",
    "poCancelledBy",
    "poNotes",
    "poCompleted",
    "updated_at",
    "poNumber",
    "alt_merchant_name",
    "alt_merchant_contact",
    "alt_merchant_email",
    "contract_id",
    "request_file",
    "actual_value",
    "billable_value_final",
    "billable_date",
    "overlimit_value",
    "created_by_id",
  ];

  protected $dispatchesEvents = [
    "created" => CheckOrderLimit::class,
  ];

  public function createdBy()
  {
    return $this->belongsTo(User::class, "created_by_id");
  }

  public static function getRequestCount($number = null, $user = null)
  {
    $qb = static::query()->where("is_request", 1);

    if (!empty($number)) {
      $qb = $qb->where("poNumber", $number);
    }

    if (!empty($user)) {
      $qb = $qb
        ->where("u_id", $user->id)
        ->whereNot("poCompleted", 1)
        ->whereNot("poCancelled", 1)
        ->groupBy("poNumber")
        ->select(["poNumber"]);
    }

    return $qb->get()->count();
  }

  public static function getOrdersCount($number = null, $user = null)
  {
    $qb = static::query()->whereNot("is_request", 1);

    if (!empty($number)) {
      $qb = $qb->where("poNumber", $number);
    }

    if (!empty($user)) {
      $qb = $qb
        ->where("u_id", $user->id)
        ->whereNot("poCompleted", 1)
        ->whereNot("poCancelled", 1)
        ->groupBy("poNumber")
        ->select(["poNumber"]);
    }

    return $qb->get()->count();
  }

  public static function getCompletedCount($number = null, $user = null)
  {
    $qb = static::query();

    if (!empty($number)) {
      $qb = $qb->where("poNumber", $number);
    }

    if (!empty($user)) {
      $qb = $qb
        ->where("u_id", $user->id)
        ->groupBy("poNumber")
        ->select(["poNumber"]);
    }

    $qb = $qb->where("poCompleted", 1);

    return $qb->get()->count();
  }

  public static function getApprovedRequestsCount($number = null, $user = null)
  {
    $qb = static::query()->where("is_request", 1);

    if (!empty($number)) {
      $qb = $qb->where("poNumber", $number);
    }

    if (!empty($user)) {
      $qb = $qb
        ->where("u_id", $user->id)
        ->select(["poNumber"])
        ->groupBy("poNumber");
    }

    return $qb
      ->whereNotNull("poValue")
      ->whereNotNull("billable_value_final")
      ->whereNotNull("request_file")
      ->get()
      ->count();
  }

  public function merchant()
  {
    return $this->belongsTo(Merchant::class, "selectMerchant");
  }

  public function user()
  {
    return $this->belongsTo(User::class, "u_id");
  }

  public function contract()
  {
    return $this->belongsTo(Company::class, "companyId");
  }

  public function history()
  {
    return $this->hasMany(PoHistory::class, "po_id")->orderBy("id", "desc");
  }

  protected static function getRequestsQB($number)
  {
    return static::query()
      ->where("poNumber", $number)
      ->where("is_request", 1);
  }

  public static function getRequestsByNumber($number)
  {
    return static::getRequestsQB($number)->get();
  }

  public static function updateRequests($number, $fields)
  {
    return static::getRequestsQB($number)->update($fields);
  }

  public function getRequestCountAttribute()
  {
    if ($this->is_request) {
      return [
        "total" => static::getRequestCount($this->poNumber),
        "admin_approved" => static::getApprovedRequestsCount($this->poNumber),
      ];
    } else {
      return [];
    }
  }

  public static function setGroupStatus($number, $status)
  {
    $models = Po::where("poNumber", $number)->get();

    $models->each(function ($model) use ($status) {
      Log::info("update statuses: {$status}");
      $model->status = $status;
      $model->update();
    });
  }

  protected static function boot()
  {
    parent::boot();

    static::updating(function ($model) {
      $user = Auth::user();
      if (
        $model->isDirty("billable_value_final" && $model->billable_value_final)
      ) {
        $model->billable_date = now();
        if ($model->is_request) {
        }

        PoHistory::create([
          "action" => "Seted Billable Value",
          "data" => null,
          "user_id" => $user->id,
          "po_id" => $model->id,
        ]);
      }

      static::updated(function ($model) {
        if ($model->isDirty("billable_value_final") && $model->is_request) {
          Log::info("Po updated statuses rule");
          Po::setGroupStatus($model->poNumber, "Pending Approval");
        }
      });

      if (
        $model->isDirty("poCancelled") &&
        $model->isDirty("poCompletedStatus")
      ) {
        PoHistory::create([
          "action" => "Cancelled PO",
          "data" => null,
          "user_id" => $user->id,
          "po_id" => $model->id,
        ]);
      }
      if ($model->isDirty("poPod") && !empty($model->poPod)) {
        PoHistory::create([
          "action" => "Uploaded POD",
          "data" => $model->poPod,
          "user_id" => $user->id,
          "po_id" => $model->id,
        ]);
      }
      if ($model->isDirty("poPod") && empty($model->poPod)) {
        PoHistory::create([
          "action" => "Deleted POD",
          "data" => null,
          "user_id" => $user->id,
          "po_id" => $model->id,
        ]);
      }
    });

    static::created(function ($model) {
      $user = Auth::user();
      PoHistory::create([
        "action" => "Created PO",
        "data" => null,
        "user_id" => $user->id,
        "po_id" => $model->id,
      ]);

      if ($user->id !== $model->u_id) {
        Notification::create([
          "title" => "Breeze Order - #EM-{$model->id}",
          "content" => "Your PO for {$model->merchant->merchantName} is Ready – [EM-{$model->id}]. Click here to open PO and use it for collection. Please ensure your goods are ready and available before proceeding to the Supplier.",
          "active" => 0,
          "user_id" => $model->u_id,
          "type" => "po_created_anothe_user",
          "data" => $model->id,
        ]);
      }
    });
  }
}
