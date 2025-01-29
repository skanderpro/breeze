<?php
namespace App\Services\Reports\Supplier;
use App\Models\Po;
use App\Services\Reports\AbstractReport;

abstract class AbstractSupplierReport extends AbstractReport
{
  protected $query;

  public function __construct()
  {
    $this->query = Po::query()->join(
      "merchants",
      "pos.selectMerchant",
      "=",
      "merchants.id"
    );
  }
  protected function filterByType($query, $type, $id)
  {
    switch ($type) {
      case "branch":
        $query->where("merchants.parent_id", "=", $id);
      case "merchant":
        $query->where("selectMerchant", $id);
        break;
    }
    return $query;
  }
}
