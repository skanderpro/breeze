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

    public static function getRequestCount($number = null, $user = null)
    {
        $qb = static::query()
            ->where('is_request', 1);

        if (!empty($number)) {
            $qb = $qb->where('poNumber', $number);
        }

        if (!empty($user)) {
            $qb = $qb->where('u_id', $user->id)
                ->whereNot('poCompleted', 1)
                ->whereNot('poCancelled', 1)
            ->groupBy('poNumber')
                ->select(['poNumber'])
            ;
        }

        return $qb->get()->count();
    }

    public static function getCompletedCount($number = null, $user = null)
    {
        $qb = static::query();

        if (!empty($number)) {
            $qb = $qb->where('poNumber', $number);
        }

        if (!empty($user)) {
            $qb = $qb->where('u_id', $user->id)
                ->groupBy('poNumber')
            ->select(['poNumber']);
        }

        $qb = $qb->where('poCompleted', 1);

        return $qb->get()->count();
    }

    public static function getApprovedRequestsCount($number = null, $user = null)
    {
        $qb = static::query()
            ->where('is_request', 1);

        if (!empty($number)) {
            $qb = $qb->where('poNumber', $number);
        }

        if (!empty($user)) {
            $qb = $qb->where('u_id', $user->id)
                ->select(['poNumber'])
                ->groupBy('poNumber');
        }

        return $qb
            ->whereNotNull('poValue')
            ->whereNotNull('billable_value')
            ->whereNotNull('request_file')
            ->get()
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
