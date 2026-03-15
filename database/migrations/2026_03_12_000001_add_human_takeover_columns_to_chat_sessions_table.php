<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table): void {
            if (! Schema::hasColumn('chat_sessions', 'human_takeover_active')) {
                $table->boolean('human_takeover_active')->default(false)->after('ended_at');
                $table->index('human_takeover_active');
            }

            if (! Schema::hasColumn('chat_sessions', 'human_takeover_started_at')) {
                $table->timestamp('human_takeover_started_at')->nullable()->after('human_takeover_active');
            }

            if (! Schema::hasColumn('chat_sessions', 'human_takeover_by_user_id')) {
                $table->foreignId('human_takeover_by_user_id')
                    ->nullable()
                    ->after('human_takeover_started_at')
                    ->constrained('users')
                    ->nullOnDelete();
            }
        });
    }

    public function down(): void
    {
        Schema::table('chat_sessions', function (Blueprint $table): void {
            if (Schema::hasColumn('chat_sessions', 'human_takeover_by_user_id')) {
                $table->dropConstrainedForeignId('human_takeover_by_user_id');
            }

            if (Schema::hasColumn('chat_sessions', 'human_takeover_started_at')) {
                $table->dropColumn('human_takeover_started_at');
            }

            if (Schema::hasColumn('chat_sessions', 'human_takeover_active')) {
                $table->dropIndex(['human_takeover_active']);
                $table->dropColumn('human_takeover_active');
            }
        });
    }
};
