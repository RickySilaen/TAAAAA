<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     *
     * Add strategic indexes for performance optimization:
     * - Foreign keys for JOIN operations
     * - Status columns for filtering
     * - Timestamp columns for sorting
     * - Boolean flags for WHERE clauses
     * - Composite indexes for common query patterns
     */
    public function up(): void
    {
        // Users table indexes
        Schema::table('users', function (Blueprint $table) {
            // Single column indexes
            $table->index('role', 'idx_users_role');
            $table->index('is_verified', 'idx_users_is_verified');
            $table->index('created_at', 'idx_users_created_at');
            // Removed: email_verified_at index (email verification removed)

            // Composite indexes for common queries
            $table->index(['role', 'is_verified'], 'idx_users_role_verified');
            $table->index(['role', 'created_at'], 'idx_users_role_created');
            $table->index(['is_verified', 'created_at'], 'idx_users_verified_created');
        });

        // Bantuans table indexes
        Schema::table('bantuans', function (Blueprint $table) {
            // Single column indexes (user_id already has FK index)
            $table->index('status', 'idx_bantuans_status');
            $table->index('created_at', 'idx_bantuans_created_at');
            $table->index('tanggal', 'idx_bantuans_tanggal');
            $table->index('tanggal_permintaan', 'idx_bantuans_tanggal_permintaan');
            $table->index('jenis_bantuan', 'idx_bantuans_jenis_bantuan');

            // Composite indexes for common queries
            $table->index(['user_id', 'status'], 'idx_bantuans_user_status');
            $table->index(['status', 'created_at'], 'idx_bantuans_status_created');
            $table->index(['user_id', 'created_at'], 'idx_bantuans_user_created');
            $table->index(['jenis_bantuan', 'status'], 'idx_bantuans_jenis_status');
        });

        // Laporans table indexes
        Schema::table('laporans', function (Blueprint $table) {
            // Single column indexes (user_id already has FK index)
            $table->index('status', 'idx_laporans_status');
            $table->index('created_at', 'idx_laporans_created_at');
            $table->index('tanggal', 'idx_laporans_tanggal');
            $table->index('tanggal_panen', 'idx_laporans_tanggal_panen');
            $table->index('jenis_tanaman', 'idx_laporans_jenis_tanaman');

            // Composite indexes for common queries
            $table->index(['user_id', 'status'], 'idx_laporans_user_status');
            $table->index(['status', 'created_at'], 'idx_laporans_status_created');
            $table->index(['user_id', 'created_at'], 'idx_laporans_user_created');
            $table->index(['jenis_tanaman', 'status'], 'idx_laporans_jenis_status');
            $table->index(['tanggal_panen', 'status'], 'idx_laporans_tanggal_status');
        });

        // Beritas table indexes
        Schema::table('beritas', function (Blueprint $table) {
            // Single column indexes (slug already unique)
            $table->index('status', 'idx_beritas_status');
            $table->index('kategori', 'idx_beritas_kategori');
            $table->index('created_at', 'idx_beritas_created_at');
            $table->index('tanggal_publikasi', 'idx_beritas_tanggal_publikasi');
            $table->index('penulis', 'idx_beritas_penulis');

            // Composite indexes for common queries
            $table->index(['status', 'tanggal_publikasi'], 'idx_beritas_status_publikasi');
            $table->index(['kategori', 'status'], 'idx_beritas_kategori_status');
            $table->index(['status', 'created_at'], 'idx_beritas_status_created');
        });

        // Feedbacks table indexes
        Schema::table('feedbacks', function (Blueprint $table) {
            // Single column indexes
            $table->index('status', 'idx_feedbacks_status');
            $table->index('kategori', 'idx_feedbacks_kategori');
            $table->index('created_at', 'idx_feedbacks_created_at');
            $table->index('email', 'idx_feedbacks_email');

            // Composite indexes for common queries
            $table->index(['status', 'created_at'], 'idx_feedbacks_status_created');
            $table->index(['kategori', 'status'], 'idx_feedbacks_kategori_status');
        });

        // Galeris table indexes
        if (Schema::hasTable('galeris')) {
            Schema::table('galeris', function (Blueprint $table) {
                $table->index('created_at', 'idx_galeris_created_at');
                if (Schema::hasColumn('galeris', 'kategori')) {
                    $table->index('kategori', 'idx_galeris_kategori');
                }
            });
        }

        // Newsletters table indexes
        if (Schema::hasTable('newsletters')) {
            Schema::table('newsletters', function (Blueprint $table) {
                $table->index('email', 'idx_newsletters_email');
                $table->index('created_at', 'idx_newsletters_created_at');
                if (Schema::hasColumn('newsletters', 'status')) {
                    $table->index('status', 'idx_newsletters_status');
                }
            });
        }

        // Notifications table indexes
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->index('notifiable_type', 'idx_notifications_notifiable_type');
                $table->index('notifiable_id', 'idx_notifications_notifiable_id');
                $table->index('read_at', 'idx_notifications_read_at');
                $table->index('created_at', 'idx_notifications_created_at');

                // Composite index for polymorphic queries
                $table->index(['notifiable_type', 'notifiable_id'], 'idx_notifications_notifiable');
                $table->index(['notifiable_type', 'notifiable_id', 'read_at'], 'idx_notifications_unread');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex('idx_users_role');
            $table->dropIndex('idx_users_is_verified');
            $table->dropIndex('idx_users_created_at');
            // Removed: email_verified_at index drop (email verification removed)
            $table->dropIndex('idx_users_role_verified');
            $table->dropIndex('idx_users_role_created');
            $table->dropIndex('idx_users_verified_created');
        });

        // Bantuans table
        Schema::table('bantuans', function (Blueprint $table) {
            $table->dropIndex('idx_bantuans_status');
            $table->dropIndex('idx_bantuans_created_at');
            $table->dropIndex('idx_bantuans_tanggal');
            $table->dropIndex('idx_bantuans_tanggal_permintaan');
            $table->dropIndex('idx_bantuans_jenis_bantuan');
            $table->dropIndex('idx_bantuans_user_status');
            $table->dropIndex('idx_bantuans_status_created');
            $table->dropIndex('idx_bantuans_user_created');
            $table->dropIndex('idx_bantuans_jenis_status');
        });

        // Laporans table
        Schema::table('laporans', function (Blueprint $table) {
            $table->dropIndex('idx_laporans_status');
            $table->dropIndex('idx_laporans_created_at');
            $table->dropIndex('idx_laporans_tanggal');
            $table->dropIndex('idx_laporans_tanggal_panen');
            $table->dropIndex('idx_laporans_jenis_tanaman');
            $table->dropIndex('idx_laporans_user_status');
            $table->dropIndex('idx_laporans_status_created');
            $table->dropIndex('idx_laporans_user_created');
            $table->dropIndex('idx_laporans_jenis_status');
            $table->dropIndex('idx_laporans_tanggal_status');
        });

        // Beritas table
        Schema::table('beritas', function (Blueprint $table) {
            $table->dropIndex('idx_beritas_status');
            $table->dropIndex('idx_beritas_kategori');
            $table->dropIndex('idx_beritas_created_at');
            $table->dropIndex('idx_beritas_tanggal_publikasi');
            $table->dropIndex('idx_beritas_penulis');
            $table->dropIndex('idx_beritas_status_publikasi');
            $table->dropIndex('idx_beritas_kategori_status');
            $table->dropIndex('idx_beritas_status_created');
        });

        // Feedbacks table
        Schema::table('feedbacks', function (Blueprint $table) {
            $table->dropIndex('idx_feedbacks_status');
            $table->dropIndex('idx_feedbacks_kategori');
            $table->dropIndex('idx_feedbacks_created_at');
            $table->dropIndex('idx_feedbacks_email');
            $table->dropIndex('idx_feedbacks_status_created');
            $table->dropIndex('idx_feedbacks_kategori_status');
        });

        // Galeris table
        if (Schema::hasTable('galeris')) {
            Schema::table('galeris', function (Blueprint $table) {
                $table->dropIndex('idx_galeris_created_at');
                if (Schema::hasColumn('galeris', 'kategori')) {
                    $table->dropIndex('idx_galeris_kategori');
                }
            });
        }

        // Newsletters table
        if (Schema::hasTable('newsletters')) {
            Schema::table('newsletters', function (Blueprint $table) {
                $table->dropIndex('idx_newsletters_email');
                $table->dropIndex('idx_newsletters_created_at');
                if (Schema::hasColumn('newsletters', 'status')) {
                    $table->dropIndex('idx_newsletters_status');
                }
            });
        }

        // Notifications table
        if (Schema::hasTable('notifications')) {
            Schema::table('notifications', function (Blueprint $table) {
                $table->dropIndex('idx_notifications_notifiable_type');
                $table->dropIndex('idx_notifications_notifiable_id');
                $table->dropIndex('idx_notifications_read_at');
                $table->dropIndex('idx_notifications_created_at');
                $table->dropIndex('idx_notifications_notifiable');
                $table->dropIndex('idx_notifications_unread');
            });
        }
    }
};
