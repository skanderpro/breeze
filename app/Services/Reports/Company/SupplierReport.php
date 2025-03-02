<?php
namespace App\Services\Reports\Company;

use App\Models\Po;
use App\Services\Reports\AbstractReport;
use App\Services\Reports\DateRangeHelper;

class SupplierReport extends AbstractReport
{
  public function getStatistics($type, $id, $interval, $dateStart, $dateEnd)
  {
    $query = $this->filterByType(Po::query(), $type, $id);
    [
      $startDate,
      $endDate,
      $interval,
      $dateFormat,
    ] = $this->getDateRangeAndFormat($interval, $dateStart, $dateEnd);
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
        ->whereBetween("billable_date", [$date, $nextDate])
        ->sum("actual_value");

      return [
        $date->format($interval === "1 day" ? "d/m" : "Y-m-d") => $totalProfit,
      ];
    });
  }
}
