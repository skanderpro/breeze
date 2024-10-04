<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Ramsey\Uuid\Uuid;

class NotificationController extends Controller
{
  public function index(Request $request)
  {
    $query = Notification::query()->where("user_id", Auth::id());

    $search = $request->input("search");
    if (!empty($search)) {
      $query = $query->where(function ($q) use ($search) {
        $q->where("title", "like", "%" . $search . "%")->orWhere(
          "content",
          "like",
          "%" . $search . "%"
        );
      });
    }
    $filter = $request->input("filter");
    if (!empty($filter["types"])) {
      $query = $query->whereIn("type", $filter["types"]);
    }
    if (!empty($filter["read"])) {
      $query = $query->whereIn("read", $filter["read"]);
    }

    $notifications = $query
      ->orderBy("id", "desc")
      ->limit(10)
      ->get();

    return NotificationResource::collection($notifications);
  }

  public function countUnread()
  {
    $query = Notification::query()
      ->where("read", 0)
      ->where("user_id", Auth::id())
      ->count();

    return response()->json(["numbers" => $query]);
  }

  public function markAsRead(Notification $notification)
  {
    if ($notification->user_id != Auth::id()) {
      return response()->json([], Response::HTTP_FORBIDDEN);
    }

    $notification->read = true;
    $notification->save();

    return response([
      "notification" => NotificationResource::make($notification),
    ]);
  }

  public function removeRead()
  {
    Notification::query()
      ->where("user_id", Auth::id())
      ->where("read", true)
      ->delete();

    return response()->json([]);
  }

  public function getBanner()
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

  public function setBanner(Request $request)
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

  public function sendToAll(Request $request)
  {
    $payload = $request->validate([
      "title" => "required",
      "content" => "required",
    ]);

    $payload += [
      "created_at" => now(),
      "updated_at" => now(),
    ];

    $userIds = User::getUsersForNotification();
    $notificationPayload = [];

    foreach ($userIds as $userId) {
      $notificationPayload[] = $payload + [
        "user_id" => $userId,
        "active" => 1,
      ];
    }

    Notification::query()->insert($notificationPayload);

    return response()->json([]);
  }
}
