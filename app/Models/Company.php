<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'companyName',
        'companyPhone',
        'companyFax',
        'companyContact',
        'companyContactEmail',
        'companyAddress',
        'disabled',
        'agreed_rebate',
        'agreed_markup',
    ];


    public function getRootCompanyAttribute(){
		$company = Company::select('companies.*')->where('id', $this->parent_id)->first();
        return $company;
    }
}
