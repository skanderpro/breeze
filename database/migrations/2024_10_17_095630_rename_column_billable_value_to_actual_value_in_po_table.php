<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  public function up(): void
  {
    Schema::table("pos", function (Blueprint $table) {
      $table->float("actual_value")->nullable();
    });

    // Then dropping the old column after creating the new one
    Schema::table("pos", function (Blueprint $table) {
      $table->dropColumn("billable_value");
    });
  }

  public function down(): void
  {
    Schema::table("pos", function (Blueprint $table) {
      $table->float("billable_value")->nullable();
    });

    // Then dropping the new column after creating the old one
    Schema::table("pos", function (Blueprint $table) {
      $table->dropColumn("actual_value");
    });
  }
};
