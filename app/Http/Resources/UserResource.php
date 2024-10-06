<?php

namespace App\Http\Resources;

use App\Models\Po;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;

class UserResource extends JsonResource
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
      "companies" => CompanyResource::collection($this->companies),
      "name" => $this->name,
      "companyLimit" => $this->order_limit,
      "accessLevel" => $this->resource->accessLevel,
      "phone" => $this->resource->phone,
      "disabled" => $this->resource->disabled,
      "email" => $this->resource->email,
      "created_at" => $this->resource->created_at,
      "orders_count" => Po::getOrdersCount(null, $this->resource),
      "merchant_id" => $this->resource->merchant_id,
      "merchant_parent_id" => $this->resource->merchant_parent_id,
      "price_limit" => $this->resource->price_limit,
      "company" => CompanyResource::make($this->company),
      'country' => $this->resource->country,
      'phoneCode' => $this->resource->phoneCode,
    ] +
      ($this->resource->id === Auth::id()
        ? [
          "settings" => [
            "push_notification" =>
              (bool) $this->resource->setting_push_notification,
            "email_notification" =>
              (bool) $this->resource->setting_email_notification,
          ],
        ]
        : []);
  }
}
