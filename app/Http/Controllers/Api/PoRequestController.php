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
use App\Services\Filters\Po\PoFilter;

class PoRequestController extends Controller
{
  use PoControllerTrait;

  private PoFilter $poFilter;

  public function __construct(
    AccessCheckInterface $accessCheckService,
    PoFilter $poFilter
  ) {
    $this->accessCheckService = $accessCheckService;
    $this->poFilter = $poFilter;
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

  public function myRequests()
  {
    $query = Po::query();
    $this->poFilter
      ->setQuery($query)
      ->filterOnlyReequests()
      ->filterByOwner()
      ->filterByDates()
      ->filterByClientStatuses()
      ->filterSeachByText()
      ->orderBy("id", "desc");
    return $this->groupRequests($query->get());
  }

  public function adminRequests()
  {
    $query = Po::query();
    $this->poFilter
      ->setQuery($query)
      ->filterOnlyReequests()
      ->filterByDates()
      ->filterByAdminStatuses()
      ->filterSeachByText()
      ->orderBy("id", "desc");
    return $this->groupRequests($query->get());
  }

  public function approve($id)
  {
    $po = $this->getSingle($id);

    $number = $po->poNumber;

    $parts = explode("-", $number);

    $po->is_request = 0;
    $po->status = "New Order";
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

    return PoResource::make($po);
  }
}
