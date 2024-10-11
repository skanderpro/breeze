<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
  /**
   * Run the migrations.
   */
  public function up(): void
  {
    Schema::create("lockout_companies_merchants", function (Blueprint $table) {
      $table->id();
      $table->unsignedInteger("company_id")->nullable();
      $table->unsignedInteger("merchant_id")->nullable();
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists("lockout_companies_merchants");
  }
};
