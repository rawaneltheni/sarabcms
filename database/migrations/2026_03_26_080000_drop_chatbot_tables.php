<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('chat_logs');
        Schema::dropIfExists('chat_sessions');
    }

    public function down(): void
    {
        // Legacy support tables were intentionally removed from the system.
    }
};
