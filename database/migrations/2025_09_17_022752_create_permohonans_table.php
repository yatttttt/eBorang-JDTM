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
        Schema::create('permohonans', function (Blueprint $table) {
            $table->id('id_permohonan');
            $table->string('nama_pemohon', 100);
            $table->string('no_kp', 25); 
            $table->string('jawatan', 100);
            $table->string('jabatan', 100);
            $table->string('fail_borang', 255);
            $table->timestamp('tarikh_hantar')->useCurrent();
            $table->string('status_pengarah', 50)->nullable();
            $table->string('status_pegawai', 50)->nullable();
            $table->string('status_permohonan', 50)->nullable();
            $table->text('ulasan_pengarah')->nullable();
            $table->dateTime('tarikh_ulasan_pengarah')->nullable();
            $table->text('ulasan_pegawai')->nullable();
            $table->dateTime('tarikh_ulasan_pegawai')->nullable();
            $table->string('kategori', 50);
            $table->text('subkategori')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('permohonans');
    }
};
