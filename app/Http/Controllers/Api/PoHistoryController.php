<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PoHistoryResource;
use App\Models\Po;
use App\Models\PoHistory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facade\Log;

class PoHistoryController extends Controller
{
  public function index(Po $po)
  {
    try {
      $latestUploadedPod = PoHistory::where("action", "Uploaded POD")
        ->where("po_id", $po->id)
        ->orderBy("created_at", "desc")
        ->first();
      request()->merge(["latestUploadedPod" => $latestUploadedPod?->id]);
      return PoHistoryResource::collection($po->history);
    } catch (Exception $exception) {
      Log::info($exception);
    }
  }

  public function store(Request $request)
  {
    try {
      $request->validation([
        "action" => "require",
        "data_id" => "require",
        "user_id" => "require",
        "po_id" => "require",
      ]);
      $po = Po::find($request->get("po_id"));
      PoHistory::create($request->all());
      return PoHistoryResource::collection($po->history);
    } catch (Exception $exception) {
      Log::info($exception);
    }
  }
}
