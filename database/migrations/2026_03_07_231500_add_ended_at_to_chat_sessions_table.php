<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasColumn('chat_sessions', 'ended_at')) {
            Schema::table('chat_sessions', function (Blueprint $table): void {
                $table->timestamp('ended_at')->nullable()->after('last_message_at');
                $table->index('ended_at');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('chat_sessions', 'ended_at')) {
            Schema::table('chat_sessions', function (Blueprint $table): void {
                $table->dropIndex(['ended_at']);
                $table->dropColumn('ended_at');
            });
        }
    }
};
