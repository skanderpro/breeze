<?php

namespace App\Exports;

use App\Models\Po;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosSupplierExternalExport implements FromArray, WithHeadings
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
      "Agreed Mark up Figure",
      "Actual Supplier Cost",
      "PO Billable Value",
      "Express Merchants Invoice Number",
      "Location",
      "Task/projectNumber",
      "Material brief",
      "Name",
      "Created By",
      "Date Created",
    ];
  }

  public function array(): array
  {
    return $this->data;
  }
}
