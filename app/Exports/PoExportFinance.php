<?php

namespace App\Exports;

use App\Po;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

use Auth;

use Illuminate\Http\Request;

class PoExportFinance implements FromView
{

    use Exportable;

    public function __construct(String $exportDateFrom, String $exportDateTo, String $exportFinanceStatus, String $exportFinanceCompany)

    {
    $this->DateFrom = $exportDateFrom;
    $this->DateTo = $exportDateTo;
    $this->Finance = $exportFinanceStatus;
    $this->Company = $exportFinanceCompany;
    }

    public function view(): View
    {

      // return Invoice::query()->whereYear('created_at', $this->year);

      return view('exports.po', [
          'poExports' => Po::select('pos.*', 'merchants.merchantName')
          ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
          // ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          // ->where('pos.selectMerchant', $this->Merchant)
          ->where('companyId', $this->Company)
          ->where('poFinanceStatus', $this->Finance)
          ->whereBetween('pos.created_at', [$this->DateFrom, $this->DateTo])
          ->get()
      ]);

    }
}
