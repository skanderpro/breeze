<?php
namespace App\Services\Reports\Company;

use App\Models\Po;
use App\Services\Reports\AbstractReport;
use App\Services\Reports\DateRangeHelper;
use Illuminate\Support\Facades\Log;

class PoStatus extends AbstractReport
{
    private array $statuses = ["New Order", "Client PO Required", "Pending Invoice", "Order Complete","Action Required",'Cancelled'];

	public function getStatistics($type, $id, $interval, $dateStart, $dateEnd)
	{
		$query = $this->filterByType(Po::query(), $type, $id);
		[
			$startDate,
			$endDate,
			$interval,
			$dateFormat,
		] = $this->getDateRangeAndFormat($interval, $dateStart, $dateEnd);
	
		$results = $this->calculateResults($query);
		
		return $this->formatStatisticsByStatus($results);
	}

	private function calculateResults($query)
	{
		return collect($this->statuses)->mapWithKeys(function ($status) use ($query) {
			$clonedQuery = clone $query;
			$clonedQuery->where("status", $status);
	
			Log::info("SQL Query: " . $clonedQuery->toSql(), $clonedQuery->getBindings());
	
			$totalCount = $clonedQuery->count();
			Log::info("Total Count for status $status: " . $totalCount);
	
			return [$status => $totalCount];
		});
	}
	
	private function formatStatisticsByStatus($results)
	{
		return $results->map(function ($count, $status) {
			return [
				"date" => $status,
				"total_profit" => $count,
			];
		})->values();
	}

}
