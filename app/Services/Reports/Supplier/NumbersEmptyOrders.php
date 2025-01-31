<?php

namespace App\Services\Reports\Supplier;

use App\Services\Reports\Supplier\AbstractSupplierReport;
use App\Services\Reports\DateRangeHelper;

class NumbersEmptyOrders extends AbstractSupplierReport
{
  public function getStatistics($type, $id, $interval)
  {
    $query = $this->filterByType($this->query, $type, $id);
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
        ->whereBetween("pos.created_at", [$date, $nextDate])
        ->whereNull("billable_date")
        ->count("*");

      return [
        $date->format($interval === "1 day" ? "d/m" : "Y-m-d") => $totalProfit,
      ];
    });
  }
}
