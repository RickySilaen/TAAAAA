<?php

namespace App\Services;

use App\Models\Bantuan;
use App\Models\Laporan;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Notification;

/**
 * NotificationService.
 *
 * Comprehensive notification management system supporting:
 * - Email notifications with beautiful templates
 * - Browser push notifications
 * - In-app notification center
 * - Notification preferences management
 * - Batch notifications
 * - Scheduled notifications
 *
 * @version 1.0.0
 */
class NotificationService
{
    /**
     * Notification types.
     */
    const TYPE_INFO = 'info';
    const TYPE_SUCCESS = 'success';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';
    const TYPE_ALERT = 'alert';

    /**
     * Notification channels.
     */
    const CHANNEL_DATABASE = 'database';
    const CHANNEL_MAIL = 'mail';
    const CHANNEL_BROADCAST = 'broadcast';

    /**
     * Create notification.
     *
     * @param  mixed  $notifiable  User or collection of users
     * @param  string  $title  Notification title
     * @param  string  $message  Notification message
     * @param  array  $options  Additional options
     */
    public function create($notifiable, string $title, string $message, array $options = []): void
    {
        $data = [
            'title' => $title,
            'message' => $message,
            'type' => $options['type'] ?? self::TYPE_INFO,
            'icon' => $options['icon'] ?? $this->getIconForType($options['type'] ?? self::TYPE_INFO),
            'action_url' => $options['action_url'] ?? null,
            'action_text' => $options['action_text'] ?? 'Lihat Detail',
            'data' => $options['data'] ?? [],
            'channels' => $options['channels'] ?? [self::CHANNEL_DATABASE],
            'send_at' => $options['send_at'] ?? null,
        ];

        // Check user preferences
        if (! $this->shouldSendNotification($notifiable, $data['type'])) {
            return;
        }

        // Schedule notification if send_at is set
        if ($data['send_at']) {
            $this->scheduleNotification($notifiable, $data);

            return;
        }

        // Send immediately
        $this->sendNotification($notifiable, $data);

        // Log notification
        activity()
            ->causedBy(auth()->user())
            ->performedOn($notifiable instanceof User ? $notifiable : null)
            ->withProperties(['notification' => $data])
            ->log('notification_sent');
    }

    /**
     * Send notification through specified channels.
     *
     * @param  mixed  $notifiable
     */
    protected function sendNotification($notifiable, array $data): void
    {
        foreach ($data['channels'] as $channel) {
            switch ($channel) {
                case self::CHANNEL_DATABASE:
                    $this->sendDatabaseNotification($notifiable, $data);
                    break;
                case self::CHANNEL_MAIL:
                    $this->sendEmailNotification($notifiable, $data);
                    break;
                case self::CHANNEL_BROADCAST:
                    $this->sendBroadcastNotification($notifiable, $data);
                    break;
            }
        }
    }

    /**
     * Send database notification.
     *
     * @param  mixed  $notifiable
     */
    protected function sendDatabaseNotification($notifiable, array $data): void
    {
        if ($notifiable instanceof \Illuminate\Support\Collection) {
            foreach ($notifiable as $user) {
                $user->notifications()->create([
                    'type' => 'App\\Notifications\\SystemNotification',
                    'data' => $data,
                    'read_at' => null,
                ]);
            }
        } else {
            $notifiable->notifications()->create([
                'type' => 'App\\Notifications\\SystemNotification',
                'data' => $data,
                'read_at' => null,
            ]);
        }
    }

    /**
     * Send email notification.
     *
     * @param  mixed  $notifiable
     */
    protected function sendEmailNotification($notifiable, array $data): void
    {
        $notification = new \App\Notifications\EmailNotification($data);

        if ($notifiable instanceof \Illuminate\Support\Collection) {
            Notification::send($notifiable, $notification);
        } else {
            $notifiable->notify($notification);
        }
    }

    /**
     * Send broadcast notification (real-time).
     *
     * @param  mixed  $notifiable
     */
    protected function sendBroadcastNotification($notifiable, array $data): void
    {
        $notification = new \App\Notifications\BroadcastNotification($data);

        if ($notifiable instanceof \Illuminate\Support\Collection) {
            Notification::send($notifiable, $notification);
        } else {
            $notifiable->notify($notification);
        }
    }

