<?php

namespace App\Helpers;

use App\Models\User;
use App\Models\Permohonan;
use App\Mail\PermohonanStatusUpdated;
use App\Notifications\NewPermohonanNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;


class NotificationHelper
{
    /**
     * Send email notification to all admins
     */
    public static function notifyAdmins(
        Permohonan $permohonan, 
        User $updatedBy, 
        string $role, 
        string $status, 
        ?string $ulasan = null
    ): void
    {
        try {
            // Get all admin users
            $admins = User::where('peranan', 'admin')->get();

            if ($admins->isEmpty()) {
                Log::warning('No admins found to send notification', [
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
                return;
            }

            // Send email AND system notification to each admin
            // Email uses existing Mail class, system notification uses database + broadcast only
            foreach ($admins as $admin) {
                try {
                    // Send email (existing functionality)
                    Mail::to($admin->email)->send(
                        new PermohonanStatusUpdated($permohonan, $updatedBy, $role, $status, $ulasan)
                    );

                    // Send system notification (database + broadcast only, no email)
                    $admin->notify(
                        new NewPermohonanNotification(
                            $permohonan,
                            'status_update',
                            $role,
                            $status,
                            $updatedBy,
                            $ulasan
                        )
                    );

                    Log::info('Email and notification sent to admin', [
                        'admin_email' => $admin->email,
                        'admin_name' => $admin->nama,
                        'permohonan_id' => $permohonan->id_permohonan,
                        'role' => $role,
                        'status' => $status
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send email/notification to admin', [
                        'admin_email' => $admin->email,
                        'error' => $e->getMessage(),
                        'permohonan_id' => $permohonan->id_permohonan
                    ]);
                }
            }

            Log::info('Notification process completed', [
                'permohonan_id' => $permohonan->id_permohonan,
                'total_admins' => $admins->count(),
                'role' => $role,
                'status' => $status
            ]);

        } catch (\Exception $e) {
            Log::error('Error in notifyAdmins helper', [
                'error' => $e->getMessage(),
                'permohonan_id' => $permohonan->id_permohonan
            ]);
        }
    }

    /**
     * Send "new application" email to next reviewer in workflow
     */
    public static function notifyNextReviewer(Permohonan $permohonan, string $nextRole): void
    {
        try {
            // Get users with the next reviewer role
            $users = User::where('peranan', $nextRole)->get();
            
            if ($users->isEmpty()) {
                Log::warning("No users found for next reviewer", [
                    'role' => $nextRole,
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
                return;
            }
            
            // Send "Permohonan Baru" email AND system notification to next reviewer
            // Email uses existing Mail class, system notification uses database + broadcast only
            foreach ($users as $user) {
                try {
                    // Send email (existing functionality)
                    Mail::to($user->email)->send(
                        new \App\Mail\PermohonanBaruNotification($permohonan, $nextRole)
                    );
                    
                    // Send system notification (database + broadcast only, no email)
                    $user->notify(
                        new NewPermohonanNotification(
                            $permohonan,
                            'new_application',
                            $nextRole,
                            null,
                            null,
                            null
                        )
                    );
                    
                    Log::info('New application email and notification sent to next reviewer', [
                        'recipient_email' => $user->email,
                        'recipient_name' => $user->nama,
                        'recipient_role' => $nextRole,
                        'permohonan_id' => $permohonan->id_permohonan
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send new application email/notification', [
                        'recipient_email' => $user->email,
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in notifyNextReviewer', [
                'error' => $e->getMessage(),
                'permohonan_id' => $permohonan->id_permohonan
            ]);
        }
    }

    /**
     * Send "completed" email to admins when Pentadbir Sistem approves
     */
    public static function notifyApplicationCompleted(Permohonan $permohonan): void
    {
        try {
            // Get all admin users
            $admins = User::where('peranan', 'admin')->get();
            
            if ($admins->isEmpty()) {
                Log::warning('No admins found for completion notification');
                return;
            }
            
            // Send completion email AND system notification to each admin
            // Email uses existing Mail class, system notification uses database + broadcast only
            foreach ($admins as $admin) {
                try {
                    // Send email (existing functionality)
                    Mail::to($admin->email)->send(
                        new \App\Mail\PermohonanSelesaiNotification($permohonan)
                    );
                    
                    // Send system notification (database + broadcast only, no email)
                    $admin->notify(
                        new NewPermohonanNotification(
                            $permohonan,
                            'completion',
                            'pentadbir_sistem',
                            'Lulus',
                            null,
                            null
                        )
                    );
                    
                    Log::info('Completion email and notification sent to admin', [
                        'admin_email' => $admin->email,
                        'admin_name' => $admin->nama,
                        'permohonan_id' => $permohonan->id_permohonan
                    ]);
                } catch (\Exception $e) {
                    Log::error('Failed to send completion email/notification', [
                        'admin_email' => $admin->email,
                        'error' => $e->getMessage()
                    ]);
                }
            }
        } catch (\Exception $e) {
            Log::error('Error in notifyApplicationCompleted', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send "submitted successfully" notification to the admin who submitted
     * This is sent when permohonan is first submitted
     * Only the specific admin who submitted will receive the notification
     *
     * @param Permohonan $permohonan
     * @param User $admin
     */
    public static function notifyAdminsApplicationSubmitted(Permohonan $permohonan, User $admin): void
    {
        try {
            if (!$admin) {
                Log::warning('No admin provided for application submitted notification');
                return;
            }

            $admin->notify(
                new NewPermohonanNotification(
                    $permohonan,
                    'permohonan_dihantar',
                    null,
                    null,
                    null,
                    null
                )
            );

            Log::info('Application submitted notification sent to admin', [
                'admin_email' => $admin->email,
                'admin_name' => $admin->nama,
                'permohonan_id' => $permohonan->id_permohonan
            ]);
        } catch (\Exception $e) {
            Log::error('Error in notifyAdminsApplicationSubmitted', [
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Notify specific user about permohonan assignment
     * 
     * @param User $user - The user to notify
     * @param Permohonan $permohonan - The permohonan
     * @param string $notificationType - Type of notification
     * @param User|null $actionBy - User who performed the action
     */
    public static function notifySpecificUser($user, $permohonan, $notificationType, $actionBy = null)
    {
        try {
            $emailClass = null;
            
            switch ($notificationType) {
                case 'pegawai_approved':
                    // Notification to Pentadbir Sistem when assigned by Pegawai
                    $emailClass = new \App\Mail\PermohonanAssignedToPentadbirMail($permohonan, $user, $actionBy);
                    break;
                    
                default:
                    Log::warning('Unknown notification type for specific user', [
                        'type' => $notificationType,
                        'user_id' => $user->id_user
                    ]);
                    return false;
            }
            
            if ($emailClass) {
                // Send email (existing functionality)
                Mail::to($user->email)->send($emailClass);
                
                // Send system notification (database + broadcast only, no email)
                $user->notify(
                    new NewPermohonanNotification(
                        $permohonan,
                        'assignment',
                        'pegawai', // Assigned by Pegawai
                        null,
                        $actionBy,
                        null
                    )
                );
                
                Log::info('Specific user notified successfully (email + system notification)', [
                    'notification_type' => $notificationType,
                    'user_id' => $user->id_user,
                    'user_email' => $user->email,
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
                
                return true;
            }
            
            return false;
            
        } catch (\Exception $e) {
            Log::error('Failed to notify specific user', [
                'notification_type' => $notificationType,
                'user_id' => $user->id_user ?? null,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return false;
        }
    }

    /**
     * Smart notification router based on workflow stage and status
     * UPDATED: Pentadbir Sistem "Lulus" sends COMPLETION email, not status update
     */
    public static function handleWorkflowNotification(
        Permohonan $permohonan,
        User $updatedBy,
        string $currentRole,
        string $status,
        ?string $ulasan = null
    ): void
    {
        try {
            // SPECIAL CASE: Pentadbir Sistem + Lulus = Send COMPLETION email ONLY
            if ($currentRole === 'pentadbir_sistem' && $status === 'Lulus') {
                Log::info('Pentadbir Sistem approved - sending COMPLETION email to admins', [
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
                
                // Send "Permohonan Selesai" email to admins (GREEN EMAIL)
                self::notifyApplicationCompleted($permohonan);
                
                Log::info('Completion email sent, workflow complete', [
                    'permohonan_id' => $permohonan->id_permohonan
                ]);
                
                return; // EXIT - Don't send status update email
            }
            
            // FOR ALL OTHER CASES: Send status update to admins
            Log::info('Sending status update email to admins', [
                'permohonan_id' => $permohonan->id_permohonan,
                'role' => $currentRole,
                'status' => $status
            ]);
            
            self::notifyAdmins($permohonan, $updatedBy, $currentRole, $status, $ulasan);
            
            // If LULUS, notify next reviewer in workflow
            if ($status === 'Lulus') {
                $nextRole = null;
                
                if ($currentRole === 'pengarah') {
                    $nextRole = 'pegawai';
                } elseif ($currentRole === 'pegawai') {
                    $nextRole = 'pentadbir_sistem';
                }
                // Note: pentadbir_sistem case already handled above (returns early)
                
                // Notify next reviewer if exists
                if ($nextRole) {
                    Log::info('Notifying next reviewer in workflow', [
                        'next_role' => $nextRole,
                        'permohonan_id' => $permohonan->id_permohonan
                    ]);
                    
                    self::notifyNextReviewer($permohonan, $nextRole);
                }
            }
            
            // If TOLAK or KIV, workflow stops (only admin notified above)
            
            Log::info('Workflow notification completed', [
                'permohonan_id' => $permohonan->id_permohonan,
                'current_role' => $currentRole,
                'status' => $status
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in handleWorkflowNotification', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'permohonan_id' => $permohonan->id_permohonan
            ]);
        }
    }
}





