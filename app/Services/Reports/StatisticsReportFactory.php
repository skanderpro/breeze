<?php

namespace App\Services\Reports;

use App\Models\User;
use App\Services\Reports\Company\RebateReport;
use App\Services\Reports\Company\SpendAnalysis;
use App\Services\Reports\Company\ContractComplianceReport;

class StatisticsReportFactory
{
  protected $user;

  public function __construct(User $user)
  {
    $this->user = $user;
  }

  public function create($reportType)
  {
    switch ($reportType) {
      case "spend":
        return new SpendAnalysis();
      case "rebate":
        return new RebateReport($this->user);
      case "contract-compliance":
        return new ContractComplianceReport();
      default:
        throw new \InvalidArgumentException("Invalid report type");
    }
  }
}
