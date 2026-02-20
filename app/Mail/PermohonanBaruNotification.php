<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PermohonanBaruNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $permohonan;
    public $recipientRole;

    public function __construct(Permohonan $permohonan, string $recipientRole)
    {
        $this->permohonan = $permohonan;
        $this->recipientRole = $recipientRole;
    }

    public function build()
    {
        $roleNames = [
            'pengarah' => 'Pengarah',
            'pegawai' => 'Pegawai',
            'pentadbir_sistem' => 'Pentadbir Sistem'
        ];

        $roleName = $roleNames[$this->recipientRole] ?? ucfirst($this->recipientRole);

        return $this->subject("[eBorang JDTM] Permohonan Baru {$this->permohonan->id_permohonan} - Menunggu Semakan Daripada Anda {$roleName}")
                    ->view('emails.permohonan_baru');
    }
}