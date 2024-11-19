<?php

namespace App\Observers;

use App\Models\Po;
use App\Models\PoHistory;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class PoObserver
{
  /**
   * Handle the Po "created" event.
   */
  public function created(Po $po): void
  {
    $user = Auth::user();
    PoHistory::create([
      "action" => "Created PO",
      "data" => null,
      "user_id" => $user->id,
      "po_id" => $po->id,
    ]);

    if ($user->id !== $po->u_id) {
      Notification::create([
        "title" => "Breeze Order - #EM-{$po->id}",
        "content" => "Your PO for {$po->merchant->merchantName} is Ready – [EM-{$po->id}]. Click here to open PO and use it for collection. Please ensure your goods are ready and available before proceeding to the Supplier.",
        "active" => 0,
        "user_id" => $po->u_id,
        "type" => "po_created_another_user",
        "data" => $po->id,
      ]);
    }
  }

  /**
   * Handle the Po "updated" event.
   */
  public function updated(Po $po): void
  {
    $user = Auth::user();
    if ($po->isDirty("billable_value_final" && $po->billable_value_final)) {
      $po->billable_date = now();
      if ($po->is_request) {
      }

      PoHistory::create([
        "action" => "Seted Billable Value",
        "data" => null,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
    }

    if ($po->isDirty("billable_value_final") && $po->is_request) {
      Po::setGroupStatus($po->poNumber, "Pending Approval");
    }

    if ($po->isDirty("poPod") && !empty($po->poPod)) {
      PoHistory::create([
        "action" => "Uploaded POD",
        "data" => $po->poPod,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
    }
    if ($po->isDirty("poPod") && empty($po->poPod)) {
      PoHistory::create([
        "action" => "Deleted POD",
        "data" => null,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
    }

    if (!$po->is_request && $po->isDirty("actual_value")) {
      PoHistory::create([
        "action" => "Changed Supplier Cost",
        "data" => null,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
    }

    if (!$po->is_request && $po->isDirty("status")) {
      PoHistory::create([
        "action" => "Changed Status to {$po->status}",
        "data" => null,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
    }
  }

  /**
   * Handle the Po "deleted" event.
   */
  public function deleted(Po $po): void
  {
    //
  }

  /**
   * Handle the Merchant "restored" event.
   */
  public function restored(Po $po): void
  {
    //
  }

  /**
   * Handle the Merchant "force deleted" event.
   */
  public function forceDeleted(Po $po): void
  {
    //
  }
}
