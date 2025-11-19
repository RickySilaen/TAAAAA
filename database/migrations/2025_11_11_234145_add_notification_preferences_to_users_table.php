<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('email_notifications')->default(true);
            $table->boolean('browser_notifications')->default(true);
            $table->boolean('notify_bantuan')->default(true);
            $table->boolean('notify_laporan')->default(true);
            $table->boolean('notify_announcements')->default(true);
            $table->boolean('notify_verification')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'email_notifications',
                'browser_notifications',
                'notify_bantuan',
                'notify_laporan',
                'notify_announcements',
                'notify_verification',
            ]);
        });
    }
};
