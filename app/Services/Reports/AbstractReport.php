<?php
namespace App\Services\Reports;
use Carbon\Carbon;

abstract class AbstractReport
{
  abstract public function getStatistics($type, $id, $interval);

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
    }
    return $query;
  }

  protected function getDateRangeAndFormat($interval)
  {
    $now = Carbon::now();
    switch ($interval) {
      case "Last Week":
        $startDate = $now
          ->subWeek()
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "%d/%m";
        $interval = "1 day";
        break;
      case "Last Month":
        $startDate = $now
          ->subMonth()
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "%d/%m";
        $interval = "1 week";
        break;
      case "Past 90 days":
        $startDate = $now
          ->subDays(90)
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "%d/%m";
        $interval = "1 week";
        break;
      case "Past 180 days":
        $startDate = $now
          ->subDays(180)
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "%d/%m";
        $interval = "1 week";
        break;
      default:
        throw new \InvalidArgumentException("Invalid interval");
    }
    $endDate = Carbon::now();
    return [$startDate, $endDate, $interval, $dateFormat];
  }

  protected function formatStatistics($dateRange, $results, $interval)
  {
    return $dateRange->map(function ($date) use ($results, $interval) {
      $formattedDate = $date->format($interval === "1 day" ? "d/m" : "Y-m-d");
      $titleFormattedDate = $date->format("d/m");
      return [
        "date" => $titleFormattedDate,
        "total_profit" => $results->get($formattedDate) ?? 0,
      ];
    });
  }
}
