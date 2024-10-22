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
    Schema::create("po_notes", function (Blueprint $table) {
      $table->id();
      $table->string("note", 500)->nullable();
      $table->unsignedInteger("po_id");
      $table
        ->foreign("po_id")
        ->references("id")
        ->on("pos")
        ->onDelete("cascade");
      $table->timestamps();
    });
  }

  /**
   * Reverse the migrations.
   */
  public function down(): void
  {
    Schema::dropIfExists("po_notes");
  }
};
