<?php

namespace App\Exports;

use App\Models\Po;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosExport implements FromArray, WithHeadings
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
      "EM Number",
      "Supplier Name",
      "PO Billable Value",
      "Job Location",
      "Job Number",
      "PO Note",
      "Tech Name",
      "Date Created",
    ];
  }

  public function array(): array
  {
    $query = Po::query();

    if ($this->startDate) {
      $query->where("created_at", ">=", $this->startDate);
    }

    if ($this->endDate) {
      $query->where("created_at", "<=", $this->endDate);
    }

    $results = $query->get();
    $data = $results->map(function ($item) {
      return [
        $item->poNumber,
        $item->poType === "Pre Approved"
          ? $item->merchant->merchantName
          : $item->alt_merchant_name,
        $item->billable_value_final,
        $item->poProjectLocation,
        $item->poCompanyPo,
        $item->poMaterials,
        $item->user->name,
        $item->created_at,
      ];
    });
    return $data->toArray();
  }
}
