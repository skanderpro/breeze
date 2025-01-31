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
        $item->status,
        $item->poPod ? "Yes" : "No",
        $item->company?->companyName,
        $item->contract?->companyName,
        $item->user?->name . " (" . $item->user->accessLevel . ")",
        $item->createdBy?->name . " (" . $item->createdBy?->accessLevel . ")",
        $item->poPurpose,
        $item->client_status,
        $item->poProject,
        $item->poProjectLocation,
        $item->poType === "Pre Approved" ? $item->merchant?->merchantName : "",
        $item->poType,
        $item->alt_merchant_name,
        $item->alt_merchant_contact,
        $item->alt_merchant_email,
        $item->poValue,
        $item->actual_value,
        $item->billable_value_final,
        $item->poMaterials,
        $item->poCancelled === 1 ? "Yes" : "No",
        $item->poCancelledBy,
        $item->poCompletedStatus,
        $item->created_at,
      ];
    });
    return $data->toArray();
  }
}
