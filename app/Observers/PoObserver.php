<?php

namespace App\Observers;

use App\Models\Po;
use App\Models\PoHistory;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use App\Services\Firebase\FirebaseMessagesService;

class PoObserver
{
  private $firebaseMessagesService;

  public function __construct(FirebaseMessagesService $firebaseMessagesService)
  {
    $this->firebaseMessagesService = $firebaseMessagesService;
  }

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
      $merchant = $po->merchant
          ? $po->merchant->merchantName
          : $po->alt_merchant_name;

      Notification::create([
        "title" => "Breeze Order - #EM-{$po->id}",
        "content" => "Your PO for {$merchant} is Ready – [EM-{$po->id}]. Click here to open PO and use it for collection. Please ensure your goods are ready and available before proceeding to the Supplier.",
        "active" => 0,
        "user_id" => $po->u_id,
        "type" => "po_created_another_user",
        "data" => $po->id,
      ]);

      $this->firebaseMessagesService->sendNotification(
        "test send",
        "test description",
        "dX_rHplBT56hB7sQLzrEeX:APA91bHwK8p26Ah6R3Kpo2ISKzqUpTsW_IB93tbPU8-KLRNiGw-mekWVF2vuPpsCBeBZJwp3yO7EVM0I_51rG150Njsg2v5q5x6qeJ_wLO6Ox23IcU1OyKA"
      );
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

    if ($po->isDirty("is_request") && !$po->is_request) {
      PoHistory::create([
        "action" => "Quote Accepted",
        "data" => $po->request_file,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
      PoHistory::create([
        "action" => "Created PO",
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
