<?php

namespace App\Http\Controllers;

use App\Enums\Permission;
use App\Http\Controllers\Traits\MerchantControllerTrait;
use App\Models\Merchant;
use App\Services\AccessCheckInterface;
use Illuminate\Http\Request;
use App\Exports\MerchantExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Maatwebsite\Excel\Facades\Excel;


class MerchantController extends Controller
{
    use MerchantControllerTrait;


    public function addMerchant(AccessCheckInterface $accessCheck)
    {

        if (!$accessCheck->check(Permission::MERCHANT_MANAGE_ALL)) {
            return Redirect::to('/');
        } else {
            return view('merchant-create');
        }


    }

    public function createMerchant(Request $request)
    {
        $this->store($request);

        return Redirect::to('merchant-list')->with('message', 'Merchant successfully added');

    }

    public function findMerchant()
    {

        Excel::store(new MerchantExport, 'public/em.csv');

        // return view('merchant-find', compact('results', 'content'));
        return view('merchant-find');
        // return view('merchant-find');


    }

    public function resultsMerchant()
    {

        return view('merchant-find');

    }

    public function showMerchant(Request $request, AccessCheckInterface $accessCheck)
    {

        $search = $request->get('search');


        if ($search != "") {
            $merchants = DB::table('merchants')
                ->where('merchantName', 'LIKE', "%$search%")
                ->orwhere('merchantId', 'LIKE', "%$search%")
                ->orwhere('merchantAddress1', 'LIKE', "%$search%")
                ->orwhere('merchantAddress2', 'LIKE', "%$search%")
                ->orwhere('merchantPostcode', 'LIKE', "%$search%")
                ->orwhere('merchantEmail', 'LIKE', "%$search%")
                ->orderBy('merchantName', 'asc')
                ->paginate(1000);
        } else {
            $merchants = DB::table('merchants')->paginate(25);
        }


        // Merchant::all()->paginate(25);

        if (!$accessCheck->check(Permission::MERCHANT_MANAGE_ALL)) {
            return Redirect::to('/');
        } else {
            return view('merchant-list', compact('merchants', 'search'));
        }


    }

    public function detailsMerchant($id)
    {

        $merchants = Merchant::where('id', '=', $id)->firstOrFail();


        return view('merchant-edit', compact('merchants'));

    }

    public function editMerchant($id, Request $request)
    {

        $this->update($id, $request);

        return Redirect::to("/merchant-edit/$id")
            ->with('message', 'Merchant successfully edited');

    }

    public function removeMerchant($id)
    {

        $merchants = Merchant::find($id);

        $merchants->delete();

        return Redirect::to('merchant-list')->with('message', 'Merchant removed');
    }

}
