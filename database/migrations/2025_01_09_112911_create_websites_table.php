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
        Schema::create('websites', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('url')->nullable();
            $table->string('nama')->nullable();
            $table->string('caption')->nullable();

            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();

            $table->text('map')->nullable();
            $table->string('alamat')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();

            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->string('x')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('websites');
    }
};
