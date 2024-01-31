<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Po extends Model
{
    protected $fillable = [
        'u_id', 'companyId', 'selectMerchant', 'inputMerchant', 'poType', 'poPurpose', 'poMaterials', 'poProject', 'poProjectLocation', 'poValue', 'poCostSheet', 'poInvoice', 'poEMInvoice', 'poPod', 'poJobStatus', 'poFinanceStatus', 'poCompanyPo', 'poCancelled', 'poCancelledBy', 'poNotes', 'poCompleted', 'updated_at'
    ];
}
