<?php

namespace App\Services;


use App\Enums\Permission;
use App\Models\User;
use Illuminate\Support\Facades\Gate;

class GateAccessService implements AccessCheckInterface
{

    function defineAccess()
    {
        Gate::define(Permission::PO_READ_LIST_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::MENU_READ_ADMIN->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::PO_READ_USERS_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::USERS_READ_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::PO_EXPORT_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::PO_READ_LIST_COMPANY_ALL->value, function (User $user) {
            return $user->accessLevel == '2';
        });
        Gate::define(Permission::MERCHANT_MANAGE_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::NOTIFICATION_MANAGE_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::COMPANY_MANAGE_ALL->value, function (User $user) {
            return $user->accessLevel == '1';
        });
        Gate::define(Permission::COMPANY_MANAGE->value, function (User $user) {
            return $user->accessLevel == '2' || $user->accessLevel == '1';
        });
        Gate::define(Permission::USERS_READ_COMPANY->value, function (User $user) {
            return $user->accessLevel == '2';
        });
        Gate::define(Permission::PO_EXPORT_COMPANY->value, function (User $user) {
            return $user->accessLevel == '2';
        });
        Gate::define(Permission::PO_READ_LIST_COMPANY->value, function (User $user) {
            return $user->accessLevel == '3';
        });
        Gate::define(Permission::PO_EXPORT_CLIENT->value, function (User $user) {
            return $user->accessLevel == '3';
        });
    }

    function check($permission, $params = [])
    {
        return Gate::allows($permission, $params);
    }
}
