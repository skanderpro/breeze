<?php
namespace App\Services\Reports\Company;

use App\Models\Po;
use App\Models\User;
use App\Services\Reports\AbstractReport;
use Carbon\Carbon;
use App\Services\Reports\DateRangeHelper;
use Illuminate\Support\Facades\DB;
use App\Services\Reports\ReportInterface;
use Illuminate\Support\Facades\Auth;

class RebateReport extends AbstractReport
{
  protected $user;

  public function __construct()
  {
    $this->user = Auth::user();
  }

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
      $endDate->copy(),
      $interval
    );
    $rebatePercentage = $this->user->company->agreed_rebate;
    $results = $this->calculateResults(
      $query,
      $dateRange,
      $rebatePercentage,
      $interval,
      $endDate
    );

    return $this->formatStatistics($dateRange, $results, $interval);
  }

  private function calculateResults(
    $query,
    $dateRange,
    $rebatePercentage,
    $interval,
    $endDate
  ) {
    return $dateRange->mapWithKeys(function ($date) use (
      $query,
      $rebatePercentage,
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
        ->sum(DB::raw("billable_value_final - actual_value"));

      return [
        $date->format($interval === "1 day" ? "d/m" : "Y-m-d") => $totalProfit,
      ];
    });
  }
}
