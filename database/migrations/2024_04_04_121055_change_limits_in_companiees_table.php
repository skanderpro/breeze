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
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn('limit_3_role');
            $table->float('limit_5_role')->nullable();
            $table->float('limit_6_role')->nullable();
            $table->float('limit_7_role')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->float('limit_3_role')->nullable();
            $table->dropColumn('limit_5_role');
            $table->dropColumn('limit_6_role');
            $table->dropColumn('limit_7_role');
        });
    }
};
