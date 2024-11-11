<?php

namespace App\Services\Filters;

trait FilterTrait
{
  public function filterByParentAndDisabled()
  {
    $this->query
      ->where(function ($query) {
        $query->where("parent_id", 0)->where("disabled", 0);
      })
      ->orWhere(function ($query) {
        $query
          ->where("parent_id", "!=", 0)
          ->where("disabled", 0)
          ->whereHas("parent", function ($query) {
            $query->where("disabled", 0);
          });
      });
    return $this;
  }
}
