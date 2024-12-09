<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class BannerController extends Controller
{
  public function show()
  {
    $existingBanner = Setting::get("site_banner", "[]");
    $existingBanner = json_decode($existingBanner, true);
    if (!is_array($existingBanner)) {
      $existingBanner = [];
    }

    foreach ($existingBanner as $key => $val) {
      $existingBanner[$key] = Storage::disk("public")->url($val);
    }

    return response()->json([
      "data" => $existingBanner,
    ]);
  }

  public function store(Request $request)
  {
    $existingBanner = Setting::get("site_banner", "[]");
    $existingBanner = json_decode($existingBanner, true);
    if (!is_array($existingBanner)) {
      $existingBanner = [];
    }

    $destinationPath = "uploads/";

    $sizes = ["lg", "md", "sm"];
    foreach ($sizes as $size) {
      if ($request->hasFile($size)) {
        $tmpName = Uuid::uuid4();
        $filename = "{$tmpName}";
        $request
          ->file($size)
          ->move(Storage::disk("public")->path($destinationPath), $filename);
        $existingBanner[$size] = "/{$destinationPath}{$filename}";
      }
    }

    Setting::set("site_banner", json_encode($existingBanner));

    foreach ($existingBanner as $key => $val) {
      $existingBanner[$key] = Storage::disk("public")->url($val);
    }

    return response()->json([
      "data" => $existingBanner,
    ]);
  }
}
