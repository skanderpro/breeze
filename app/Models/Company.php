<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        'companyName', 'companyPhone', 'companyFax', 'companyContact', 'companyContactEmail', 'companyAddress',
    ];
	
	
    public function getRootCompanyAttribute(){
		$company = Company::select('companies.*')->where('id', $this->parent_id)->first();
        return $company;
    }
}
