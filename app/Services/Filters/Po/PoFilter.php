<?php
namespace App\Services\Filters\Po;

use Illuminate\Support\Facades\Auth;

class PoFilter
{
  protected $query;
  protected $request;

  public function __construct()
  {
    $this->request = request();
  }

  public function setQuery($query)
  {
    $this->query = $query
      ->select("pos.*")
      ->join("companies", "companies.id", "=", "pos.contract_id")
      ->join("users", "users.id", "=", "pos.u_id")
      ->leftJoin("merchants", "merchants.id", "=", "pos.selectMerchant");
    return $this;
  }

  public function filterOnlyPos()
  {
    $this->query->where("is_request", 0);
    return $this;
  }

  public function filterOnlyReequests()
  {
    $this->query->where("is_request", 1);
    return $this;
  }

  public function filterByOwner()
  {
    $user = Auth::user();
    $this->query->where("u_id", $user->id);
    return $this;
  }

  public function filterByDates()
  {
    $filter = $this->request->all();
    if (
      !empty($filter["filter"]["startDate"]) &&
      !empty($filter["filter"]["endDate"])
    ) {
      $startDate = date(
        "Y-m-d H:i:s",
        strtotime($filter["filter"]["startDate"])
      );
      $endDate = date("Y-m-d H:i:s", strtotime($filter["filter"]["endDate"]));

      $this->query->where(function ($q) use ($startDate, $endDate) {
        $q->where("pos.created_at", ">=", $startDate)->where(
          "pos.created_at",
          "<=",
          $endDate
        );
      });
    }

    return $this;
  }

  public function filterByAdminStatuses()
  {
    $filter = $this->request->all();
    if (!empty($filter["filter"]["statuses"])) {
      $statuses = explode(",", $filter["filter"]["statuses"]);
      $this->query->whereIn("status", $statuses);
    }
    return $this;
  }
  public function filterByClientStatuses()
  {
    $filter = $this->request->all();
    if (!empty($filter["filter"]["statuses"])) {
      $statuses = explode(",", $filter["filter"]["statuses"]);
      $this->query->whereIn("client_status", $statuses);
    }
    return $this;
  }

  public function filterSeachByText()
  {
    $filter = $this->request->all();
    if (!empty($filter["filter"]["search"])) {
      $this->query->where(function ($q) use ($filter) {
        $q->where(
          "merchants.merchantName",
          "like",
          "%" . $filter["filter"]["search"] . "%"
        )
          ->orWhere(
            "pos.alt_merchant_name",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poNumber",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poProject",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poCompanyPo",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "pos.poProjectLocation",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          )
          ->orWhere(
            "companies.companyName",
            "like",
            "%" . $filter["filter"]["search"] . "%"
          );
      });
    }
    return $this;
  }

  public function orderBy($order, $param)
  {
    $this->query->orderBy($order, $param);
    return $this;
  }
}
