<?php
namespace App\Services\Reports;

use Carbon\Carbon;
use Illuminate\Support\Collection;

class DateRangeHelper
{
  public static function generateDateRange(
    Carbon $startDate,
    Carbon $endDate,
    $interval
  ) {
    $dates = new Collection();

    while ($startDate->lte($endDate)) {
      $dates->push($startDate->copy());
      $startDate->add($interval);
    }

    return $dates;
  }
}
