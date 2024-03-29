<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'companyId', 'phone', 'accessLevel', 'emailNotify', 'password',
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

    public function company(){
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function companies(){
        return $this->belongsToMany(Company::class,'companies_users');
    }

    public function getOrderLimitAttribute(){
        if(!!$this->price_limit){
            return $this->price_limit;
        } elseif ($this->accessLevel == 3) {
            return $this->company->limit_3_role;
        } elseif ($this->accessLevel == 4) {
            return $this->company->limit_4_role;
        } else {
            return null;
        }

    }
}
