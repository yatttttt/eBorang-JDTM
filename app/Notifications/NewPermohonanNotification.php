<?php

namespace App\Notifications;

use App\Models\Permohonan;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Notification;

/**
 * NewPermohonanNotification
 * 
 * This notification is sent via TWO channels:
 * 1. Database - Stored in notifications table for system notifications
 * 2. Broadcast - Real-time via Laravel Echo/Pusher
 * 
 * IMPORTANT: Email notifications are handled separately by existing Mail classes.
 * This notification only handles system notifications (database + broadcast).
 */
class NewPermohonanNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public $permohonan;
    public $notificationType; // 'status_update', 'new_application', 'completion', 'assignment'
    public $role; // Role that triggered the notification
    public $status; // Status update (if applicable)
    public $updatedBy; // User who performed the action
    public $ulasan; // Comment/feedback (if applicable)

    /**
     * Create a new notification instance.
     * 
     * @param Permohonan $permohonan
     * @param string $notificationType - Type of notification
     * @param string|null $role - Role that triggered (pengarah, pegawai, pentadbir_sistem, admin)
     * @param string|null $status - Status update
     * @param \App\Models\User|null $updatedBy - User who performed action
     * @param string|null $ulasan - Comment/feedback
     */
    public function __construct(
        Permohonan $permohonan,
        string $notificationType = 'new_application',
        ?string $role = null,
        ?string $status = null,
        $updatedBy = null,
        ?string $ulasan = null
    ) {
        $this->permohonan = $permohonan;
        $this->notificationType = $notificationType;
        $this->role = $role;
        $this->status = $status;
        $this->updatedBy = $updatedBy;
        $this->ulasan = $ulasan;
    }

    /**
     * Get the notification's delivery channels.
     * 
     * Returns: database and broadcast only
     * Email notifications are handled separately by existing Mail classes.
     */
    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }


    /**
     * Get the array representation of the notification for database storage.
     * 
     * This data is stored in the notifications table and used for:
     * - Displaying notifications in the dropdown
     * - Marking notifications as read
     * - Linking to the permohonan page
     */
    public function toArray($notifiable): array
    {
        $roleNames = [
            'pengarah' => 'Pengarah',
            'pegawai' => 'Pegawai',
            'pentadbir_sistem' => 'Pentadbir Sistem',
            'admin' => 'Admin'
        ];

        $roleName = $this->role ? ($roleNames[$this->role] ?? ucfirst($this->role)) : 'Sistem';
        $updatedByName = $this->updatedBy ? $this->updatedBy->nama : 'Sistem';

        // Build notification message based on type
        $message = '';
        $title = '';

        switch ($this->notificationType) {
            case 'new_application':
                $title = 'Permohonan Baru';
                $message = "Permohonan baru dengan nombor rujukan {$this->permohonan->id_permohonan} menunggu semakan anda.";
                break;

            case 'status_update':
                $title = 'Status Dikemas Kini';
                $statusText = $this->status ?? 'Dikemas Kini';
                $message = "Status permohonan {$this->permohonan->id_permohonan} telah dikemas kini oleh {$roleName} kepada {$statusText}.";
                if ($this->ulasan) {
                    $message .= " Ulasan: {$this->ulasan}";
                }
                break;

            case 'completion':
                $title = 'Permohonan Selesai';
                $message = "Permohonan {$this->permohonan->id_permohonan} telah diluluskan dan selesai oleh Pentadbir Sistem.";
                break;

            case 'assignment':
                $title = 'Permohonan Ditetapkan';
                $message = "Permohonan {$this->permohonan->id_permohonan} telah ditetapkan kepada anda untuk semakan.";
                break;

            case 'permohonan_dihantar':
                $title = 'Permohonan Berjaya Dihantar';
                $message = "Permohonan {$this->permohonan->id_permohonan} telah berjaya dihantar dan menunggu semakan lanjut.";
                break;

            default:
                $title = 'Notifikasi Permohonan';
                $message = "Anda mempunyai notifikasi baru mengenai permohonan {$this->permohonan->id_permohonan}.";
        }

        return [
            'id' => $this->permohonan->id_permohonan,
            'type' => $this->notificationType,
            'title' => $title,
            'message' => $message,
            'permohonan_id' => $this->permohonan->id_permohonan,
            'role' => $this->role,
            'role_name' => $roleName,
            'status' => $this->status,
            'updated_by' => $updatedByName,
            'ulasan' => $this->ulasan,
            'created_at' => now()->toDateTimeString(),
        ];
    }

    /**
     * Get the broadcastable representation of the notification.
     * 
     * This is sent via Laravel Echo/Pusher for real-time updates.
     */
    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'id' => $this->id,
            'type' => $this->notificationType,
            'data' => $this->toArray($notifiable),
            'read_at' => null,
            'created_at' => now()->toDateTimeString(),
        ]);
    }

    /**
     * Get the type of the notification being broadcast.
     */
    public function broadcastType(): string
    {
        return 'notification.created';
    }
}

