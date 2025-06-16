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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('layanan_id')->nullable();
            $table->foreignUuid('customer_id')->nullable();
            $table->foreignUuid('worker_id')->nullable();
            $table->foreignUuid('bank_id')->nullable();
            $table->integer('harga_member')->nullable();
            $table->integer('harga_worker')->nullable();
            $table->integer('nominal')->nullable();
            $table->datetime('waktu')->nullable();
            $table->string('alamat')->nullable();
            $table->string('tanggal')->nullable();
            $table->string('dari_bank')->nullable();
            $table->string('nominal_transfer')->nullable();
            $table->string('bukti_transfer')->nullable();
            $table->char('village_code', 15)->nullable();
            $table->char('district_code', 7)->nullable();
            $table->char('city_code', 4)->nullable();
            $table->char('province_code', 2)->nullable();
            $table->integer('status_pembayaran')->default(1);
            $table->integer('status_order')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
