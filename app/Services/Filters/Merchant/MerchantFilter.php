<?php

namespace App\Services\Filters\Merchant;

use App\Services\Filters\FilterTrait;

class MerchantFilter
{
  use FilterTrait;
  protected $query;

  public function __construct($query)
  {
    $this->query = $query;
  }

  public function filterBySearch($search)
  {
    if (!empty($search)) {
      $this->query->where(function ($query) use ($search) {
        $query
          ->where("merchantName", "LIKE", "%$search%")
          ->orWhere("merchantId", "LIKE", "%$search%")
          ->orWhere("merchantAddress1", "LIKE", "%$search%")
          ->orWhere("merchantAddress2", "LIKE", "%$search%")
          ->orWhere("merchantPostcode", "LIKE", "%$search%")
          ->orWhere("merchantEmail", "LIKE", "%$search%");
      });
    }

    return $this;
  }

  public function filterByName($name)
  {
    if (!empty($name)) {
      $this->query->where("merchantName", "like", "%" . $name . "%");
    }

    return $this;
  }

  public function filterByMerchantId($merchantId)
  {
    if (!empty($merchantId)) {
      $this->query->where("merchantId", $merchantId);
    }

    return $this;
  }

  public function filterByGreenSupplier($greenSupplier)
  {
    if (!empty($greenSupplier)) {
      $this->query->where("green_supplier", "1");
    }

    return $this;
  }

  public function filterByMerchantAttributes($request)
  {
    $attributes = [
      "merchantPlumbing",
      "merchantElectrical",
      "merchantBuilders",
      "merchantHire",
      "merchantDecorating",
      "merchantFlooring",
      "merchantAuto",
      "merchantAggregate",
      "merchantRoofing",
      "merchantFixing",
      "merchantIronmongrey",
      "merchantTyres",
      "merchantHealth",
    ];

    foreach ($attributes as $attribute) {
      $value = $request->get($attribute);
      if (!empty($value)) {
        $this->query->where($attribute, $value);
      }
    }

    return $this;
  }
}
