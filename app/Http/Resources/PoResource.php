<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

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
            'id' => $this->resource->id,
            'number' => $this->resource->poNumber,
            'select_merchant' => $this->resource->selectMerchant,
            'input_merchant' => $this->resource->inputMerchant,
            'type' => $this->resource->poType,
            'purpose' => $this->resource->poPurpose,
            'materials' => $this->resource->poMaterials,
            'project' => $this->resource->poProject,
            'project_location' => $this->resource->poProjectLocation,
            'value' => $this->resource->poValue,
            'invoice' => $this->resource->poInvoice,
            'em_invoice' => $this->resource->poEMInvoice,
            'cost_sheet' => $this->resource->poCostSheet,
            'pod' => $this->resource->poPod,
            'job_status' => $this->resource->poJobStatus,
            'finance_status' => $this->resource->poFinanceStatus,
            'cancelled' => $this->resource->poCancelled,
            'cancelled_by' => $this->resource->poCancelledBy,
            'completed' => $this->resource->poCompleted,
            'notes' => $this->resource->poNotes,
            'created_at' => $this->resource->created_at,
            'updated_at' => $this->resource->updated_at,
        ];
    }
}
