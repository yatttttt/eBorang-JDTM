<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::table('permohonans', function (Blueprint $table) {
        $table->string('status_pentadbir_sistem')->nullable()->after('status_pegawai');
        $table->text('ulasan_pentadbir_sistem')->nullable()->after('tarikh_ulasan_pegawai');
        $table->timestamp('tarikh_ulasan_pentadbir_sistem')->nullable()->after('ulasan_pentadbir_sistem');
    });
}

public function down()
{
    Schema::table('permohonans', function (Blueprint $table) {
        $table->dropColumn(['status_pentadbir_sistem', 'ulasan_pentadbir_sistem', 'tarikh_ulasan_pentadbir_sistem']);
    });
}
};