<?php

namespace App\Mail;

use App\Models\Permohonan;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PermohonanStatusUpdated extends Mailable
{
    use Queueable, SerializesModels;

    public $permohonan;
    public $updatedBy;
    public $role;
    public $status;
    public $ulasan;

    /**
     * Create a new message instance.
     *
     * @param Permohonan $permohonan
     * @param User $updatedBy
     * @param string $role (pengarah/pegawai/pentadbir_sistem)
     * @param string $status
     * @param string|null $ulasan
     */
    public function __construct(Permohonan $permohonan, User $updatedBy, string $role, string $status, ?string $ulasan = null)
    {
        $this->permohonan = $permohonan;
        $this->updatedBy = $updatedBy;
        $this->role = $role;
        $this->status = $status;
        $this->ulasan = $ulasan;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $roleNames = [
            'pengarah' => 'Pengarah',
            'pegawai' => 'Pegawai',
            'pentadbir_sistem' => 'Pentadbir Sistem'
        ];

        $roleName = $roleNames[$this->role] ?? ucfirst($this->role);

        return $this->subject("[eBorang JDTM] Status Permohonan {$this->permohonan->id_permohonan} Dikemas Kini dari {$roleName}") ->markdown('emails.permohonan_status_updated');
    }
}
