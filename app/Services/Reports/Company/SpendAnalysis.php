<?php

namespace App\Services\Reports\Company;

use App\Models\Po;
use App\Services\Reports\DateRangeHelper;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SpendAnalysis
{
  public function getStatistics($type, $id, $interval)
  {
    $query = $this->filterByType(Po::query(), $type, $id);
    [
      $startDate,
      $endDate,
      $interval,
      $dateFormat,
    ] = $this->getDateRangeAndFormat($interval);
    $dateRange = DateRangeHelper::generateDateRange(
      $startDate->copy(),
      $endDate,
      $interval
    );
    $results = $this->calculateResults($query, $dateRange, $interval, $endDate);

    return $this->formatStatistics($dateRange, $results, $interval);
  }

  private function filterByType($query, $type, $id)
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

  private function getDateRangeAndFormat($interval)
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

  private function calculateResults($query, $dateRange, $interval, $endDate)
  {
    return $dateRange->mapWithKeys(function ($date) use (
      $query,
      $interval,
      $endDate
    ) {
      $nextDate = $date->copy()->add($interval);
      if ($nextDate->gt($endDate)) {
        $nextDate = $endDate;
      }

      $clonedQuery = clone $query;

      $totalProfit = $clonedQuery
        ->whereBetween("billable_date", [$date, $nextDate])
        ->sum("billable_value_final");

      return [
        $date->format($interval === "1 day" ? "d/m" : "Y-m-d") => $totalProfit,
      ];
    });
  }

  private function formatStatistics($dateRange, $results, $interval)
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
