<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserControllerTrait;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    use UserControllerTrait;

    public function index(Request $request)
    {
        list($users) = $this->userList($request);

        return UserResource::collection($users);
    }

    public function account()
    {
        return UserResource::make(Auth::user());
    }

    public function removeUser($id)
    {
        $this->remove($id);

        return response()->json([]);
    }

    public function disableUser($id)
    {
        $user = $this->updateStatus($id, '1');

        return UserResource::make($user);
    }

    public function enableUser($id)
    {
        $user = $this->updateStatus($id, '');

        return UserResource::make($user);
    }

    public function update($id, Request $request)
    {
        $user = $this->updateUser($id,$request);

        return UserResource::make($user);
    }
}
