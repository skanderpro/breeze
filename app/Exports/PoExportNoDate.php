<?php

namespace App\Exports;

use App\Enums\Permission;
use App\Models\Po;
use App\Services\AccessCheckInterface;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class PoExportNoDate implements FromView
{


    public function view(AccessCheckInterface $accessCheck): View
    {

      if ($accessCheck->check(Permission::PO_EXPORT_ALL)) {

        return view('exports.po', [
            'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
            ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
            ->leftJoin('users', 'pos.u_id', '=', 'users.id')
            ->get()
        ]);

      }

      if ($accessCheck->check(Permission::PO_EXPORT_COMPANY)) {

        return view('exports.po', [
            'poExports' => Po::select('pos.*', 'merchants.merchantName', 'users.name')
            ->leftJoin('merchants', 'pos.selectMerchant', '=', 'merchants.id')
            ->leftJoin('users', 'pos.u_id', '=', 'users.id')
            ->where('pos.companyId', '=', Auth::user()->companyId)
            ->get()
        ]);

      }

      if ($accessCheck->check(Permission::PO_EXPORT_CLIENT)) {

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
