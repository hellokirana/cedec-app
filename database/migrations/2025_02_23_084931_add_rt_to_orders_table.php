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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('rt', 3)->nullable()->after('alamat'); // Tambahkan kolom rt
            $table->string('rw', 3)->nullable()->after('rt'); // Tambahkan kolom rw setelah rt
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(columns: ['rt', 'rw']);
        });
    }
};
