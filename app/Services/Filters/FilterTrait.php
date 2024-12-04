<?php

namespace App\Services\Filters;

trait FilterTrait
{
  public function filterByParentAndDisabled()
  {
    $this->query
      ->where(function ($query) {
        $query->where("parent_id", 0)->where(function ($query) {
          $query->where("disabled", 0)->orWhereNull("disabled");
        });
      })
      ->orWhere(function ($query) {
        $query
          ->where("parent_id", "!=", 0)
          ->where(function ($query) {
            $query->where("disabled", 0)->orWhereNull("disabled");
          })
          ->whereHas("parent", function ($query) {
            $query->where("disabled", 0)->orWhereNull("disabled");
          });
      });

    return $this;
  }
}
