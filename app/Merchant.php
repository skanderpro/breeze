<?php

namespace App;

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
        'lng',
        'lat',
        'merchantContactName',
        'merchantContactEmail',
        'merchantContactPhone'
    ];
}
