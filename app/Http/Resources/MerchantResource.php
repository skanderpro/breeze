<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MerchantResource extends JsonResource
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
      "name" => $this->resource->merchantName,
      "merchant_id" => $this->resource->merchantId,
      "address_1" => $this->resource->merchantAddress1,
      "address_2" => $this->resource->merchantAddress2,
      "address" => $this->resource->getAddress(),
      "country" => $this->resource->merchantCountry,
      "post_code" => $this->resource->merchantPostcode,
      "phone" => $this->resource->merchantPhone,
      "fax" => $this->resource->merchantFax,
      "email" => $this->resource->merchantEmail,
      "web" => $this->resource->merchantWeb,
      "plumbing" => $this->resource->merchantPlumbing,
      "electrical" => $this->resource->merchantElectrical,
      "builders" => $this->resource->merchantBuilders,
      "hire" => $this->resource->merchantHire,
      "decorating" => $this->resource->merchantDecorating,
      "flooring" => $this->resource->merchantFlooring,
      "auto" => $this->resource->merchantAuto,
      "aggregate" => $this->resource->merchantAggregate,
      "roofing" => $this->resource->merchantRoofing,
      "fixing" => $this->resource->merchantFixing,
      "ironmongrey" => $this->resource->merchantIronmongrey,
      "tyres" => $this->resource->merchantTyres,
      "health" => $this->resource->merchantHealth,
      "lat" => $this->resource->lat,
      "lng" => $this->resource->lng,
      "contact_name" => $this->resource->merchantContactName,
      "contact_email" => $this->resource->merchantContactEmail,
      "contact_phone" => $this->resource->merchantContactPhone,
      // 'created_at' => $this->resource->created_at,
      // 'updated_at' => $this->resource->updated_at,
      "green_supplier" => $this->resource->green_supplier,
      "disabled" => $this->resource->disabled,
      "parent_id" => $this->resource->parent_id,
      "phoneCode" => $this->resource->merchantPhoneCode,
      "rebate" => $this->resource->merchantRebate,
    ];
  }
}
