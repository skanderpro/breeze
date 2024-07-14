<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MerchantControllerTrait;
use App\Http\Resources\MerchantResource;
use App\Models\Merchant;
use Illuminate\Http\Request;

class MerchantController extends Controller
{
    use MerchantControllerTrait;

    public function index(Request $request)
    {
        $qb = Merchant::query();

        $search = $request->get('search');
        if (!empty($search)) {
            $qb = $qb
                ->where(function ($query) use ($search) {
                      $query->where('merchantName','LIKE',"%$search%")
                      ->orwhere('merchantId','LIKE',"%$search%")
                      ->orwhere('merchantAddress1','LIKE',"%$search%")
                      ->orwhere('merchantAddress2','LIKE',"%$search%")
                      ->orwhere('merchantPostcode','LIKE',"%$search%")
                      ->orwhere('merchantEmail','LIKE',"%$search%");
                })
                ->orderBy('merchantName', 'asc');
        }

        $name = $request->get('name');
        if (!empty($name)) {
            $qb = $qb->where('merchantName', 'like', '%' . $name . '%');
        }

        $merchantId = $request->get('merchant_id');
        if (!empty($merchantId)) {
            $qb = $qb->where('merchantId', $merchantId);
        }

        $greenSupplier = $request->get('green_supplier');
        if (!empty($greenSupplier)) {
            $qb = $qb->where('green_supplier', '1');
        }

        $merchantPlumbing = $request->get('merchantPlumbing');
        if (!empty($merchantPlumbing)) {
            $qb = $qb->where('merchantPlumbing', $merchantPlumbing);
        }

        $merchantElectrical = $request->get('merchantElectrical');
        if (!empty($merchantElectrical)) {
            $qb = $qb->where('merchantElectrical', $merchantElectrical);
        }

        $merchantBuilders = $request->get('merchantBuilders');
        if (!empty($merchantBuilders)) {
            $qb = $qb->where('merchantBuilders', $merchantBuilders);
        }

        $merchantHire = $request->get('merchantHire');
        if (!empty($merchantHire)) {
            $qb = $qb->where('merchantHire', $merchantHire);
        }

        $merchantDecorating = $request->get('merchantDecorating');
        if (!empty($merchantDecorating)) {
            $qb = $qb->where('merchantDecorating', $merchantDecorating);
        }

        $merchantFlooring = $request->get('merchantFlooring');
        if (!empty($merchantFlooring)) {
            $qb = $qb->where('merchantFlooring', $merchantFlooring);
        }

        $merchantAuto = $request->get('merchantAuto');
        if (!empty($merchantAuto)) {
            $qb = $qb->where('merchantAuto', $merchantAuto);
        }

        $merchantAggregate = $request->get('merchantAggregate');
        if (!empty($merchantAggregate)) {
            $qb = $qb->where('merchantAggregate', $merchantAggregate);
        }

        $merchantRoofing = $request->get('merchantRoofing');
        if (!empty($merchantRoofing)) {
            $qb = $qb->where('merchantRoofing', $merchantRoofing);
        }

        $merchantFixing = $request->get('merchantFixing');
        if (!empty($merchantFixing)) {
            $qb = $qb->where('merchantFixing', $merchantFixing);
        }

        $merchantIronmongrey = $request->get('merchantIronmongrey');
        if (!empty($merchantIronmongrey)) {
            $qb = $qb->where('merchantIronmongrey', $merchantIronmongrey);
        }

        $merchantTyres = $request->get('merchantTyres');
        if (!empty($merchantTyres)) {
            $qb = $qb->where('merchantTyres', $merchantTyres);
        }

        $merchantHealth = $request->get('merchantHealth');
        if (!empty($merchantHealth)) {
            $qb = $qb->where('merchantHealth', $merchantHealth);
        }

        return MerchantResource::collection($qb->get());
    }

    public function createMerchant(Request $request)
    {
        $merchant = $this->store($request);

        return MerchantResource::make($merchant);
    }

    public function updateMerchant($id, Request $request)
    {
        $merchant = $this->update($id, $request);

        return MerchantResource::make($merchant);
    }

    public function toggle(Merchant $merchant, Request $request)
    {
        $merchant->disabled = !$merchant->disabled;
        $merchant->save();

        return MerchantResource::make($merchant);
    }
}
