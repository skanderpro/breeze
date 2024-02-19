<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;


class PoExport implements FromView
{

    use Exportable;

    public function __construct(String $exportDateFrom, String $exportDateTo, String $exportCompany_id)

    {
    $this->DateFrom = $exportDateFrom;
    $this->DateTo = $exportDateTo;
    $this->Company_id = $exportCompany_id;
    }

    public function view(): View
    {

      // return Invoice::query()->whereYear('created_at', $this->year);

      return view('exports.po', [
          'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
          ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
          ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          ->where('pos.companyId', $this->Company_id)
          ->whereBetween('pos.created_at', [$this->DateFrom, $this->DateTo])
          ->get()
      ]);

    }
}
