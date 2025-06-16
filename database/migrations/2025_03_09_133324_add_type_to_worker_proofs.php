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
        Schema::table('worker_proofs', function (Blueprint $table) {
            $table->string('type')->after('order_id'); // Menyimpan jenis bukti
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('worker_proofs', function (Blueprint $table) {
            //
        });
    }
};
