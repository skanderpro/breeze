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
            $table->unsignedInteger('created_by_id')->nullable();
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->string('url')->nullable();
            $table->string('companyContactPhone')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            $table->dropColumn('created_by_id');
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('url');
        });
    }
};
