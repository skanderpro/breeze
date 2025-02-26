<?php

namespace App\Exports;

use App\Models\Po;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PosExternalExport implements FromArray, WithHeadings
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
      "EM Manual Status",
      "POD Uploaded",
      "Company Name",
      "Contract Name",
      "User Name (Plan Level)",
      "Created By (Plan Level)",
      "Order Purpose (Project, Van Stock, Reactive, PPM)",
      "Order Status (Client-Side Auto Status)",
      "Project/Task",
      "Project Location",
      "Supplier Name",
      "PO Type (Pre-Approved OR Alternative)",
      "Alternative Supplier Name",
      "Alternative Supplier Contact Name",
      "Alternative Supplier Email",
      "Supplier Cost (As entered by the User",
      "Actual Supplier Cost",
      "PO Billable Value",
      "Material Brief",
      "PO Cancelled",
      "Cancelled By (Name & Plan Level)",
      "Reason for Cancelling (From Reason Clicked when cancelled)",
      "Date Created",
    ];
  }

  public function array(): array
  {
    return $this->data;
  }
}
