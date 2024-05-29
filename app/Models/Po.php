<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    protected $fillable = [
        'u_id',
        'companyId',
        'selectMerchant',
        'inputMerchant',
        'poType',
        'poPurpose',
        'poMaterials',
        'poProject',
        'poProjectLocation',
        'poValue',
        'poCostSheet',
        'poInvoice',
        'poEMInvoice',
        'poPod',
        'poJobStatus',
        'poFinanceStatus',
        'poCompanyPo',
        'poCancelled',
        'poCancelledBy',
        'poNotes',
        'poCompleted',
        'updated_at',
        'poNumber',
        'alt_merchant_name',
        "alt_merchant_contact",
        "contract_id"
    ];


    public function merchant(){
        return $this->belongsTo(Merchant::class, 'selectMerchant');
    }

	public function user(){
		return $this->belongsTo(User::class,'u_id');
	}

	public function contract(){
		return $this->belongsTo(Company::class,'companyId');
	}
}
