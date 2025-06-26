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
        Schema::create('workshops', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->datetime('workshop_start_date')->nullable();
            $table->datetime('workshop_end_date')->nullable();
            $table->string('time')->nullable();
            $table->string('place')->nullable();
            $table->integer('fee')->default(0);
            $table->integer('quota')->nullable();
            $table->integer('status')->default(1);
            $table->datetime('registration_start_date')->nullable();
            $table->datetime('registration_end_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workshops');
    }
};
