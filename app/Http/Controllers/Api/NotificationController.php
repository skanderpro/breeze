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

class NotificationController extends Controller
{
    public function index(Request $request)
    {
         $query = Notification::query()
            ->where('user_id', Auth::id());

         $search = $request->input('search');
         if (!empty($search)) {
             $query = $query->where(function ($q) use ($search) {
                 $q->where('title', 'like', '%' . $search . '%')
                     ->orWhere('content', 'like', '%' . $search . '%');
             });
         }

         $notifications = $query->orderBy('id', 'desc')->get();

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

    public function sendToAll(Request $request)
    {
        $payload = $request->validate([
            'title' => 'required',
            'content' => 'required',
        ]);

        $payload += [
            'created_at' => now(),
            'updated_at' => now(),
        ];

        $userIds = User::getUsersForNotification();
        $notificationPayload = [];

        foreach ($userIds as $userId) {
            $notificationPayload[] = $payload + [
                    'user_id' => $userId,
                    'active' => 1,
                ];
        }

        Notification::query()->insert($notificationPayload);

        return response()->json([]);
    }
}
