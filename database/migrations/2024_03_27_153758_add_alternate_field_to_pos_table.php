<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            $table->string('alt_merchant_name')->nullable();
            $table->string('alt_merchant_contact')->nullable();
            $table->unsignedInteger('contract_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            $table->dropColumn('alt_merchant_name');
            $table->dropColumn('alt_merchant_contact');
            $table->dropColumn('contract_id');
        });
    }
};
