<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Permohonan;
use App\Models\User;

class PermohonanAssignedToPentadbirMail extends Mailable
{
    use Queueable, SerializesModels;

    public $permohonan;
    public $pentadbir;
    public $pegawai;

    /**
     * Create a new message instance.
     */
    public function __construct(Permohonan $permohonan, User $pentadbir, User $pegawai)
    {
        $this->permohonan = $permohonan;
        $this->pentadbir = $pentadbir;
        $this->pegawai = $pegawai;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '[eBorang JDTM] Permohonan Baru '. $this->permohonan->id_permohonan. ' Menunggu Semakan Daripada Anda');
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.permohonan_baru',
            with: [
                'permohonan' => $this->permohonan,
                'recipient' => $this->pentadbir,
                'recipientRole' => 'Pentadbir Sistem',
                'assignedBy' => $this->pegawai,
                'customMessage' => 'Permohonan ini telah ditugaskan kepada anda oleh ' . $this->pegawai->nama . ' (Pegawai Teknologi Maklumat).',
            ]
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}