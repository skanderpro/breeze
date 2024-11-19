<?php

namespace App\Services\Reports;

use App\Models\User;
use App\Services\Reports\Company\RebateReport;
use App\Services\Reports\Company\SpendAnalysis;
use App\Services\Reports\Company\ContractComplianceReport;
use App\Services\Reports\ReportInterface;

class StatisticsReportFactory
{
  public function create($reportType): ReportInterface
  {
    switch ($reportType) {
      case "spend":
        return new SpendAnalysis();
      case "rebate":
        return new RebateReport();
      case "contract-compliance":
        return new ContractComplianceReport();
      default:
        throw new \InvalidArgumentException("Invalid report type");
    }
  }
}
