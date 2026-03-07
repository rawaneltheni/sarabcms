<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Chat Session - {{ $session->session_id }}</title>
    <style>
        body {
            margin: 0;
            font-family: Inter, Segoe UI, Arial, sans-serif;
            background: #0f1115;
            color: #e6ecff;
            padding: 28px;
        }

        .card {
            max-width: 980px;
            margin: 0 auto;
            background: #151925;
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            overflow: hidden;
        }

        .header {
            padding: 18px 22px;
            background: linear-gradient(135deg, #0f62fe, #0a4bcc);
            color: #fff;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
        }

        .header h1 {
            margin: 0;
            font-size: 18px;
            font-weight: 700;
        }

        .meta {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 10px;
            padding: 16px 22px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            background: #121621;
            font-size: 13px;
        }

        .meta span {
            color: #a9b6d9;
            display: block;
            margin-bottom: 4px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .4px;
        }

        .messages {
            padding: 18px 22px 24px;
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .time {
            font-size: 11px;
            color: #8e9ac0;
            margin-bottom: 6px;
        }

        .bubble {
            max-width: 80%;
            padding: 10px 12px;
            border-radius: 12px;
            line-height: 1.55;
            font-size: 13px;
            white-space: pre-wrap;
        }

        .user-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .bot-wrap {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
        }

        .user {
            background: #0f62fe;
            color: #fff;
        }

        .bot {
            background: #1b2130;
            border: 1px solid rgba(255,255,255,.1);
            color: #eaf0ff;
        }

        .intent {
            margin-top: 8px;
            font-size: 11px;
            color: #8ea3d8;
        }

        .redirect {
            margin-top: 8px;
            display: inline-block;
            font-size: 12px;
            color: #9fc4ff;
            text-decoration: underline;
        }

        .empty {
            padding: 24px;
            color: #b5c0de;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="header">
            <h1>SARAB.tech Chat Transcript</h1>
        </div>

        <div class="meta">
            <div><span>Session ID</span>{{ $session->session_id }}</div>
            <div><span>Language</span>{{ strtoupper($session->language ?? 'N/A') }}</div>
            <div><span>Messages</span>{{ $session->messages_count }}</div>
            <div><span>Started</span>{{ optional($session->started_at)->toDateTimeString() ?? '-' }}</div>
            <div><span>Last Activity</span>{{ optional($session->last_message_at)->toDateTimeString() ?? '-' }}</div>
            <div><span>Last Page</span>{{ $session->last_page_url ?? '-' }}</div>
        </div>

        @if($logs->isEmpty())
            <div class="empty">No messages in this session.</div>
        @else
            <div class="messages">
                @foreach($logs as $log)
                    <div class="user-wrap">
                        <div class="time">{{ optional($log->created_at)->format('Y-m-d H:i:s') }}</div>
                        <div class="bubble user">{{ $log->user_message }}</div>
                    </div>

                    <div class="bot-wrap">
                        <div class="bubble bot">{{ $log->bot_reply }}</div>
                        @if($log->matched_intent)
                            <div class="intent">Intent: {{ $log->matched_intent }}</div>
                        @endif
                        @if($log->redirect_url)
                            <a class="redirect" href="{{ $log->redirect_url }}">Redirect URL: {{ $log->redirect_url }}</a>
                        @endif
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>
