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
        Schema::table('permohonans', function (Blueprint $table) {
            $table->json('maklumat_akses')->nullable()->after('subkategori');
            $table->timestamp('tarikh_maklumat_akses')->nullable()->after('maklumat_akses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['maklumat_akses', 'tarikh_maklumat_akses']);
        });
    }
};