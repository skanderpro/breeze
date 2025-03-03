<?php
namespace App\Services\Reports\Company;

use App\Models\Po;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\Reports\DateRangeHelper;
use App\Services\Reports\ReportInterface;

class ContractComplianceReport implements ReportInterface
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
      $totalOverlimit = $clonedQuery
        ->whereBetween("created_at", [$date, $nextDate])
        ->sum("overlimit_value");

      return [
        $date->format(
          $interval === "1 day" ? "d/m" : "Y-m-d"
        ) => $totalOverlimit,
      ];
    });
  }

  
}
