<?php

namespace App\Http\Controllers\Api\ExportReport;

use App\Exports\PosSpendExternalExport;
use App\Models\Po;
use App\Models\PoNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\ExportReport\ExportController;

class ExportSpendReportController extends ExportController
{
  public function byCompany(Request $request)
  {
    $qb = Po::query();

    if ($request->has(["from", "to"])) {
      $qb = $qb->whereBetween("created_at", [
        $request->get("from"),
        $request->get("to"),
      ]);
    }

    if ($request->has("data")) {
      $qb = $qb->where("companyId", $request->get("data"));
    }

    $pos = $qb->get();
    $data = [];

    foreach ($pos as $po) {
      $data[] = [
        "em_number" => $po->poNumber,
        "contract_name" => $po->contract?->companyName,
        "purpose" => $po->poPurpose,
        "supplier_name" => $po->merchant
          ? $po->merchant->name
          : $po->alt_merchant_name,
        "supplier_cost" => $po->poValue,
        "agreed_markup" => $po->company?->agreed_markup,
        "actual_supplier_cost" => $po->actual_value,
        "billable_value" => $po->billable_value_final,
        "invoice_number" => $po->poInvoice ?? $po->EMInvoice,
        "location" => $po->poProjectLocation,
        "project_number" => $po->poProject,
        "materials" => $po->poMaterials,
        "name" => $po->user?->name,
        "created_by" => $po->createdBy?->name,
        "created_at" => $po->created_at,
      ];
    }

    return $this->exportResponse($data, PosSpendExternalExport::class);
  }

  public function byContract(Request $request)
  {
    $qb = Po::query();

    if ($request->has(["from", "to"])) {
      $qb = $qb->whereBetween("created_at", [
        $request->get("from"),
        $request->get("to"),
      ]);
    }

    if ($request->has("data")) {
      $qb = $qb->where("contract_id", $request->get("data"));
    }

    $pos = $qb->get();
    $data = [];

    foreach ($pos as $po) {
      $data[] = [
        "em_number" => $po->poNumber,
        "contract_name" => $po->contract?->companyName,
        "purpose" => $po->poPurpose,
        "supplier_name" => $po->merchant
          ? $po->merchant->name
          : $po->alt_merchant_name,
        "supplier_cost" => $po->poValue,
        "agreed_markup" => $po->company?->agreed_markup,
        "actual_supplier_cost" => $po->actual_value,
        "billable_value" => $po->billable_value_final,
        "invoice_number" => $po->poInvoice ?? $po->EMInvoice,
        "location" => $po->poProjectLocation,
        "project_number" => $po->poProject,
        "materials" => $po->poMaterials,
        "name" => $po->user?->name,
        "created_by" => $po->createdBy?->name,
        "created_at" => $po->created_at,
      ];
    }

    return $this->exportResponse($data, PosSpendExternalExport::class);
  }

  public function byUser(Request $request)
  {
    $qb = Po::query();

    if ($request->has(["from", "to"])) {
      $qb = $qb->whereBetween("created_at", [
        $request->get("from"),
        $request->get("to"),
      ]);
    }

    if ($request->has("data")) {
      $qb = $qb->where("u_id", $request->get("data"));
    }

    $pos = $qb->get();
    $data = [];

    foreach ($pos as $po) {
      $data[] = [
        "em_number" => $po->poNumber,
        "contract_name" => $po->contract?->companyName,
        "purpose" => $po->poPurpose,
        "supplier_name" => $po->merchant
          ? $po->merchant->name
          : $po->alt_merchant_name,
        "supplier_cost" => $po->poValue,
        "agreed_markup" => $po->company?->agreed_markup,
        "actual_supplier_cost" => $po->actual_value,
        "billable_value" => $po->billable_value_final,
        "invoice_number" => $po->poInvoice ?? $po->EMInvoice,
        "location" => $po->poProjectLocation,
        "project_number" => $po->poProject,
        "materials" => $po->poMaterials,
        "name" => $po->user?->name,
        "created_by" => $po->createdBy?->name,
        "created_at" => $po->created_at,
      ];
    }

    return $this->exportResponse($data, PosSpendExternalExport::class);
  }
}
