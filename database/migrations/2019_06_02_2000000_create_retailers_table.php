<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMerchantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('merchants', function (Blueprint $table) {
            $table->increments('id');
            $table->string('merchantName');
            $table->string('merchantAddress1');
            $table->string('merchantAddress2');
            $table->string('merchantCounty');
            $table->string('merchantPostcode');
            $table->string('merchantCountry');
            $table->string('merchantPhone');
            $table->string('merchantFax');
            $table->string('merchantEmail');
            $table->string('merchantWeb');
            $table->string('long');
            $table->string('lat');
            $table->string('merchantContactName');
            $table->string('merchantContactEmail');
            $table->string('merchantContactPhone');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('merchants');
    }
}
