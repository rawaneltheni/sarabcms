<x-filament-panels::page>
    @php($session = $this->getSession())
    @php($logs = $session->logs)
    @php($isEnded = $session->hasEnded())

    <div
        x-data="{}"
        x-on:chat-updated.window="$nextTick(() => { if ($refs.messages) { $refs.messages.scrollTop = $refs.messages.scrollHeight } })"
        x-init="$nextTick(() => { if ($refs.messages) { $refs.messages.scrollTop = $refs.messages.scrollHeight } })"
        wire:poll.4s="refreshChat"
        class="fi-chat-layout"
    >
        <style>
            .fi-chat-layout {
                display: grid;
                grid-template-columns: minmax(0, 1fr) 320px;
                gap: 1rem;
                min-height: calc(100vh - 12rem);
            }
            .fi-chat-window,
            .fi-chat-sidebar {
                border-radius: 1.25rem;
                border: 1px solid rgba(255,255,255,.08);
                background: rgba(10, 10, 14, .94);
                box-shadow: 0 20px 50px rgba(0,0,0,.22);
                overflow: hidden;
            }
            .fi-chat-window {
                display: flex;
                flex-direction: column;
                min-height: 70vh;
            }
            .fi-chat-topbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 1rem 1.25rem;
                border-bottom: 1px solid rgba(255,255,255,.08);
                background: linear-gradient(180deg, rgba(20,20,27,.98), rgba(14,14,19,.98));
            }
            .fi-chat-title {
                font-size: 1rem;
                font-weight: 700;
                color: #fff;
            }
            .fi-chat-subtitle {
                font-size: .84rem;
                color: rgba(255,255,255,.65);
                margin-top: .2rem;
            }
            .fi-chat-status {
                display: inline-flex;
                align-items: center;
                gap: .5rem;
                padding: .5rem .75rem;
                border-radius: 999px;
                font-size: .78rem;
                font-weight: 700;
            }
            .fi-chat-status.open { background: rgba(34,197,94,.12); color: #86efac; }
            .fi-chat-status.ended { background: rgba(248,113,113,.12); color: #fca5a5; }
            .fi-chat-messages {
                flex: 1;
                overflow-y: auto;
                padding: 1.25rem;
                display: flex;
                flex-direction: column;
                gap: 1rem;
                background: linear-gradient(180deg, rgba(14,14,20,.94), rgba(8,8,12,.98));
            }
            .fi-chat-row {
                display: flex;
                flex-direction: column;
                gap: .35rem;
                max-width: 78%;
            }
            .fi-chat-row.user { align-self: flex-end; align-items: flex-end; }
            .fi-chat-row.assistant,
            .fi-chat-row.human { align-self: flex-start; }
            .fi-chat-row.system {
                align-self: center;
                max-width: 92%;
                align-items: center;
            }
            .fi-chat-meta {
                font-size: .72rem;
                color: rgba(255,255,255,.48);
            }
            .fi-chat-bubble {
                padding: .9rem 1rem;
                border-radius: 1rem;
                line-height: 1.55;
                font-size: .92rem;
                white-space: pre-wrap;
                word-break: break-word;
            }
            .fi-chat-bubble.user { background: #2563eb; color: #fff; border-bottom-right-radius: .4rem; }
            .fi-chat-bubble.assistant { background: rgba(255,255,255,.06); color: #edf2ff; border-bottom-left-radius: .4rem; }
            .fi-chat-bubble.human { background: rgba(34,197,94,.14); color: #ecfdf5; border: 1px solid rgba(34,197,94,.18); border-bottom-left-radius: .4rem; }
            .fi-chat-bubble.system { background: rgba(255,255,255,.06); color: rgba(255,255,255,.78); text-align: center; }
            .fi-chat-composer {
                padding: 1rem 1.25rem 1.25rem;
                border-top: 1px solid rgba(255,255,255,.08);
                background: rgba(12,12,16,.98);
            }
            .fi-chat-compose-box {
                display: flex;
                gap: .75rem;
                align-items: flex-end;
            }
            .fi-chat-textarea {
                width: 100%;
                min-height: 64px;
                max-height: 180px;
                resize: vertical;
                border-radius: 1rem;
                border: 1px solid rgba(255,255,255,.12);
                background: rgba(255,255,255,.04);
                color: #fff;
                padding: .9rem 1rem;
                outline: none;
            }
            .fi-chat-send {
                border: 0;
                border-radius: 1rem;
                background: #22c55e;
                color: #04130a;
                font-weight: 800;
                padding: .9rem 1.1rem;
                min-width: 120px;
                cursor: pointer;
            }
            .fi-chat-send:disabled { opacity: .5; cursor: not-allowed; }
            .fi-chat-note {
                margin-top: .6rem;
                font-size: .78rem;
                color: rgba(255,255,255,.5);
            }
            .fi-chat-sidebar {
                padding: 1.25rem;
                display: flex;
                flex-direction: column;
                gap: 1rem;
            }
            .fi-chat-card {
                border-radius: 1rem;
                border: 1px solid rgba(255,255,255,.08);
                background: rgba(255,255,255,.03);
                padding: 1rem;
            }
            .fi-chat-card h3 {
                margin: 0 0 .8rem;
                color: #fff;
                font-size: .92rem;
                font-weight: 700;
            }
            .fi-chat-list {
                display: grid;
                gap: .75rem;
            }
            .fi-chat-list-item small {
                display: block;
                color: rgba(255,255,255,.5);
                margin-bottom: .15rem;
            }
            .fi-chat-list-item div {
                color: rgba(255,255,255,.86);
                word-break: break-word;
            }
            @media (max-width: 1024px) {
                .fi-chat-layout { grid-template-columns: 1fr; }
                .fi-chat-sidebar { order: -1; }
            }
        </style>

        <section class="fi-chat-window">
            <div class="fi-chat-topbar">
                <div>
                    <div class="fi-chat-title">Live Chat</div>
                    <div class="fi-chat-subtitle">
                        Session {{ $session->session_id }}
                        @if($session->humanTakeoverBy?->name)
                            · {{ $session->humanTakeoverBy->name }} handling this chat
                        @endif
                    </div>
                </div>

                <div class="fi-chat-status {{ $isEnded ? 'ended' : 'open' }}">
                    {{ $isEnded ? 'Ended' : 'Open' }}
                </div>
            </div>

            <div x-ref="messages" class="fi-chat-messages">
                @foreach($logs as $log)
                    @php($source = data_get($log->meta, 'source'))

                    @if(filled($log->user_message))
                        <div class="fi-chat-row user">
                            <div class="fi-chat-meta">Visitor · {{ optional($log->created_at)->format('M d, Y H:i') }}</div>
                            <div class="fi-chat-bubble user">{{ $log->user_message }}</div>
                        </div>
                    @endif

                    @if(filled($log->bot_reply))
                        <div class="fi-chat-row {{ $source === 'human-agent' ? 'human' : ($source === 'system' ? 'system' : 'assistant') }}">
                            <div class="fi-chat-meta">
                                @if($source === 'human-agent')
                                    {{ data_get($log->meta, 'agent_name') ?: 'Team member' }}
                                @elseif($source === 'system')
                                    System
                                @else
                                    AI assistant
                                @endif
                                · {{ optional($log->created_at)->format('M d, Y H:i') }}
                            </div>
                            <div class="fi-chat-bubble {{ $source === 'human-agent' ? 'human' : ($source === 'system' ? 'system' : 'assistant') }}">{{ $log->bot_reply }}</div>
                        </div>
                    @endif
                @endforeach
            </div>

            <form wire:submit="sendReply" class="fi-chat-composer">
                <div class="fi-chat-compose-box">
                    <textarea
                        wire:model="message"
                        class="fi-chat-textarea"
                        placeholder="Type your reply..."
                        @disabled($isEnded)
                    ></textarea>

                    <button type="submit" class="fi-chat-send" @disabled($isEnded)>
                        Send Reply
                    </button>
                </div>

                <div class="fi-chat-note">
                    @if($isEnded)
                        This chat has ended, so replies are disabled.
                    @else
                        Replies are sent directly into the live chat thread.
                    @endif
                </div>
            </form>
        </section>

        <aside class="fi-chat-sidebar">
            <div class="fi-chat-card">
                <h3>Chat Details</h3>
                <div class="fi-chat-list">
                    <div class="fi-chat-list-item">
                        <small>Status</small>
                        <div>{{ $session->endedStatusLabel() }}</div>
                    </div>
                    <div class="fi-chat-list-item">
                        <small>Language</small>
                        <div>{{ strtoupper($session->language ?? 'N/A') }}</div>
                    </div>
                    <div class="fi-chat-list-item">
                        <small>Messages</small>
                        <div>{{ $session->messages_count }}</div>
                    </div>
                    <div class="fi-chat-list-item">
                        <small>Started</small>
                        <div>{{ optional($session->started_at)->format('M d, Y H:i') ?? '—' }}</div>
                    </div>
                    <div class="fi-chat-list-item">
                        <small>Last Activity</small>
                        <div>{{ optional($session->last_message_at)->format('M d, Y H:i') ?? '—' }}</div>
                    </div>
                </div>
            </div>

        </aside>
    </div>
</x-filament-panels::page>
