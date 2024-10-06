<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    protected $fillable = [
        'merchantName',
        'merchantId',
        'merchantAddress1',
        'merchantAddress2',
        'merchantCounty',
        'merchantPostcode',
        'merchantCountry',
        'merchantPhone',
        'merchantFax',
        'merchantEmail',
        'merchantWeb',
        'merchantPlumbing',
        'merchantElectrical',
        'merchantBuilders',
        'merchantHire',
        'merchantDecorating',
        'merchantFlooring',
        'merchantAuto',
        'merchantAggregate',
        'merchantRoofing',
        'merchantFixings',
        'merchantIronmongery',
        'merchantTyres',
        'merchantHealth',
        'green_supplier',
        'lng',
        'lat',
        'disabled',
        'merchantContactName',
        'merchantContactEmail',
        'merchantContactPhone',
        'parent_id'
    ];

    public function getAddress()
    {
        $addressParts = [];
        if (!empty($this->merchantAddress1)) {
            $addressParts[] = $this->merchantAddress1;
        }

        if (!empty($this->merchantAddress2)) {
            $addressParts[] = $this->merchantAddress2;
        }

        return implode(', ', $addressParts);
    }
}
