<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('po', function (Blueprint $table) {
            $table->increments('id');
            $table->string('poNumber');
            $table->string('companyId');
            $table->string('poType');
            $table->string('poPurpose');
            $table->string('poProject');
            $table->string('poProjectLocation');
            $table->string('poInvoice');
            $table->string('poPod');
            $table->string('poCompanyPo');
            $table->string('poCancelled');
            $table->string('poCompleted');
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
        Schema::dropIfExists('po');
    }
}
