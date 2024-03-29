<?php

namespace App\Models;

use App\Enums\Permission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $permsJson = [];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'companyId', 'phone', 'accessLevel', 'emailNotify', 'password', 'permissions',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getPermissionsAttribute($permissions)
    {
        if (empty($this->permsJson)) {
            $json = json_decode($permissions, true);
            $this->permsJson = is_array($json) ? $json : [];
        }

        return $this->permsJson;
    }

    public function setPermissionsAttribute(array $perms)
    {
        $map = [];
        foreach ($perms as $perm) {
            $map[$perm] = true;
        }

        $this->attributes['permissions'] = json_encode($map);
        $this->permsJson = $map;
    }

    public function hasPermission(Permission $permission)
    {
        return !empty($this->permissions[$permission->value]) && $this->permissions[$permission->value];
    }
}
