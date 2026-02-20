<?php

namespace App\Mail;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PermohonanSelesaiNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $permohonan;

    public function __construct(Permohonan $permohonan)
    {
        $this->permohonan = $permohonan;
    }

    public function build()
    {
        return $this->subject("[eBorang JDTM] Status Permohonan {$this->permohonan->id_permohonan} Telah Selesai")
                    ->view('emails.permohonan_selesai');
    }
}