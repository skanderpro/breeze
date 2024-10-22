<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PoNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PoNoteController extends Controller
{
  public function store(Request $request)
  {
    try {
      $request->validate([
        "note" => "required",
        "po_id" => "required",
      ]);

      PoNote::create($request->all());
      return response()->json(["success" => true]);
    } catch (Exception $exception) {
      Log::info($exception);
      return response()->json(["success" => false]);
    }
  }
}
