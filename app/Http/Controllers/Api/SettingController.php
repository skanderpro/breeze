<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SettingResource;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        return SettingResource::collection(Setting::all());
    }

    public function show(Setting $setting)
    {
        return new SettingResource($setting);
    }

    public function store(Request $request)
    {
        $request->validate([
            'group' => 'nullable|string',
            'value' => 'nullable|string',
            'key' => 'required|string',
        ]);

        $setting = Setting::create($request->all());

        return new SettingResource($setting);
    }

    public function update(Setting $setting, Request $request)
    {
        $request->validate([
            'group' => 'nullable|string',
            'value' => 'nullable|string',
            'key' => 'required|string',
        ]);

        $setting->fill($request->all());
        $setting->save();

        return new SettingResource($setting);
    }

    public function delete(Setting $setting)
    {
        $setting->delete();

        return response()->json([]);
    }
}
