<?php

namespace App\Services;


use App\Enums\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class GateAccessService implements AccessCheckInterface
{

    function defineAccess()
    {
        foreach (Permission::cases() as $permission) {
            Gate::define($permission->value, function (User $user) use ($permission) {

                return $user->hasPermission($permission);
            });
        }
    }

    function check($permission, $params = [])
    {
        return Gate::allows($permission, $params);
    }
}
