<?php
namespace App\Http\Controllers\Api\ExportReport;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

abstract class ExportController extends Controller
{
  protected function exportResponse($data, string $exportClass)
  {
    $fileName =
      now()->format("y/m") .
      "/export-" .
      now()->format("y-m-d-m-Y-H-i-s") .
      ".csv";

    Excel::store(
      new $exportClass($data),
      $fileName,
      "public",
      \Maatwebsite\Excel\Excel::CSV
    );

    return response()->json([
      "url" => Storage::disk("public")->url($fileName),
    ]);
  }
}
