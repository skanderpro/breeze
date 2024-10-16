<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\PoControllerTrait;
use App\Http\Resources\PoResource;
use App\Mail\PoRequestUser;
use App\Models\Notification;
use App\Models\Po;
use App\Models\User;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PoRequestController extends Controller
{
  use PoControllerTrait;

  public function __construct(AccessCheckInterface $accessCheckService)
  {
    $this->accessCheckService = $accessCheckService;
  }

  protected function groupRequests($poRequests)
  {
    return PoResource::collection($poRequests)->collection->groupBy("poNumber");
  }

  public function storePo(Request $request)
  {
    $createdPo = $this->storeRequests($request);

    return $this->groupRequests($createdPo);
  }

  public function getCounts()
  {
    return response()->json([
      "total" => Po::getRequestCount(),
      "admin_approved" => Po::getApprovedRequestsCount(),
    ]);
  }

  public function getSingleCounts($number)
  {
    return response()->json([
      "total" => Po::getRequestCount($number),
      "admin_approved" => Po::getApprovedRequestsCount($number),
    ]);
  }

  public function uploadRequestFile($poNumber, Request $request)
  {
    $file = $request->file("file");
    if (!$file) {
      return response()->json([
        "error" => "File is required",
      ]);
    }

    $path = $file->store("files", "public");

    Po::updateRequests($poNumber, [
      "request_file" => $path,
    ]);

    return $this->groupRequests(Po::getRequestsByNumber($poNumber));
  }

  public function index(Request $request)
  {
    $input = $request->all();
    $data = $this->getAdminRequestList($input);

    return $this->groupRequests($data);
  }

  public function approve($id)
  {
    $po = $this->getSingle($id);

    $number = $po->poNumber;

    $parts = explode("-", $number);

    $po->is_request = 0;
    $po->poNumber = "EM-{$parts[1]}";
    $po->save();

    Po::query()
      ->where("poNumber", $number)
      ->delete();

    return PoResource::make($po);
  }

  public function show($id)
  {
    $po = $this->getSingle($id);

    return PoResource::make($po);
  }

  public function update($id, Request $request)
  {
    $po = $this->updadePo($id, $request);

    return PoResource::make($po);
  }

  public function setStatus(Po $po, Request $request)
  {
    $request->validate([
      "status" => "required",
    ]);

    $po->status = $request->input("status");
    $po->save();

    return PoResource::make($po);
  }

  public function getUserCounters(User $user)
  {
    $user = Auth::user();

    return response()->json([
      "requests" => Po::getRequestCount(null, $user),
      "completed" => Po::getCompletedCount(null, $user),
      "approved" => Po::getApprovedRequestsCount(null, $user),
    ]);
  }

  public function cancel($id, Request $request)
  {
    $input = $request->all();

    $po = $this->cancelPo($id, $input["status"]);

    return PoResource::make($po);
  }

  public function getByNumber($number)
  {
    $pos = $this->getRequestsByNumber($number);
    return PoResource::collection($pos);
  }

  public function uploadFile(Request $request)
  {
    try {
      $file = $this->uploadRequestFileMethod($request);
      return $file;
    } catch (\Exception $exception) {
      return $exception;
    }
  }

  public function uploadRequest(Po $po, Request $request)
  {
    $request->validate([
      "poValue" => "required",
      "actual_value" => "required",
      "billable_value_final" => "required",
      "request_file" => "required",
    ]);

    $po->fill($request->all());
    $po->update();

    try {
      if ($po->user->setting_push_notification) {
        Notification::create([
          "type" => "po_request",
          "title" => "Breeze Quotations - #{$po->poNumber}",
          "content" => "Order request was updated",
          "active" => true,
          "data" => json_encode(["po" => PoResource::make($po)]),
          "user_id" => $po->user->id,
        ]);
      }
      if ($po->user->setting_email_notification) {
        Mail::to($po->user->email)->send(new PoRequestUser($po));
      }
    } catch (\Exception $e) {
      Log::error("email send error", [
        "e" => $e,
        "payload" => $request->all(),
      ]);
    }

    return PoResource::make($po);
  }
}
