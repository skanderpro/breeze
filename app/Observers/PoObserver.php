<?php

namespace App\Observers;

use App\Models\Po;
use App\Models\PoHistory;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Http\Resources\PoResource;
use App\Services\Firebase\FirebaseMessagesService;
use App\Mail\PoRequestUser;

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
      $poUser = $po->user;
      $devices = $poUser->devices;

      for ($i = 0; $i < count($devices); $i++) {
        $this->firebaseMessagesService->sendNotification(
          "Breeze Purchase Order #" . $po->id,
          "A PO has been created for you",
          $devices[$i]->device
        );
      }
    }
  }

  /**
   * Handle the Po "updated" event.
   */
  public function updated(Po $po): void
  {
    $user = Auth::user();
    Log::info("billable_value_final " . $po->billable_value_final);
    Log::info("isDirty" . $po->isDirty("billable_value_final"));
    // Log::info("status " . $po->status);
    if ($po->isDirty("billable_value_final") && $po->billable_value_final) {
      if ($po->is_request) {
      }

      PoHistory::create([
        "action" => "Seted Billable Value",
        "data" => null,
        "user_id" => $user->id,
        "po_id" => $po->id,
      ]);
    }

    if (
      $po->isDirty("billable_value_final") &&
      $po->isDirty("request_file") &&
      $po->is_request
    ) {
      Po::setGroupStatus($po->poNumber, "Pending Approval");
      Notification::create([
        "type" => "po_request",
        "title" => "Breeze Quotations - #{$po->poNumber}",
        "content" => "Order request was updated",
        "active" => true,
        "data" => json_encode(["po" => PoResource::make($po)]),
        "user_id" => $po->user->id,
      ]);

      if ($po->user->setting_push_notification) {
        $poUser = $po->user;
        $devices = $poUser->devices;

        for ($i = 0; $i < count($devices); $i++) {
          $this->firebaseMessagesService->sendNotification(
            "Breeze Quote Request #" . $po->id,
            "You’ve received a quote",
            $devices[$i]->device
          );
        }
      }
      if ($po->user->setting_email_notification) {
        Mail::to($po->user->email)->send(new PoRequestUser($po));
      }
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

    // Log::info("is_request " . $po->is_request);
    // Log::info("request file " . $po->isDirty("request_file"));
    // Log::info("status " . $po->status);
  }

  /**
   * Handle the Po "updating" event.
   */
  public function updating(Po $po): void
  {
    if ($po->isDirty("poVisitStatus") && $po->poVisitStatus) {
      $po->client_status = "POD Required";
    }

    if ($po->isDirty("poPod")) {
      $po->client_status = "Complete";
    }

    if ($po->isDirty("status") && $po->status === "Cancelled") {
      $po->client_status = "Cancelled";
    }
    if ($po->isDirty("billable_value_final") && $po->billable_value_final) {
      $po->billable_date = now();
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
