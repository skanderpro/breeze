<?php

namespace App\Exports;

use App\Models\Po;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosContractComplianceExternalExport implements FromArray, WithHeadings
{
  protected $data;
  public function __construct($data)
  {
    $this->data = $data;
  }

  public function headings(): array
  {
    return [
      "EM Number",
      "Contract Name",
      "Order Purpose",
      "Supplier Name",
      "Supplier Cost (as entered by user)",
      "Actual Supplier Cost",
      "PO Billable Value",
      "Location",
      "Task/projectNumber",
      "Material brief",
      "Name",
      "Spend Limit",
      "POD Uploaded (YES/NO)",
      "Created By",
      "Order Status",
      "Date Created",
    ];
  }

  public function array(): array
  {
    return $this->data;
  }
}
