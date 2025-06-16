<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('rt', 3)->nullable()->after('alamat'); // Tambahkan kolom rt
            $table->string('rw', 3)->nullable()->after('rt'); // Tambahkan kolom rw setelah rt
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(columns: ['rt', 'rw']); // Hapus kolom jika rollback
        });
    }
};
