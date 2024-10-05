<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CompanyResource extends JsonResource
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
      "name" => $this->resource->companyName,
      "phone" => $this->resource->companyPhone,
      "fax" => $this->resource->companyFax,
      "contact" => $this->resource->companyContact,
      "contact_email" => $this->resource->companyContactEmail,
      "address" => $this->resource->companyAddress,
      "disabled" => $this->resource->disabled,
      "limit" => $this->resource->limit,
      "created_at" => $this->resource->created_at,
      "updated_at" => $this->resource->updated_at,
      "agreed_rebate" => $this->agreed_rebate,
      "agreed_markup" => $this->agreed_markup,
      "company" => !!$this->root_company
        ? [
          "id" => $this->root_company->id,
          "name" => $this->root_company->companyName,
        ]
        : null,
      "parent_id" => $this->resource->parent_id,
      "mark_up" => $this->resource->mark_up,
      "email" => $this->resource->companyContactEmail,
      "limit_4_role" => $this->resource->limit_4_role,
      "limit_5_role" => $this->resource->limit_5_role,
      "limit_6_role" => $this->resource->limit_6_role,
      'url' => $this->resource->url,
      'companyContactPhone' => $this->resource->companyContactPhone,
      'phoneCode' => $this->resource->phoneCode,
    ];
  }
}
