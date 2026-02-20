<?php

namespace App\Observers;

use App\Models\Permohonan;
use Illuminate\Support\Facades\Log;

class PermohonanObserver
{
    /**
     * Handle the Permohonan "creating" event
     */
    public function creating(Permohonan $permohonan): void
    {
        // Set initial status for new records BEFORE saving
        $permohonan->determineOverallStatus();
        
        Log::info('PermohonanObserver:creating - Status set', [
            'id' => $permohonan->id_permohonan ?? 'NEW',
            'status' => $permohonan->status_permohonan
        ]);
    }

    /**
     * Handle the Permohonan "saving" event.
     */
    public function saving(Permohonan $permohonan): void
    {
        // Only run the determination logic if any of the stage status columns have been modified.
        if ($permohonan->isDirty([
            'status_pengarah', 
            'status_pegawai', 
            'status_pentadbir_sistem',
        ])) {
            $permohonan->determineOverallStatus();
            
            Log::info('PermohonanObserver:saving - Status updated', [
                'id' => $permohonan->id_permohonan,
                'status' => $permohonan->status_permohonan,
                'pengarah' => $permohonan->status_pengarah,
                'pegawai' => $permohonan->status_pegawai,
                'pentadbir' => $permohonan->status_pentadbir_sistem
            ]);
        }
    }

    /**
     * Handle the Permohonan "created" event
     */
    public function created(Permohonan $permohonan): void
    {
        Log::info('PermohonanObserver:created - Permohonan created successfully', [
            'id' => $permohonan->id_permohonan,
            'status' => $permohonan->status_permohonan,
            'nama' => $permohonan->nama_pemohon
        ]);
    }

    /**
     * Handle the Permohonan "updated" event.
     */
    public function updated(Permohonan $permohonan): void
    {
        Log::info('PermohonanObserver:updated', [
            'id' => $permohonan->id_permohonan,
            'status' => $permohonan->status_permohonan
        ]);
    }
    
    /**
     * Handle the Permohonan "deleted" event.
     */
    public function deleted(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "restored" event.
     */
    public function restored(Permohonan $permohonan): void
    {
        //
    }

    /**
     * Handle the Permohonan "force deleted" event.
     */
    public function forceDeleted(Permohonan $permohonan): void
    {
        //
    }
}