<?php

use Illuminate\Database\Migrations\Migration;

return new class() extends Migration
{
    /**
     * Run the migrations.
     * This migration is a no-op because is_verified, verified_at, and verified_by
     * were already added in migration 2025_11_10_093104_add_verification_columns_to_users_table.
     */
    public function up(): void
    {
        // Columns already exist from earlier migration
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Nothing to reverse
    }
};
