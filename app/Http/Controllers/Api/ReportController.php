<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Reports\StatisticsReportFactory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
  protected $statisticsReportFactory;

  public function __construct(StatisticsReportFactory $statisticsReportFactory)
  {
    $this->middleware("auth:sanctum");
    $this->statisticsReportFactory = $statisticsReportFactory;
  }

  public function index(Request $request)
  {
    $request->validate([
      "type" => "required",
      "id" => "required",
      "interval" => "required",
      "typeReport" => "required",
    ]);

    $user = Auth::user(); // Отримуємо автентифікованого користувача
    // $this->statisticsReportFactory = new StatisticsReportFactory($user); // Передаємо користувача в конструктор
    $type = $request->input("type");
    $id = $request->input("id");
    $interval = $request->input("interval");
    $typeReport = $request->input("typeReport", "profit"); // Default to 'profit'
    $reportService = $this->statisticsReportFactory->create($typeReport);

    $statistics = $reportService->getStatistics($type, $id, $interval);

    return response()->json($statistics);
  }
}
