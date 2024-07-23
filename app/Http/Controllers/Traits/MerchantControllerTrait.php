<?php

namespace App\Http\Controllers\Traits;

use App\Http\Resources\CompanyResource;
use App\Http\Resources\MerchantResource;
use App\Models\Company;
use App\Models\Merchant;
use Illuminate\Http\Request;

trait MerchantControllerTrait
{
    public function store(Request $request)
    {
        $payload = $this->validate($request, [
            'merchantName' => 'required|max:255',
            'merchantId' => 'required|max:255',
            'merchantAddress1' => 'required|max:255',
            'merchantAddress2' => 'required|max:255',
            'merchantCounty' => 'required|max:255',
            'merchantPostcode' => 'required|max:10',
            'merchantPhone' => 'required|max:22',
            'merchantEmail' => 'required|max:255',

            'alt_merchant_name' => 'nullable',
            'alt_merchant_contact' => 'nullable',

            'lng' => 'required|max:12',
            'lat' => 'required|max:12',
        ]);

        $payload['green_supplier'] = $request->input('green_supplier', false);

        return Merchant::create($payload);
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'merchantName' => 'required|max:255',
            'merchantId' => 'required|max:255',
            'merchantAddress1' => 'required|max:255',
            'merchantAddress2' => 'required|max:255',
            'merchantCounty' => 'required|max:255',
            'merchantPostcode' => 'required|max:10',
            'merchantPhone' => 'required|max:22',
            'merchantEmail' => 'required|max:255',
            'lng' => 'required|max:12',
            'lat' => 'required|max:12',

            'merchantPlumbing' => 'nullable',
            'merchantElectrical' => 'nullable',
            'merchantBuilders' => 'nullable',
            'merchantHire' => 'nullable',
            'merchantDecorating' => 'nullable',
            'merchantFlooring' => 'nullable',
            'merchantAuto' => 'nullable',
            'merchantAggregate' => 'nullable',
            'merchantRoofing' => 'nullable',
            'merchantFixing' => 'nullable',
            'merchantIronmongrey' => 'nullable',
            'merchantTyres' => 'nullable',
            'merchantHealth' => 'nullable',
        ]);

        $editMerchant = Merchant::findOrFail($id);
        $input = $request->all();
        $input['green_supplier'] = $request->input('green_supplier', false);

        $editMerchant->fill($input)->save();

        return $editMerchant;
    }

    public function findByParent($parent_id)
    {
        $branches = Merchant::where('parent_id', $parent_id)->get();
        return MerchantResource::collection($branches);
    }
}
