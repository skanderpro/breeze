<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PoExportSite implements FromView
{

    use Exportable;

    public function __construct(String $exportDateFrom, String $exportDateTo, String $exportpoProjectLocation)

    {
    $this->DateFrom = $exportDateFrom;
    $this->DateTo = $exportDateTo;
    $this->ProjectLocation = $exportpoProjectLocation;
    }

    public function view(): View
    {

      // return Invoice::query()->whereYear('created_at', $this->year);

      return view('exports.po', [
          'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
          ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
          ->leftJoin('users', 'pos.u_id', '=', 'users.id')
          ->where('pos.poProjectLocation','LIKE',"%$this->ProjectLocation%")
          ->whereBetween('pos.created_at', [$this->DateFrom, $this->DateTo])
          ->where('pos.companyid', Auth::user()->companyId)
          ->get()
      ]);

    }
}
