<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;

class PoExportTask implements FromView
{

    use Exportable;

    public function __construct(string $exportDateFrom, string $exportDateTo, string $exportpoProject)
    {
        $this->DateFrom = $exportDateFrom;
        $this->DateTo = $exportDateTo;
        $this->Project = $exportpoProject;
    }

    public function view(): View
    {

        // return Invoice::query()->whereYear('created_at', $this->year);

        return view('exports.po', [
            'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
                ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
                ->leftJoin('users', 'pos.u_id', '=', 'users.id')
                ->where('pos.poProject', 'LIKE', "%$this->Project%")
                ->whereBetween('pos.created_at', [$this->DateFrom, $this->DateTo])
                ->where('pos.companyid', Auth::user()->companyId)
                ->get()
        ]);

    }
}
