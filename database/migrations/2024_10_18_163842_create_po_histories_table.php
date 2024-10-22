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
    Schema::create("po_histories", function (Blueprint $table) {
      $table->id();
      $table->string("action")->nullable();
      $table->string("data", 500)->nullable();
      $table->unsignedInteger("po_id");
      $table
        ->foreign("po_id")
        ->references("id")
        ->on("pos")
        ->onDelete("cascade");
      $table->unsignedBigInteger("user_id");
      $table
        ->foreign("user_id")
        ->references("id")
        ->on("users")
        ->onDelete("cascade");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists("po_histories");
  }
};
