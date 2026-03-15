<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    public const END_AFTER_INACTIVE_MINUTES = 45;

    protected $fillable = [
        'session_id',
        'language',
        'messages_count',
        'started_at',
        'last_message_at',
        'ended_at',
        'human_takeover_active',
        'human_takeover_started_at',
        'human_takeover_by_user_id',
        'first_page_url',
        'last_page_url',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'last_message_at' => 'datetime',
        'ended_at' => 'datetime',
        'human_takeover_active' => 'boolean',
        'human_takeover_started_at' => 'datetime',
    ];

    public function humanTakeoverBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'human_takeover_by_user_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(ChatLog::class)->orderBy('created_at');
    }

    public function hasEnded(): bool
    {
        if ($this->ended_at !== null) {
            return true;
        }

        $lastActivityAt = $this->last_message_at ?? $this->created_at;

        if (! $lastActivityAt) {
            return false;
        }

        return $lastActivityAt->lt(now()->subMinutes(self::END_AFTER_INACTIVE_MINUTES));
    }

    public function canBeJoined(): bool
    {
        return ! $this->hasEnded() && ! $this->human_takeover_active;
    }

    public function endedStatusLabel(): string
    {
        return $this->hasEnded() ? 'Ended' : 'Open';
    }

    public function appendLog(
        string $userMessage = '',
        string $botReply = '',
        ?string $language = null,
        ?string $matchedIntent = null,
        ?string $redirectUrl = null,
        ?string $pageUrl = null,
        ?array $meta = null,
    ): ChatLog {
        $this->forceFill([
            'language' => $language ?? $this->language,
            'last_message_at' => now(),
            'ended_at' => null,
            'last_page_url' => $pageUrl ?? $this->last_page_url,
            'messages_count' => ((int) $this->messages_count) + 1,
        ])->save();

        return $this->logs()->create([
            'user_message' => $userMessage,
            'bot_reply' => $botReply,
            'language' => $language ?? $this->language,
            'matched_intent' => $matchedIntent,
            'redirect_url' => $redirectUrl,
            'page_url' => $pageUrl,
            'meta' => $meta,
        ]);
    }

    public function joinHumanTakeover(?User $user = null): ChatLog
    {
        $this->forceFill([
            'human_takeover_active' => true,
            'human_takeover_started_at' => now(),
            'human_takeover_by_user_id' => $user?->id,
        ])->save();

        $agentName = $user?->name;

        return $this->appendLog(
            botReply: 'Sarab assistant is here to help.',
            language: $this->language,
            matchedIntent: 'human_takeover_started',
            pageUrl: $this->last_page_url,
            meta: [
                'source' => 'system',
                'event' => 'human_takeover_started',
                'agent_name' => $agentName,
                'agent_user_id' => $user?->id,
            ],
        );
    }

    public function releaseHumanTakeover(): ChatLog
    {
        $agentName = $this->humanTakeoverBy?->name;

        $this->forceFill([
            'human_takeover_active' => false,
        ])->save();

        return $this->appendLog(
            botReply: 'Sarab assistant is back to help.',
            language: $this->language,
            matchedIntent: 'human_takeover_ended',
            pageUrl: $this->last_page_url,
            meta: [
                'source' => 'system',
                'event' => 'human_takeover_ended',
                'agent_name' => $agentName,
                'agent_user_id' => $this->human_takeover_by_user_id,
            ],
        );
    }

    public function sendHumanReply(string $message, ?User $user = null): ChatLog
    {
        if (! $this->human_takeover_active) {
            $this->joinHumanTakeover($user);
            $this->refresh();
        }

        return $this->appendLog(
            botReply: trim($message),
            language: $this->language,
            matchedIntent: 'human_agent_reply',
            pageUrl: $this->last_page_url,
            meta: [
                'source' => 'human-agent',
                'agent_name' => $user?->name,
                'agent_user_id' => $user?->id,
            ],
        );
    }
}
