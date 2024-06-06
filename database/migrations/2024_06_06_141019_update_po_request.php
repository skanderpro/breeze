<?php

use App\Models\Po;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('pos', function (Blueprint $table) {
            $table->string('request_file')->nullable();
            $table->decimal('taxed_value', 15, 2)->nullable();
        });

        DB::transaction(function () {
            Po::query()
                ->where('poType', 'request')
                ->update([
                    'is_request' => 1,
                    'poType' => 'Pre Approved'
                ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