    /**
     * Notify about bantuan status change.
     */
    public function bantuanStatusChanged(Bantuan $bantuan, string $oldStatus, string $newStatus): void
    {
        $statusMessages = [
            'pending' => 'sedang diproses',
            'approved' => 'telah disetujui',
            'rejected' => 'ditolak',
            'delivered' => 'telah dikirim',
        ];

        $type = $newStatus === 'approved' ? self::TYPE_SUCCESS :
                ($newStatus === 'rejected' ? self::TYPE_ERROR : self::TYPE_INFO);

        $this->create(
            $bantuan->user,
            'Status Bantuan Diperbarui',
            "Permohonan bantuan Anda ({$bantuan->jenis_bantuan}) {$statusMessages[$newStatus]}.",
            [
                'type' => $type,
                'action_url' => route('bantuan.show', $bantuan->id),
                'channels' => [self::CHANNEL_DATABASE, self::CHANNEL_MAIL],
                'data' => [
                    'bantuan_id' => $bantuan->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ],
            ]
        );
    }

    /**
     * Notify about laporan status change.
     */
    public function laporanStatusChanged(Laporan $laporan, string $oldStatus, string $newStatus): void
    {
        $statusMessages = [
            'pending' => 'sedang diproses',
            'reviewed' => 'telah ditinjau',
            'verified' => 'telah diverifikasi',
            'rejected' => 'ditolak',
        ];

        $type = $newStatus === 'verified' ? self::TYPE_SUCCESS :
                ($newStatus === 'rejected' ? self::TYPE_ERROR : self::TYPE_INFO);

        $this->create(
            $laporan->user,
            'Status Laporan Diperbarui',
            "Laporan panen Anda {$statusMessages[$newStatus]}.",
            [
                'type' => $type,
                'action_url' => route('laporan.show', $laporan->id),
                'channels' => [self::CHANNEL_DATABASE, self::CHANNEL_MAIL],
                'data' => [
                    'laporan_id' => $laporan->id,
                    'old_status' => $oldStatus,
                    'new_status' => $newStatus,
                ],
            ]
        );
    }

    /**
     * Notify petani verification status.
     */
    public function petaniVerified(User $user, bool $approved, ?string $reason = null): void
    {
        $title = $approved ? 'Akun Terverifikasi' : 'Verifikasi Ditolak';
        $message = $approved
            ? 'Selamat! Akun petani Anda telah diverifikasi. Anda sekarang dapat mengajukan bantuan dan melaporkan hasil panen.'
            : "Verifikasi akun Anda ditolak. Alasan: {$reason}";

        $this->create(
            $user,
            $title,
            $message,
            [
                'type' => $approved ? self::TYPE_SUCCESS : self::TYPE_ERROR,
                'action_url' => route('profile.edit'),
                'action_text' => $approved ? 'Lihat Profil' : 'Update Profil',
                'channels' => [self::CHANNEL_DATABASE, self::CHANNEL_MAIL],
                'data' => [
                    'verified' => $approved,
                    'reason' => $reason,
                ],
            ]
        );
    }

    /**
     * Send announcement to multiple users.
     *
     * @param  array|string  $roles  Roles to send to (petani, petugas, admin)
     */
    public function sendAnnouncement($roles, string $title, string $message, array $options = []): void
    {
        $roles = is_array($roles) ? $roles : [$roles];

        $users = User::whereIn('role', $roles)
            ->where('status', 'active')
            ->get();

        $this->create(
            $users,
            $title,
            $message,
            array_merge($options, [
                'type' => self::TYPE_ALERT,
                'channels' => [self::CHANNEL_DATABASE, self::CHANNEL_MAIL, self::CHANNEL_BROADCAST],
            ])
        );
    }

    /**
     * Get unread notifications count.
     */
    public function getUnreadCount(User $user): int
    {
        return Cache::remember(
            "user.{$user->id}.unread_notifications",
            now()->addMinutes(5),
            fn () => $user->unreadNotifications()->count()
        );
    }

