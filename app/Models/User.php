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
    "name",
    "email",
    "companyId",
    "phone",
    "accessLevel",
    "emailNotify",
    "password",
    "permissions",
    "setting_push_notification",
    "setting_email_notification",
    "merchant_id",
    "merchant_parent_id",
  ];

  /**
   * The attributes that should be hidden for arrays.
   *
   * @var array
   */
  protected $hidden = ["password", "remember_token"];

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
    "email_verified_at" => "datetime",
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

    $this->attributes["permissions"] = json_encode($map);
    $this->permsJson = $map;
  }

  public function hasPermission(Permission $permission)
  {
    return !empty($this->permissions[$permission->value]) &&
      $this->permissions[$permission->value];
  }

  public function company()
  {
    return $this->belongsTo(Company::class, "companyId");
  }

  public function companies()
  {
    return $this->belongsToMany(Company::class, "companies_users");
  }

  public function settings()
  {
    return $this->hasMany(UserSetting::class);
  }

  public function getOrderLimitAttribute()
  {
    if (!!$this->price_limit) {
      return $this->price_limit;
    } elseif ($this->accessLevel == 4) {
      return $this->company->limit_4_role;
    } elseif ($this->accessLevel == 5) {
      return $this->company->limit_5_role;
    } elseif ($this->accessLevel == 6) {
      return $this->company->limit_6_role;
    } elseif ($this->accessLevel == 7) {
      return $this->company->limit_7_role;
    } else {
      return null;
    }
  }

  public function pos()
  {
    return $this->hasMany(Po::class, "u_id")
      ->where("is_request", 0)
      ->orderBy("id", "desc");
  }

  public static function getActiveUsersQB()
  {
    return static::query()->whereNot("disabled", "1");
  }

  public static function getUsersForNotification()
  {
    return static::getActiveUsersQB()
      ->where("setting_push_notification", 1)
      ->select("users.id")
      ->get()
      ->pluck("id");
  }
}
