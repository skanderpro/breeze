<?php

namespace App\Services\Reports;

interface ReportInterface
{
  public function getStatistics($type, $id, $interval);
}
