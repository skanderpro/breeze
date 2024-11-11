<?php
namespace App\Services\Reports\Company;

use App\Models\Po;
use App\Models\User;
use Carbon\Carbon;
use App\Services\Reports\DateRangeHelper;
use Illuminate\Support\Facades\DB;
use App\Services\Reports\ReportInterface;

class RebateReport implements ReportInterface
{
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

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

  private function filterByType($query, $type, $id)
  {
    switch ($type) {
      case "company":
        $query->where("companyId", $id);
        break;
      case "contract":
        $query->where("contract_id", $id);
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
        $dateFormat = "d/m";
        $interval = "1 day";
        break;
      case "Last Month":
        $startDate = $now
          ->subMonth()
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "d/m";
        $interval = "1 week";
        break;
      case "Past 90 days":
        $startDate = $now
          ->subDays(90)
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "d/m";
        $interval = "1 week";
        break;
      case "Past 180 days":
        $startDate = $now
          ->subDays(180)
          ->addDays(1)
          ->startOfDay();
        $dateFormat = "d/m";
        $interval = "1 week";
        break;
      default:
        throw new \InvalidArgumentException("Invalid interval");
    }
    $endDate = Carbon::now()->endOfDay();
    return [$startDate, $endDate, $interval, $dateFormat];
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
        ->sum(DB::raw("billable_value_final * " . $rebatePercentage / 100));

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
