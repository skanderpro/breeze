<?php

namespace App\Exports;

use App\Models\Po;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosExport implements FromQuery, WithHeadings
{
  protected $startDate;
  protected $endDate;

  public function __construct($startDate = null, $endDate = null)
  {
    $this->startDate = $startDate;
    $this->endDate = $endDate;
  }

  public function headings(): array
  {
    return [
      "id",
      "poNumber",
      "u_id",
      "companyId",
      "selectMerchant",
      "inputMerchant",
      "poType",
      "poPurpose",
      "poMaterials",
      "poProject",
      "poProjectLocation",
      "poValue",
      "poInvoice",
      "poEMInvoice",
      "poCostSheet",
      "poPod",
      "poJobStatus",
      "poFinanceStatus",
      "poCompanyPo",
      "poCancelled",
      "poCancelledBy",
      "poCompleted",
      "poNotes",
      "created_at",
      "updated_at",
      "alt_merchant_name",
      "alt_merchant_contact",
      "contract_id",
      "poCompletedStatus",
      "poVisitStatus",
      "alt_merchant_email",
      "status",
      "is_request",
      "request_file",
      "billable_value_final",
      "billable_date",
      "overlimit_value",
      "created_by_id",
      "actual_value",
    ];
  }

  public function query()
  {
    $query = Po::query();

    if ($this->startDate) {
      $query->where("created_at", ">=", $this->startDate);
    }

    if ($this->endDate) {
      $query->where("created_at", "<=", $this->endDate);
    }

    return $query;
  }
}
