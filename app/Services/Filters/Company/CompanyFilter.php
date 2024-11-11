<?php

namespace App\Services\Filters\Company;
use App\Services\Filters\FilterTrait;

class CompanyFilter
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
      $this->query
        ->where("companyName", "like", "%{$search}%")
        ->orWhere("companyContactEmail", "like", "%{$search}%")
        ->orWhere("companyAddress", "like", "%{$search}%");
    }
    return $this;
  }
}
