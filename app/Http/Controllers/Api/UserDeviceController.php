<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserDevice;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserDeviceController extends Controller
{
  public function store(Request $request)
  {
    try {
      $user = Auth::user();
      $input = $request->validate([
        "platform" => "required|string",
        "device" => "required|string",
      ]);
      $input["user_id"] = $user->id;
      UserDevice::updateOrCreate($input, ["device" => $input["device"]]);
      return response()->json(["message" => "Data saved successful!"], 200);
    } catch (Exception $exception) {
      throw new Exception("Save device unsuccessful!");
    }
  }
}
