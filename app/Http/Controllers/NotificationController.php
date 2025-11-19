<?php

namespace App\Http\Controllers;

use App\Services\NotificationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
        $this->middleware('auth');
    }

    /**
     * Get all notifications for authenticated user.
     */
    public function index(Request $request): JsonResponse
    {
        $user = $request->user();
        $perPage = $request->input('per_page', 15);

        $notifications = $user->notifications()
            ->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'unread_count' => $this->notificationService->getUnreadCount($user),
            'stats' => $this->notificationService->getStats($user),
        ]);
    }

    /**
     * Get unread notifications.
     */
    public function unread(Request $request): JsonResponse
    {
        $user = $request->user();

        $notifications = $user->unreadNotifications()
            ->limit(20)
            ->get();

        return response()->json([
            'success' => true,
            'data' => $notifications,
            'count' => $notifications->count(),
        ]);
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(Request $request, string $id): JsonResponse
    {
        $user = $request->user();
        $success = $this->notificationService->markAsRead($user, $id);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notifikasi ditandai sebagai dibaca' : 'Notifikasi tidak ditemukan',
            'unread_count' => $this->notificationService->getUnreadCount($user),
        ]);
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->notificationService->markAllAsRead($user);

        return response()->json([
            'success' => true,
            'message' => 'Semua notifikasi telah ditandai sebagai dibaca',
        ]);
    }

    /**
     * Delete notification.
     */
    public function destroy(Request $request, string $id): JsonResponse
    {
        $user = $request->user();
        $success = $this->notificationService->delete($user, $id);

        return response()->json([
            'success' => $success,
            'message' => $success ? 'Notifikasi dihapus' : 'Notifikasi tidak ditemukan',
        ]);
    }

    /**
     * Get notification preferences.
     */
    public function getPreferences(Request $request): JsonResponse
    {
        $user = $request->user();
        $preferences = $this->notificationService->getPreferences($user);

        return response()->json([
            'success' => true,
            'data' => $preferences,
        ]);
    }

    /**
     * Update notification preferences.
     */
    public function updatePreferences(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email_notifications' => 'boolean',
            'browser_notifications' => 'boolean',
            'notification_types' => 'array',
            'notification_types.bantuan_updates' => 'boolean',
            'notification_types.laporan_updates' => 'boolean',
            'notification_types.system_announcements' => 'boolean',
            'notification_types.verification_updates' => 'boolean',
        ]);

        $user = $request->user();
        $this->notificationService->updatePreferences($user, $validated);

        return response()->json([
            'success' => true,
            'message' => 'Preferensi notifikasi berhasil diperbarui',
            'data' => $this->notificationService->getPreferences($user),
        ]);
    }

    /**
     * Get notification statistics.
     */
    public function stats(Request $request): JsonResponse
    {
        $user = $request->user();
        $stats = $this->notificationService->getStats($user);

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
