<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PoExportEngineer implements FromView
{

    use Exportable;

    public function __construct(String $exportDateFrom, String $exportDateTo, String $exportu_id)

    {
    $this->DateFrom = $exportDateFrom;
    $this->DateTo = $exportDateTo;
    $this->exportu_id = $exportu_id;
    }

    public function view(): View
    {

      // return Invoice::query()->whereYear('created_at', $this->year);

      return view('exports.po', [
          'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
          ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
          ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          ->where('pos.u_id', $this->exportu_id)
          // ->where('pos.companyid', Auth::user()->companyId)
          ->whereBetween('pos.created_at', [$this->DateFrom, $this->DateTo])
          ->get()
      ]);

    }
}
