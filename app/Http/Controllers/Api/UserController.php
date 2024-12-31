<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\UserControllerTrait;
use App\Http\Resources\CompanyResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\UserSettingResource;
use App\Mail\NewPasswordMail;
use App\Models\Company;
use App\Models\User;
use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Ramsey\Uuid\Uuid;

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
    $user = $this->updateStatus($id, "1");

    return UserResource::make($user);
  }

  public function enableUser($id)
  {
    $user = $this->updateStatus($id, "");

    return UserResource::make($user);
  }

  public function update($id, Request $request)
  {
    $user = $this->updateUser($id, $request);

    return UserResource::make($user);
  }

  public function userSettings(User $user)
  {
    return UserSettingResource::collection($user->settings);
  }

  public function updateUserSettings(User $user, Request $request)
  {
    $request->validate([
      "setting_email_notification" => "required",
      "setting_push_notification" => "required",
    ]);

    $user->fill(
      $request->only([
        "setting_email_notification",
        "setting_push_notification",
      ])
    );
    $user->save();

    return UserResource::make($user);
  }

  public function toggle(User $user)
  {
    $user->disabled = (int) $user->disabled ? "" : "1";
    $user->save();

    return UserResource::make($user);
  }

  protected function createPassword()
  {
    $password = Uuid::uuid4()->toString();
    $password = str_replace("-", "", $password);

    return substr($password, 0, 8);
  }

  public function storeUser(Request $request)
  {
    $input = $request->validate([
      "name" => "required",
      "email" => "required|email",
      "accessLevel" => "required",
      "permissions" => "nullable",
      "country" => "nullable",
      "price_limit" => "nullable",
      "phone" => "nullable",
      "phoneCode" => "nullable",
      "companyId" => "nullable",
      "merchant_id:" => "nullable",
      "merchant_parent_id" => "nullable",
    ]);

    $password = $this->createPassword();
    $input["password"] = Hash::make($password);

    if (empty($input["permissions"])) {
      unset($input["permissions"]);
    }
    $contracts = $request->get("contracts");
    $user = User::create($input);
    $ids = [];
    for ($i = 0; $i < count($contracts); $i++) {
      $ids[] = $contracts[$i]["value"];
    }
    $user->companies()->sync($ids);

    try {
      Mail::to($user->email)
        ->cc("helpdesk@express-merchants.co.uk")
        ->send(new NewPasswordMail($user->email, $password));
    } catch (\Exception $exception) {
      Log::error($exception->getMessage());
    }

    return UserResource::make($user);
  }

  public function resetPassword(Request $request)
  {
    $payload = $request->validate([
      "email" => "required|email",
    ]);

    $password = $this->createPassword();
    $input = [
      "password" => Hash::make($password),
    ];

    $user = User::where("email", $payload["email"])->first();
    $user->fill($input);
    $user->save();

    try {
      Mail::to($user->email)->send(
        new NewPasswordMail($user->email, $password)
      );
    } catch (\Exception $exception) {
      Log::error($exception->getMessage());
    }

    return response()->json([]);
  }

  public function isEmailUnique($user, $email)
  {
    $userModel = User::find($user);
    if (!$userModel) {
      return response()->json(["isUnique" => true]);
    }

    $userVerify = User::where("email", $email)
      ->where("id", "<>", $user)
      ->first();

    return response()->json(["isUnique" => empty($userVerify)]);
  }
}
