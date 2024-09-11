<?php

namespace App\Services\Reports\Company;

use App\Models\Po;
use App\Models\User;
use Carbon\Carbon;
use App\Services\Reports\DateRangeHelper;
use Illuminate\Support\Facades\DB;

class RebateReport
{
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function getStatistics($type, $id, $interval)
  {
    $query = Po::query();

    // Фільтрація за типом
    switch ($type) {
      case "company":
        $query->where("companyId", $id);
        break;
      case "contract":
        $query->where("contract_id", $id);
        break;
    }

    // Фільтрація за проміжком часу
    $now = Carbon::now();
    switch ($interval) {
      case "Last Week":
        $startDate = $now
          ->subWeek()
          ->addDays(1)
          ->startOfDay();
        $groupBy = "day";
        $dateFormat = "%d/%m";
        $interval = "1 day";
        break;
      case "Last Month":
        $startDate = $now
          ->subMonth()
          ->addDays(1)
          ->startOfDay();
        $groupBy = "week";
        $dateFormat = "%d/%m";
        $interval = "1 week";
        break;
      case "Past 90 days":
        $startDate = $now
          ->subDays(90)
          ->addDays(1)
          ->startOfDay();
        $groupBy = "week";
        $dateFormat = "%d/%m";
        $interval = "1 week";
        break;
      case "Past 180 days":
        $startDate = $now
          ->subDays(180)
          ->addDays(1)
          ->startOfDay();
        $groupBy = "week";
        $dateFormat = "%d/%m";
        $interval = "1 week";
        break;
      default:
        throw new \InvalidArgumentException("Invalid interval");
    }

    $endDate = Carbon::now()->endOfDay();
    $dateRange = DateRangeHelper::generateDateRange(
      $startDate->copy(),
      $endDate->copy(),
      $interval
    );

    // Отримання відсотка з компанії користувача
    $rebatePercentage = $this->user->company->agreed_rebate;

    // Групування та підрахунок
    $results = $query
      ->selectRaw(
        "DATE_FORMAT(billable_date, '$dateFormat') as date, SUM(billable_value_final * ?) as total_profit",
        [$rebatePercentage / 100]
      )
      ->where("billable_date", ">=", $startDate)
      ->groupBy(DB::raw("DATE_FORMAT(billable_date, '$dateFormat')"))
      ->orderBy(DB::raw("MIN(billable_date)"))
      ->get()
      ->keyBy("date");

    // Додавання відсутніх дат з total_profit 0
    $statistics = $dateRange->map(function ($date) use ($results, $dateFormat) {
      $formattedDate = $date->format("d/m");
      return [
        "date" => $formattedDate,
        "total_profit" => $results->get($formattedDate)->total_profit ?? 0,
      ];
    });

    return $statistics;
  }
}
