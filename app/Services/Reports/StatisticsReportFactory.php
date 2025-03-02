<?php

namespace App\Services\Reports;

use App\Models\User;
use App\Services\Reports\Company\RebateReport;
use App\Services\Reports\Company\SpendAnalysis;
use App\Services\Reports\Company\ContractComplianceReport;
use App\Services\Reports\AbstractReport;
use App\Services\Reports\Company\PoStatus;
use App\Services\Reports\Company\SupplierReport;
use App\Services\Reports\Supplier\NumbersEmptyOrders;
use App\Services\Reports\Supplier\NumbersOrders;
use App\Services\Reports\Supplier\QuoteAverageTime;
use App\Services\Reports\Supplier\TotalSupplierRevenue;

class StatisticsReportFactory
{
  public function create($reportType): AbstractReport
  {
    switch ($reportType) {
      case "spend":
        return new SpendAnalysis();
      case "rebate":
        return new RebateReport();
      case "contract-compliance":
        return new ContractComplianceReport();
      case "supplier":
        return new SupplierReport();
      case "po-statuses":
        return new PoStatus();
      case "total-supplier-revenue":
        return new TotalSupplierRevenue();
      case "numbers-orders":
        return new NumbersOrders();
      case "numbers-empty-orders":
        return new NumbersEmptyOrders();
      case "quote-average-time":
        return new QuoteAverageTime();
      default:
        throw new \InvalidArgumentException("Invalid report type");
    }
  }
}
