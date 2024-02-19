<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PoExportMerchant implements FromView
{

    use Exportable;

    public function __construct(String $exportDateFrom, String $exportDateTo, String $exportmerchant_id)

    {
    $this->DateFrom = $exportDateFrom;
    $this->DateTo = $exportDateTo;
    $this->Merchant = $exportmerchant_id;
    }

    public function view(): View
    {

      // return Invoice::query()->whereYear('created_at', $this->year);

      return view('exports.po', [
          'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
          ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
          ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          ->where('pos.selectMerchant', $this->Merchant)
          // ->where('pos.companyid', Auth::user()->companyId)
          ->whereBetween('pos.created_at', [$this->DateFrom, $this->DateTo])
          ->get()
      ]);

    }
}
