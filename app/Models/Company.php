<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Events\CompanyCreated;

class Company extends Model
{
  protected $dispatchesEvents = [
    "created" => CompanyCreated::class,
  ];

  protected $fillable = [
    "companyName",
    "companyPhone",
    "companyFax",
    "companyContact",
    "companyContactEmail",
    "companyAddress",
    "disabled",
    "agreed_rebate",
    "agreed_markup",
    "parent_id",
    "mark_up",
    "limit_4_role",
    "limit_5_role",
    "limit_6_role",
    "url",
    "id",
    "companyContactPhone",
    "phoneCode",
    "companyContactPhoneCode",
  ];

  public function getRootCompanyAttribute()
  {
    $company = Company::select("companies.*")
      ->where("id", $this->parent_id)
      ->first();
    return $company;
  }

  public function parent()
  {
    return $this->belongsTo(self::class, "parent_id");
  }

  public function lockout()
  {
    return $this->belongsToMany(Merchant::class, "lockout_companies_merchants");
  }
}
