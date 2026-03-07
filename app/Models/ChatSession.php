<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ChatSession extends Model
{
    protected $fillable = [
        'session_id',
        'language',
        'messages_count',
        'started_at',
        'last_message_at',
        'ended_at',
        'first_page_url',
        'last_page_url',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'started_at' => 'datetime',
        'last_message_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function logs(): HasMany
    {
        return $this->hasMany(ChatLog::class)->orderBy('created_at');
    }
}
