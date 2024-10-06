<?php

namespace App\Http\Controllers\Traits;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\File\Exception\AccessDeniedException;

trait UserControllerTrait
{
  public function userList(Request $request)
  {
    $accessLevel = Auth::user()->accessLevel;

    $search = $request->get("search");

    $query = User::query();
    switch ($accessLevel) {
      case "2":
      case "1":
        if (!empty($search)) {
          $query = $query
            ->select("users.*", "companies.companyName")
            ->leftJoin("companies", "users.companyId", "=", "companies.id")
            ->leftJoin(
              "companies_users",
              "users.id",
              "=",
              "companies_users.user_id"
            )
            ->leftJoin(
              "companies as c2",
              "companies_users.company_id",
              "=",
              "c2.id"
            )
            ->where(function ($query) use ($search) {
              $query
                ->where("users.name", "LIKE", "%$search%")
                ->orWhere("companies.companyName", "LIKE", "%$search%")
                ->orWhere("users.email", "LIKE", "%$search%")
                ->orWhere("c2.companyName", "LIKE", "%$search%");
            });
        }
        break;
      case "3":
        $query = $query->where("companyId", "=", Auth::user()->companyId);
        break;
    }

    return [
      $query->orderBy("name", "asc")->paginate(empty($search) ? 25 : 1000),
      $search,
    ];
  }

  public function remove($id)
  {
    User::destroy($id);
  }

  public function updateStatus($id, $status)
  {
    User::where("id", $id)->update(["disabled" => $status]);

    return User::find($id);
  }

  public function updateUser($id, Request $request)
  {
    $input = $request->validate([
      "name" => "required",
      "email" => "required|email",
      "accessLevel" => "required",
      "permissions" => "nullable",
      'phone' => 'nullable',
      'country' => 'nullable',
      "companyId" => "nullable",
      "merchant_id" => "nullable",
      "merchant_parent_id" => "nullable",
      "price_limit" => "nullable",
      "phoneCode" => 'nullable'
      // 'password' => 'required|min:6|confirmed'
    ]);

    $editUser = User::findOrFail($id);

    $newPassword = $request->get("password");

    if (!empty($newPassword)) {
      $input["password"] = Hash::make($request["password"]);
    }

    if (empty($input["permissions"])) {
      unset($input["permissions"]);
    }
    $contracts = $request->get("contracts");
    $ids = [];
    for ($i = 0; $i < count($contracts); $i++) {
      $ids[] = $contracts[$i]["value"];
    }
    $editUser->companies()->sync($ids);
    $editUser->fill($input);
    $editUser->update();

    return $editUser;
  }
}
