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
