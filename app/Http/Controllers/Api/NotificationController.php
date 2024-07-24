<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Models\Notification;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::query()
            ->where('user_id', Auth::id())
            ->paginate();

        return NotificationResource::collection($notifications);
    }

    public function markAsRead(Notification $notification)
    {
        if ($notification->user_id != Auth::id()) {
            return response()->json([], Response::HTTP_FORBIDDEN);
        }

        $notification->read = true;
        $notification->save();

        return response([
            'notification' => NotificationResource::make($notification),
        ]);
    }

    public function removeRead()
    {
        Notification::query()
            ->where('user_id', Auth::id())
            ->where('read', true)
            ->delete();

        return response()->json([]);
    }

    public function getBanner()
    {
        $banner = Setting::get('site_banner', '');

        return response()->json([
            'data' => [
                'banner' => $banner,
            ],
        ]);
    }

    public function setBanner(Request $request)
    {
        $request->validate([
            'banner' => 'required',
        ]);

        $banner = $request->input('banner');
        Setting::set('site_banner', $banner);

        return response()->json([
            'data' => [
                'banner' => $banner,
            ]
        ]);
    }
}
