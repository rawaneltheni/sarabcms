<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('chat_session_id')->constrained()->cascadeOnDelete();
            $table->text('user_message');
            $table->longText('bot_reply');
            $table->string('language', 5)->nullable();
            $table->string('matched_intent')->nullable();
            $table->string('redirect_url')->nullable();
            $table->string('page_url', 2048)->nullable();
            $table->json('meta')->nullable();
            $table->timestamps();

            $table->index(['created_at']);
            $table->index(['language']);
            $table->index(['matched_intent']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('chat_logs');
    }
};
