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
        Schema::create('ulasans', function (Blueprint $table) {
        $table->id('id_ulasan');
        $table->unsignedBigInteger('id_permohonan');
        $table->unsignedBigInteger('id_user_pengulas');
        $table->enum('peranan_pengulas', ['pengarah','pegawai']);
        $table->text('ulasan');
        $table->string('status', 50);
        $table->timestamp('tarikh_ulasan')->useCurrent();
        $table->timestamps();

        // Foreign keys
        $table->foreign('id_permohonan')
        ->references('id_permohonan')
        ->on('permohonans')
        ->onDelete('cascade');
        $table->foreign('id_user_pengulas')
        ->references('id_user')
        ->on('users')
        ->onDelete('cascade');
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ulasans');
    }
};
