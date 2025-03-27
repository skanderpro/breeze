<?php
namespace App\Services\Reports;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

abstract class AbstractReport
{
  abstract public function getStatistics(
    $type,
    $id,
    $interval,
    $dateStart,
    $dateEnd
  );

  protected function filterByType($query, $type, $id)
  {
    switch ($type) {
      case "company":
        $query->where("companyId", $id);
        break;
      case "contract":
        $query->where("contract_id", $id);
        break;
      case "user":
        $query->where("u_id", $id);
        break;
      case "supplier":
        $query->where("selectMerchant", $id);
        break;
      case "supplier_type":
        $query
          ->join("merchants", "merchants.id", "=", "pos.selectMerchant")
          ->where("{$id}", "YES");
        break;
    }
    return $query;
  }

  protected function getDateRangeAndFormat($interval, $dateStart, $dateEnd)
  {
    if (!$dateStart || !$dateEnd) {
      throw new \InvalidArgumentException("Start and end dates are required");
    }

    $startDate = Carbon::parse($dateStart)->startOfDay();
    $endDate = Carbon::parse($dateEnd)->endOfDay();

    switch ($interval) {
      case "By Days":
        $dateFormat = "%d/%m/%Y";
        $interval = "1 day";
        break;
      case "By Weeks":
        $dateFormat = "%d/%m%m/%Y";
        $interval = "1 week";
        break;
      case "By Months":
        $dateFormat = "%d/%m%m/%Y";
        $interval = "1 month";
        break;
      case "By Quarters":
        $dateFormat = "%d/%m%m/%Y";
        $interval = "3 months";
        break;
      case "By Half of Years":
        $dateFormat = "%d/%m%m/%Y";
        $interval = "6 months";
        break;
      default:
        throw new \InvalidArgumentException("Invalid interval");
    }

    return [$startDate, $endDate, $interval, $dateFormat];
  }

  protected function formatStatistics($dateRange, $results, $interval)
  {
    return $dateRange->map(function ($date) use ($results, $interval) {
      $formattedDate = $date->format($interval === "1 day" ? "d/m" : "Y-m-d");
      $titleFormattedDate = $date->format("d/m/Y");

      $total_profit = $results->get($formattedDate) ?? 0;
      return [
        "date" => $titleFormattedDate,
        "total_profit" => $total_profit,
      ];
    });
  }
}
