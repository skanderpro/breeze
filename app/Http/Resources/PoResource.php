<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PoResource extends JsonResource
{
  /**
   * Transform the resource into an array.
   *
   * @return array<string, mixed>
   */
  public function toArray(Request $request): array
  {
    return [
      "id" => $this->resource->id,
      "number" => $this->resource->poNumber,
      "select_merchant" => $this->resource->selectMerchant,
      "input_merchant" => $this->resource->inputMerchant,
      "company_id" => $this->companyId,
      "type" => $this->resource->poType,
      "purpose" => $this->resource->poPurpose,
      "materials" => $this->resource->poMaterials,
      "project" => $this->resource->poProject,
      "project_location" => $this->resource->poProjectLocation,
      "value" => $this->resource->poValue,
      "invoice" => $this->resource->poInvoice,
      "em_invoice" => $this->resource->poEMInvoice,
      "cost_sheet" => $this->resource->poCostSheet,
      "pod" => $this->resource->poPod,
      "pod_url" => !empty($this->poPod) ? asset($this->poPod) : null,
      "job_status" => $this->resource->poJobStatus,
      "finance_status" => $this->resource->poFinanceStatus,
      "cancelled" => $this->resource->poCancelled,
      "cancelled_by" => $this->resource->poCancelledBy,
      "completed" => $this->resource->poCompleted,
      "notes" => $this->resource->poNotes,
      "created_at" => $this->resource->created_at,
      'created_by' => $this->resource->createdBy ? UserResource::make($this->resource->createdBy) : null,
      "updated_at" => $this->resource->updated_at,
      "merchantId" => $this->merchant?->merchantId ?? null,
      "status" => $this->status,
      "username" => $this->user->name,
      'user' => $this->user ? UserResource::make($this->user) : null,
      "merchantName" => $this->merchant?->merchantName ?? null,
      "contractName" => $this->contract?->companyName ?? null,
      "poVisitStatus" => !!$this->resource->poVisitStatus,
      "request_file" => !empty($this->request_file)
        ? asset($this->request_file)
        : null,
      "billable_value" => $this->billable_value,
      "billable_value_final" => $this->billable_value_final,
      "alt_merchant_name" => $this->resource->alt_merchant_name ?? null,
      "alt_merchant_contact" => $this->resource->alt_merchant_contact ?? null,
      "contract_id" => $this->contract_id,
      "counts" => $this->resource->request_count,
    ];
  }
}
