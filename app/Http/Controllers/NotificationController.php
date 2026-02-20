<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * NotificationController
 * 
 * Handles fetching and managing system notifications.
 * 
 * Routes:
 * - GET /notifications - Fetch all notifications for current user
 * - POST /notifications/mark-as-read - Mark all notifications as read
 * - GET /notifications/unread-count - Get unread notification count
 */
class NotificationController extends Controller
{
    /**
     * Fetch all notifications for the authenticated user.
     * 
     * Returns notifications in reverse chronological order (newest first).
     * Used to populate the notification dropdown.
     */
    public function index(Request $request)
    {
        try {
            $user = auth()->user();
            
            // Get all notifications
            $notifications = $user->notifications()->latest()->take(50)->get();
            
            // Count ONLY unread notifications
            $unreadCount = $user->unreadNotifications()->count();
            
            $formattedNotifications = $notifications->map(function ($notification) use ($user) {
                // Get the permohonan to check its current status
                $permohonanId = $notification->data['permohonan_id'] ?? null;
                $status = null;
                
                if ($permohonanId) {
                    $permohonan = \App\Models\Permohonan::find($permohonanId);
                    
                    if ($permohonan) {
                        // Check status based on user role
                        switch ($user->peranan) {
                            case 'pengarah':
                                $status = $permohonan->status_pengarah;
                                break;
                            case 'pegawai':
                                $status = $permohonan->status_pegawai;
                                break;
                            case 'pentadbir_sistem':
                                $status = $permohonan->status_pentadbir_sistem;
                                break;
                            default:
                                $status = null;
                        }
                    }
                }
                
                return [
                    'id' => $notification->id,
                    'type' => $notification->data['type'] ?? 'unknown',
                    'title' => $notification->data['title'] ?? 'Notifikasi',
                    'message' => $notification->data['message'] ?? '',
                    'permohonan_id' => $permohonanId,
                    'status' => $status, 
                    'is_read' => $notification->read_at !== null,
                    'created_at' => $notification->created_at->diffForHumans(),
                ];
            });
            
            return response()->json([
                'notifications' => $formattedNotifications,
                'unread_count' => $unreadCount
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching notifications', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'notifications' => [],
                'unread_count' => 0
            ], 500);
        }
    }

    /**
     * Mark a single notification as read
     */
    public function markAsReadSingle(Request $request, $id)
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Find the specific notification
            $notification = $user->notifications()->where('id', $id)->first();
            
            if (!$notification) {
                return response()->json(['error' => 'Notification not found'], 404);
            }

            // Mark as read
            $notification->markAsRead();

            Log::info('Notification marked as read', [
                'user_id' => $user->id_user,
                'notification_id' => $id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Notification marked as read',
                'notification_id' => $id
            ]);
        } catch (\Exception $e) {
            Log::error('Error marking notification as read', [
                'user_id' => Auth::id(),
                'notification_id' => $id,
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Failed to mark notification as read'], 500);
        }
    }

    /**
     * Mark all notifications as read (keep this for future use)
     */
    public function markAsRead()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            // Mark all unread notifications as read
            $user->unreadNotifications->markAsRead();

            Log::info('All notifications marked as read', [
                'user_id' => $user->id_user,
                'count' => $user->unreadNotifications()->count()
            ]);

            return response()->json([
                'success' => true,
                'message' => 'All notifications marked as read',
                'unread_count' => 0
            ]);
        } catch (\Exception $e) {
            Log::error('Error marking notifications as read', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json(['error' => 'Failed to mark notifications as read'], 500);
        }
    }

    /**
     * Get the unread notification count for the authenticated user.
     * 
     * Used to update the red badge count in real-time.
     */
    public function unreadCount()
    {
        try {
            $user = Auth::user();
            
            if (!$user) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }

            $count = $user->unreadNotifications()->count();

            return response()->json([
                'unread_count' => $count
            ]);
        } catch (\Exception $e) {
            Log::error('Error getting unread count', [
                'user_id' => Auth::id(),
                'error' => $e->getMessage()
            ]);

            return response()->json(['error' => 'Failed to get unread count'], 500);
        }
    }
}

