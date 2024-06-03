<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Po extends Model
{
    protected $fillable = [
        'u_id',
        'companyId',
        'selectMerchant',
        'inputMerchant',
        'poType',
        'status',
        'is_request',
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
		"alt_merchant_email",
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

	public function getStatusAttribute(){
		$statuses = [];
		if(Auth::user()->id != $this->u_id && !$this->poVisitStatus){
			$statuses[] = 'Unused';
		}
		if(Auth::user()->id == $this->u_id || $this->poVisitStatus){
			$statuses[] = 'POD Required';
		}
		if(!!$this->poPod){
			$statuses[] = 'Completed';
		}
		if($this->poCancelled){
			$statuses[] = 'Cancelled';
		}
		return end($statuses);
	}
}
