<?php

namespace App\Http\Controllers\Api\ExportReport;

use App\Exports\PosStatusExternalExport;
use App\Http\Controllers\Controller;
use App\Models\Po;
use App\Models\PoNote;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Api\ExportReport\ExportController;

class ExportStatusReportController extends ExportController
{
  public function companyStatusReport(Request $request)
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
        "status" => $po->status,
        "pod_uploaded" => !empty($po->poPod),
        "company_name" => $po->company?->companyName,
        "contract_name" => $po->contract?->companyName,
        "user_name" => "{$po->user?->name} ({$po->user?->accessLevel})",
        "created_by" => "{$po->createdBy?->name} ({$po->createdBy?->accessLevel})",
        "purpose" => $po->poPurpose,
        "client_status" => $po->client_status,
        "project" => $po->poProject,
        "project_location" => $po->poProjectLocation,
        "supplier_name" => $po->merchant
          ? $po->merchant->name
          : $po->alt_merchant_name,
        "po_type" => $po->poType,
        "alternative_supplier_name" => $po->alt_merchant_name,
        "alt_supplier_contact" => $po->alt_merchant_contact,
        "alt_supplier_email" => $po->alt_merchant_email,
        "supplier_cost" => $po->poValue,
        "actual_supplier_cost" => $po->actual_value,
        "billable_value" => $po->billable_value_final,
        "materials_brief" => $po->poMaterials,
        "po_cancelled" => $po->poCancelled ? "yes" : "no",
        "cancelled_by" => $po->poCancelledBy,
        "reason" => $po->poCompleted,
        "created_at" => $po->created_at,
      ];
    }

    return $this->exportResponse($data, PosStatusExternalExport::class);
  }

  public function contractStatusReport(Request $request)
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
        "status" => $po->status,
        "pod_uploaded" => !empty($po->poPod),
        "company_name" => $po->company?->companyName,
        "contract_name" => $po->contract?->companyName,
        "user_name" => "{$po->user?->name} ({$po->user?->accessLevel})",
        "created_by" => "{$po->createdBy?->name} ({$po->createdBy?->accessLevel})",
        "purpose" => $po->poPurpose,
        "client_status" => $po->client_status,
        "project" => $po->poProject,
        "project_location" => $po->poProjectLocation,
        "supplier_name" => $po->merchant
          ? $po->merchant->name
          : $po->alt_merchant_name,
        "po_type" => $po->poType,
        "alternative_supplier_name" => $po->alt_merchant_name,
        "alt_supplier_contact" => $po->alt_merchant_contact,
        "alt_supplier_email" => $po->alt_merchant_email,
        "supplier_cost" => $po->poValue,
        "actual_supplier_cost" => $po->actual_value,
        "billable_value" => $po->billable_value_final,

        "materials_brief" => $po->poMaterials,
        "po_cancelled" => $po->poCancelled ? "yes" : "no",
        "cancelled_by" => $po->poCancelledBy,
        "reason" => $po->poCompleted,
        "created_at" => $po->created_at,
      ];
    }

    return $this->exportResponse($data, PosStatusExternalExport::class);
  }

  public function userStatusReport(Request $request)
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
        "status" => $po->status,
        "pod_uploaded" => !empty($po->poPod),
        "company_name" => $po->company?->companyName,
        "contract_name" => $po->contract?->companyName,
        "user_name" => "{$po->user?->name} ({$po->user?->accessLevel})",
        "created_by" => "{$po->createdBy?->name} ({$po->createdBy?->accessLevel})",
        "purpose" => $po->poPurpose,
        "client_status" => $po->client_status,
        "project" => $po->poProject,
        "project_location" => $po->poProjectLocation,
        "supplier_name" => $po->merchant
          ? $po->merchant->name
          : $po->alt_merchant_name,
        "po_type" => $po->poType,
        "alternative_supplier_name" => $po->alt_merchant_name,
        "alt_supplier_contact" => $po->alt_merchant_contact,
        "alt_supplier_email" => $po->alt_merchant_email,
        "supplier_cost" => $po->poValue,
        "actual_supplier_cost" => $po->actual_value,
        "billable_value" => $po->billable_value_final,
        "materials_brief" => $po->poMaterials,
        "po_cancelled" => $po->poCancelled ? "yes" : "no",
        "cancelled_by" => $po->poCancelledBy,
        "reason" => $po->poCompleted,
        "created_at" => $po->created_at,
      ];
    }

    return $this->exportResponse($data, PosStatusExternalExport::class);
  }
}
