<?php

namespace Database\Seeders;

use App\Models\Merchant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MerchantsSeeder extends Seeder
{

    protected $columnMap = [
        "Id" => "id",
        "Merchantname" => "merchantName",
        "Merchantid" => "merchantId",
        "Merchantaddress1" => "merchantAddress1",
        "Merchantaddress2" => "merchantAddress2",
        "Merchantcounty" => "merchantCounty",
        "MERCHANTPOSTCODE" => "merchantPostcode",
        "Merchantcountry" => "merchantCountry",
        "Merchantphone" => "merchantPhone",
        "Merchantfax" => "merchantFax",
        "Merchantemail" => "merchantEmail",
        "Merchantweb" => "merchantWeb",
        "Merchantplumbing" => "merchantPlumbing",
        "Merchantelectrical" => "merchantElectrical",
        "Merchantbuilders" => "merchantBuilders",
        "Merchanthire" => "merchantHire",
        "Merchantdecorating" => "merchantDecorating",
        "Merchantflooring" => "merchantFlooring",
        "Merchantauto" => "merchantAuto",
        "Merchantaggregate" => "merchantAggregate",
        "Merchantroofing" => "merchantRoofing",
        "Merchantfixings" => "merchantFixings",
        "Merchantironmongery" => "merchantIronmongery",
        "Merchanttyres" => "merchantTyres",
        "Merchanthealth" => "merchantHealth",
        "Lng" => "lng",
        "Lat" => "lat",
        "Merchantcontactname" => "merchantContactName",
        "Merchantcontactemail" => "merchantContactEmail",
        "Merchantcontactphone" => "merchantContactPhone",
        "Created_At" => "created_at",
        "Updated_At" => "updated_at",
        "Green_Supplier" => "green_supplier",
        "Parent_Id" => "parent_id",
        "Disabled" => "disabled",
        "Merchantphonecode" => "merchantPhoneCode",
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $merchants = require realpath(app_path('../database/seeders/suppliers_data_array.php'));

        foreach ($merchants as $merchant) {
            $payload = [];

            foreach ($this->columnMap as $key => $value) {
                $payload[$value] = $merchant[$key];
            }

//            unset($payload['id']);

            Merchant::create($payload);
        }


    }
}
