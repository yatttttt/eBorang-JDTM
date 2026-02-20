<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('permohonans', function (Blueprint $table) {
            // Drop columns if exist, then add them
            $columns = ['ulasan_pengarah_by', 'ulasan_pegawai_by', 'ulasan_pentadbir_sistem_by'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('permohonans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        // Now add the columns fresh
        Schema::table('permohonans', function (Blueprint $table) {
            $table->bigInteger('ulasan_pengarah_by')->unsigned()->nullable()->after('ulasan_pengarah');
            $table->bigInteger('ulasan_pegawai_by')->unsigned()->nullable()->after('ulasan_pegawai');
            $table->bigInteger('ulasan_pentadbir_sistem_by')->unsigned()->nullable()->after('ulasan_pentadbir_sistem');
        });
    }

    public function down()
    {
        Schema::table('permohonans', function (Blueprint $table) {
            $columns = ['ulasan_pengarah_by', 'ulasan_pegawai_by', 'ulasan_pentadbir_sistem_by'];
            
            foreach ($columns as $column) {
                if (Schema::hasColumn('permohonans', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};