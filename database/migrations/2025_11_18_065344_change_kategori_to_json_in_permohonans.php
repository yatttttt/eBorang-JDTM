<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add temporary columns for JSON data
        Schema::table('permohonans', function (Blueprint $table) {
            $table->json('kategori_temp')->nullable()->after('kategori');
            $table->json('subkategori_temp')->nullable()->after('subkategori');
        });
        
        // Step 2: Convert existing data to JSON format
        $permohonans = DB::table('permohonans')->get();
        
        foreach ($permohonans as $permohonan) {
            $updates = [];
            
            // Convert kategori
            if (!empty($permohonan->kategori)) {
                // If already looks like JSON array
                if (str_starts_with(trim($permohonan->kategori), '[')) {
                    $updates['kategori_temp'] = $permohonan->kategori;
                } else {
                    // Convert comma-separated to JSON array
                    $items = array_map('trim', explode(',', $permohonan->kategori));
                    $updates['kategori_temp'] = json_encode($items);
                }
            }
            
            // Convert subkategori
            if (!empty($permohonan->subkategori)) {
                if (str_starts_with(trim($permohonan->subkategori), '[')) {
                    $updates['subkategori_temp'] = $permohonan->subkategori;
                } else {
                    $items = array_map('trim', explode(',', $permohonan->subkategori));
                    $updates['subkategori_temp'] = json_encode($items);
                }
            }
            
            if (!empty($updates)) {
                DB::table('permohonans')
                    ->where('id_permohonan', $permohonan->id_permohonan)
                    ->update($updates);
            }
        }
        
        // Step 3: Drop old columns
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'subkategori']);
        });
        
        // Step 4: Rename temp columns to original names
        Schema::table('permohonans', function (Blueprint $table) {
            $table->renameColumn('kategori_temp', 'kategori');
            $table->renameColumn('subkategori_temp', 'subkategori');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add temporary VARCHAR columns
        Schema::table('permohonans', function (Blueprint $table) {
            $table->string('kategori_temp', 50)->nullable()->after('kategori');
            $table->string('subkategori_temp', 50)->nullable()->after('subkategori');
        });
        
        // Convert JSON back to VARCHAR
        $permohonans = DB::table('permohonans')->get();
        
        foreach ($permohonans as $permohonan) {
            $updates = [];
            
            if (!empty($permohonan->kategori)) {
                $array = json_decode($permohonan->kategori, true);
                $updates['kategori_temp'] = is_array($array) ? implode(', ', $array) : $permohonan->kategori;
            }
            
            if (!empty($permohonan->subkategori)) {
                $array = json_decode($permohonan->subkategori, true);
                $updates['subkategori_temp'] = is_array($array) ? implode(', ', $array) : $permohonan->subkategori;
            }
            
            if (!empty($updates)) {
                DB::table('permohonans')
                    ->where('id_permohonan', $permohonan->id_permohonan)
                    ->update($updates);
            }
        }
        
        // Drop JSON columns
        Schema::table('permohonans', function (Blueprint $table) {
            $table->dropColumn(['kategori', 'subkategori']);
        });
        
        // Rename back
        Schema::table('permohonans', function (Blueprint $table) {
            $table->renameColumn('kategori_temp', 'kategori');
            $table->renameColumn('subkategori_temp', 'subkategori');
        });
    }
};