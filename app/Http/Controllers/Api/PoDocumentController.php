<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PoDocument;
use Exception;
use Illuminate\Http\Request;

class PoDocumentController extends Controller
{
  public function store(Request $request)
  {
    try {
      $request->validate([
        "document" => "required",
        "po_id" => "required",
      ]);

      PoDocument::create($request->all());
      return response()->json(["success" => true]);
    } catch (Exception $exception) {
      Log::info($exception);
      return response()->json(["success" => false]);
    }
  }
}
