<?php

use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    public function up(): void
    {
        // The bookings table is already created by 2026_01_01_000004_create_bookings_table.
        // Keep this migration as a no-op so existing databases can continue migrating cleanly.
    }

    public function down(): void
    {
        // No-op because this migration does not own the bookings table.
    }
};
