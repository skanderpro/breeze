<?php

namespace App\Http\Controllers\Traits;

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
        ]);

        $editMerchant = Merchant::findOrFail($id);
        $input = $request->all();
        $input['green_supplier'] = $request->input('green_supplier', false);

        $editMerchant->fill($input)->save();

        return $editMerchant;
    }
}