    /**
     * Mark notification as read.
     */
    public function markAsRead(User $user, string $notificationId): bool
    {
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->markAsRead();
            Cache::forget("user.{$user->id}.unread_notifications");

            return true;
        }

        return false;
    }

    /**
     * Mark all notifications as read.
     */
    public function markAllAsRead(User $user): void
    {
        $user->unreadNotifications->markAsRead();
        Cache::forget("user.{$user->id}.unread_notifications");
    }

    /**
     * Delete notification.
     */
    public function delete(User $user, string $notificationId): bool
    {
        $notification = $user->notifications()->find($notificationId);

        if ($notification) {
            $notification->delete();
            Cache::forget("user.{$user->id}.unread_notifications");

            return true;
        }

        return false;
    }

    /**
     * Get user's notification preferences.
     */
    public function getPreferences(User $user): array
    {
        return [
            'email_notifications' => $user->email_notifications ?? true,
            'browser_notifications' => $user->browser_notifications ?? true,
            'notification_types' => [
                'bantuan_updates' => $user->notify_bantuan ?? true,
                'laporan_updates' => $user->notify_laporan ?? true,
                'system_announcements' => $user->notify_announcements ?? true,
                'verification_updates' => $user->notify_verification ?? true,
            ],
        ];
    }

    /**
     * Update user's notification preferences.
     */
    public function updatePreferences(User $user, array $preferences): void
    {
        $user->update([
            'email_notifications' => $preferences['email_notifications'] ?? true,
            'browser_notifications' => $preferences['browser_notifications'] ?? true,
            'notify_bantuan' => $preferences['notification_types']['bantuan_updates'] ?? true,
            'notify_laporan' => $preferences['notification_types']['laporan_updates'] ?? true,
            'notify_announcements' => $preferences['notification_types']['system_announcements'] ?? true,
            'notify_verification' => $preferences['notification_types']['verification_updates'] ?? true,
        ]);
    }

    /**
     * Check if notification should be sent based on user preferences.
     *
     * @param  mixed  $notifiable
     */
    protected function shouldSendNotification($notifiable, string $type): bool
    {
        if (! $notifiable instanceof User) {
            return true;
        }

        // Check global preference
        if (! ($notifiable->email_notifications ?? true)) {
            return false;
        }

        // Check specific type preferences
        $typePreferences = [
            'bantuan' => $notifiable->notify_bantuan ?? true,
            'laporan' => $notifiable->notify_laporan ?? true,
            'announcement' => $notifiable->notify_announcements ?? true,
            'verification' => $notifiable->notify_verification ?? true,
        ];

        return $typePreferences[$type] ?? true;
    }

    /**
     * Schedule notification for later delivery.
     *
     * @param  mixed  $notifiable
     */
    protected function scheduleNotification($notifiable, array $data): void
    {
        // Store in scheduled_notifications table or use Laravel's queue delay
        DB::table('scheduled_notifications')->insert([
            'notifiable_type' => get_class($notifiable),
            'notifiable_id' => $notifiable->id ?? null,
            'data' => json_encode($data),
            'send_at' => $data['send_at'],
            'created_at' => now(),
        ]);
    }

    /**
     * Get icon for notification type.
     */
    protected function getIconForType(string $type): string
    {
        return match ($type) {
            self::TYPE_SUCCESS => '✅',
            self::TYPE_ERROR => '❌',
            self::TYPE_WARNING => '⚠️',
            self::TYPE_ALERT => '📢',
            default => 'ℹ️',
        };
    }

    /**
     * Get notification statistics.
     */
    public function getStats(User $user): array
    {
        return Cache::remember(
            "user.{$user->id}.notification_stats",
            now()->addHour(),
            function () use ($user) {
                return [
                    'total' => $user->notifications()->count(),
                    'unread' => $user->unreadNotifications()->count(),
                    'read' => $user->readNotifications()->count(),
                    'today' => $user->notifications()
                        ->whereDate('created_at', today())
                        ->count(),
                    'this_week' => $user->notifications()
                        ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                        ->count(),
                ];
            }
        );
    }
}
