<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('no_kawalan', 255)->nullable()->after('id_permohonan');
            $table->string('jenis_permohonan', 255)->nullable()->after('no_kawalan');
        });
    }

    public function down(): void
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['no_kawalan', 'jenis_permohonan']);
        });
    }
};