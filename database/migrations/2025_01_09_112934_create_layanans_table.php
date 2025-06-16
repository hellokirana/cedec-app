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
        Schema::create('layanans', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('kategori_id')->nullable();
            $table->string('image')->nullable();
            $table->string('title')->nullable();
            $table->text('konten')->nullable();
            $table->integer('harga_member')->nullable();
            $table->integer('harga_worker')->nullable();
            $table->string('featured')->default(2)->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('layanans');
    }
};
