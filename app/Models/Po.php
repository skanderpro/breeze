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
        "contract_id",
        'request_file',
        'billable_value',
    ];

    public static function getRequestCount($number = null)
    {
        $qb = static::query()
            ->where('is_request', 1);

        if (!empty($number)) {
            $qb = $qb->where('poNumber', $number);
        }

        return $qb->count();
    }

    public static function getApprovedRequestsCount($number = null)
    {
        $qb = static::query()
            ->where('is_request', 1);

        if (!empty($number)) {
            $qb = $qb->where('poNumber', $number);
        }

        return $qb
            ->whereNotNull('poValue')
            ->whereNotNull('billable_value')
            ->whereNotNull('request_file')
            ->count();
    }

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
		if($this->is_request){
			if(static::getApprovedRequestsCount($this->poNumber)){
				$statuses[] = "Pending";
			} else {
				$statuses[] = "Awaiting";
			}
					
		} else {
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
		}
		
		

		return end($statuses);
	}

    protected static function getRequestsQB($number)
    {
        return static::query()
            ->where('poNumber', $number)
            ->where('is_request', 1);
    }

    public static function getRequestsByNumber($number)
    {
        return static::getRequestsQB($number)
            ->get();
    }

    public static function updateRequests($number, $fields)
    {
        return static::getRequestsQB($number)
            ->update($fields);
    }
}
