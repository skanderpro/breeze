<?php

namespace App\Exports;

use App\Merchant;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class MerchantExport implements FromView
{
    public function view(): View
    {
        return view('exports.merchants', [
            'merchants' => Merchant::all()
        ]);
    }
}
