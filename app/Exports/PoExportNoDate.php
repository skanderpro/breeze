<?php

namespace App\Exports;

use App\Models\Po;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class PoExportNoDate implements FromView
{


    public function view(): View
    {

      if (Auth::user()->accessLevel == '1') {

        return view('exports.po', [
            'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
            ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
            ->leftJoin('users', 'pos.u_id', '=', 'users.id')
            ->get()
        ]);

      }

      if (Auth::user()->accessLevel == '2') {

        return view('exports.po', [
            'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
            ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
            ->leftJoin('users', 'pos.u_id', '=', 'users.id')
            ->where('pos.companyId', '=', Auth::user()->companyId)
            ->get()
        ]);

      }

      if (Auth::user()->accessLevel == '3') {

        return view('exports.po', [
            'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
            ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
            ->leftJoin('users', 'pos.u_id', '=', 'users.id')
            ->where('u_id', '=', Auth::user()->id)
            ->get()
        ]);

      }



    }
}
