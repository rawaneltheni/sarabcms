<!doctype html>
<html lang="en">
<head>
    <title>@yield('title') | Sarab Tech</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="https://sarab.tech/public/images/media/1689461139icon light.png">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="{{ asset('css/front/venor.css') }}" rel="stylesheet">

    <style>
        :root { --sarab-blue: #007bff; }

        * { margin:0; padding:0; box-sizing:border-box; }
        body { font-family:'Poppins',sans-serif; background:#000; color:#fff; }

        .header {
            background: rgba(0,0,0,0.85);
            backdrop-filter: blur(15px);
            padding:15px 0;
            position:sticky;
            top:0;
            z-index:1000;
            border-bottom:1px solid rgba(255,255,255,0.1);
        }
        .header__content__venor { display:flex; justify-content:space-between; align-items:center; max-width:1200px; margin:0 auto; padding:0 25px; }
        .header__logo img { width:160px; max-width:100%; height:auto; display:block; }
        .header__actions__venor { display:flex; gap:15px; }
        .header__action-btn { color:#fff; text-decoration:none; padding:10px 24px; border-radius:50px; border:1.5px solid rgba(255,255,255,0.3); transition:0.3s; }
        .header__action-btn:hover { background:#fff; color:#000; }

        main { min-height:80vh; padding:40px 20px; }

        .footer-section { border-top:1px solid rgba(255,255,255,0.05); margin-top:80px; padding:40px 0; text-align:center; }
        .container { max-width:1200px; margin:0 auto; }

        .sarab-chat-launcher {
            position: fixed;
            right: 24px;
            bottom: 24px;
            min-width: 64px;
            height: 64px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            background: var(--sarab-blue);
            color: #fff;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0 18px;
            cursor: pointer;
            z-index: 1200;
            box-shadow: 0 12px 28px rgba(0, 123, 255, 0.35);
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.2px;
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .sarab-chat-launcher:hover {
            transform: translateY(-1px);
            box-shadow: 0 16px 32px rgba(0, 123, 255, 0.4);
        }

        .sarab-chat-box {
            position: fixed;
            right: 24px;
            bottom: 100px;
            width: min(390px, calc(100vw - 28px));
            height: min(560px, calc(100dvh - 124px));
            max-height: calc(100dvh - 124px);
            background: #0f1115;
            border: 1px solid rgba(255, 255, 255, 0.16);
            border-radius: 16px;
            overflow: hidden;
            display: none;
            flex-direction: column;
            z-index: 1200;
            box-shadow: 0 22px 55px rgba(0, 0, 0, 0.55);
        }

        .sarab-chat-box.open { display: flex; }

        .sarab-chat-header {
            padding: 14px 16px;
            background: linear-gradient(135deg, #0f62fe, #0a4bcc);
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid rgba(255, 255, 255, 0.16);
        }

        .sarab-chat-brand {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .sarab-chat-title {
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
        }

        .sarab-chat-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 11px;
            opacity: 0.95;
        }

        .sarab-chat-status-dot {
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: #50d890;
        }

        .sarab-chat-close {
            background: transparent;
            border: none;
            color: #fff;
            font-size: 20px;
            line-height: 1;
            cursor: pointer;
            width: 30px;
            height: 30px;
            border-radius: 8px;
        }

        .sarab-chat-close:hover {
            background: rgba(255, 255, 255, 0.14);
        }

        .sarab-chat-messages {
            flex: 1;
            padding: 16px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            gap: 11px;
            background: #101216;
        }

        .sarab-chat-messages::-webkit-scrollbar {
            width: 7px;
        }

        .sarab-chat-messages::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.18);
            border-radius: 999px;
        }

        .sarab-msg {
            max-width: 88%;
            font-size: 13px;
            line-height: 1.55;
            padding: 11px 13px;
            border-radius: 13px;
            white-space: pre-wrap;
        }

        .sarab-msg.bot {
            align-self: flex-start;
            background: #171a20;
            border: 1px solid rgba(255, 255, 255, 0.09);
            color: #eef2ff;
        }

        .sarab-msg.human {
            align-self: flex-start;
            background: #11312a;
            border: 1px solid rgba(80, 216, 144, 0.22);
            color: #eafff4;
        }

        .sarab-msg.system {
            align-self: center;
            max-width: 94%;
            padding: 8px 12px;
            font-size: 12px;
            background: rgba(255, 255, 255, 0.06);
            color: rgba(255, 255, 255, 0.82);
        }

        .sarab-msg.user {
            align-self: flex-end;
            background: #0f62fe;
            color: #fff;
        }

        .sarab-msg a {
            color: #9fc4ff;
            text-decoration: underline;
            font-weight: 600;
        }

        .sarab-msg a:hover {
            color: #c7ddff;
        }

        .sarab-chat-form {
            border-top: 1px solid rgba(255, 255, 255, 0.12);
            padding: 12px;
            display: flex;
            gap: 8px;
            background: #0f1115;
        }

        .sarab-chat-input {
            flex: 1;
            border: 1px solid rgba(255, 255, 255, 0.2);
            background: #171a20;
            color: #fff;
            border-radius: 10px;
            padding: 11px 12px;
            font-size: 13px;
            outline: none;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }

        .sarab-chat-input::placeholder {
            color: rgba(255, 255, 255, 0.58);
        }

        .sarab-chat-input:focus {
            border-color: rgba(15, 98, 254, 0.8);
            box-shadow: 0 0 0 2px rgba(15, 98, 254, 0.18);
        }

        .sarab-chat-send {
            border: none;
            border-radius: 10px;
            background: var(--sarab-blue);
            color: #fff;
            padding: 0 16px;
            font-weight: 600;
            cursor: pointer;
            min-width: 74px;
        }

        .sarab-chat-send:disabled {
            opacity: 0.7;
            cursor: not-allowed;
        }

        .sarab-chat-status-dot.human {
            background: #50d890;
            box-shadow: 0 0 0 4px rgba(80, 216, 144, 0.15);
        }

        @media (max-width: 600px) {
            .sarab-chat-box {
                right: 14px;
                bottom: 88px;
                width: calc(100vw - 28px);
                height: min(560px, calc(100dvh - 106px));
                max-height: calc(100dvh - 106px);
            }

            .sarab-chat-launcher {
                right: 14px;
                bottom: 14px;
            }
        }

        @media (max-height: 700px) {
            .sarab-chat-box {
                height: calc(100dvh - 118px);
                max-height: calc(100dvh - 118px);
            }
        }
    </style>
</head>
<body>

<header class="header">
    <div class="header__content__venor">
        <div class="header__logo">
            <a href="{{ url('/') }}"><img src="https://sarab.tech/public/images/media/17135578102.png"></a>
        </div>
        <nav class="header__actions__venor">
            <a class="header__action-btn" href="{{ route('blog.index') }}">Blog</a>
            <a class="header__action-btn" href="{{ route('portfolio') }}">Our Portfolio</a>
            <a class="header__action-btn" href="{{ route('contact-us') }}">Start a Project</a>
        </nav>
    </div>
</header>

<main>
    @yield('content')
</main>

<footer class="footer-section">
    <div class="container">
        <p>© 2026. Handcrafted by <a href="/" style="color:white;">sarab.tech</a></p>
    </div>
</footer>

<button id="sarabChatLauncher" class="sarab-chat-launcher" aria-label="Open chat">Chat</button>

<section id="sarabChatBox" class="sarab-chat-box" aria-label="Sarab Tech chat widget">
    <div class="sarab-chat-header">
        <div class="sarab-chat-brand">
            <span class="sarab-chat-title">SARAB.tech Assistant</span>
            <span class="sarab-chat-status"><span id="sarabChatStatusDot" class="sarab-chat-status-dot"></span><span id="sarabChatStatusText">AI assistant online</span></span>
        </div>
        <button id="sarabChatClose" class="sarab-chat-close" aria-label="Close chat">×</button>
    </div>

    <div id="sarabChatMessages" class="sarab-chat-messages">
        <div class="sarab-msg bot">Hi! I’m the Sarab assistant. How can I help you today?</div>
    </div>

    <form id="sarabChatForm" class="sarab-chat-form">
        <input id="sarabChatInput" class="sarab-chat-input" type="text" maxlength="1000" placeholder="Ask a question about SARAB.tech..." autocomplete="off" required>
        <button id="sarabChatSend" class="sarab-chat-send" type="submit">Send</button>
    </form>
</section>

<script>
    (() => {
        const launcher = document.getElementById('sarabChatLauncher');
        const chatBox = document.getElementById('sarabChatBox');
        const closeBtn = document.getElementById('sarabChatClose');
        const form = document.getElementById('sarabChatForm');
        const input = document.getElementById('sarabChatInput');
        const sendBtn = document.getElementById('sarabChatSend');
        const messages = document.getElementById('sarabChatMessages');
        const statusText = document.getElementById('sarabChatStatusText');
        const statusDot = document.getElementById('sarabChatStatusDot');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        let lastSeenLogId = 0;
        let humanTakeoverActive = false;
        let activeAgentName = null;
        const seenServerMessageIds = new Set();

        const appendMessage = (text, type, options = {}) => {
            const bubble = document.createElement('div');
            bubble.className = `sarab-msg ${type}`;

            if (options.html) {
                bubble.innerHTML = text;
            } else {
                bubble.textContent = text;
            }

            messages.appendChild(bubble);
            messages.scrollTop = messages.scrollHeight;
        };

        const updateChatStatus = () => {
            statusText.textContent = humanTakeoverActive
                ? `${activeAgentName || 'SARAB team'} joined the chat`
                : 'AI assistant online';

            statusDot.classList.toggle('human', humanTakeoverActive);
            launcher.textContent = humanTakeoverActive ? 'Live Chat' : 'Chat';
            input.placeholder = humanTakeoverActive
                ? 'Send a message to the SARAB team...'
                : 'Ask a question about SARAB.tech...';
        };

        const applySyncPayload = (data) => {
            humanTakeoverActive = Boolean(data.human_takeover_active);
            activeAgentName = typeof data.takeover_by === 'string' && data.takeover_by.trim() !== ''
                ? data.takeover_by.trim()
                : null;

            if (typeof data.last_log_id === 'number') {
                lastSeenLogId = Math.max(lastSeenLogId, data.last_log_id);
            }

            if (Array.isArray(data.messages)) {
                data.messages.forEach((message) => {
                    if (!message || typeof message.id !== 'number' || seenServerMessageIds.has(message.id)) {
                        return;
                    }

                    seenServerMessageIds.add(message.id);

                    const bubbleType = message.kind === 'human'
                        ? 'human'
                        : (message.kind === 'system' ? 'system' : 'bot');

                    appendMessage(message.text || '', bubbleType);
                });
            }

            updateChatStatus();
        };

        const syncChatState = async () => {
            try {
                const url = new URL('{{ route('chatbot.sync') }}', window.location.origin);
                url.searchParams.set('after_log_id', String(lastSeenLogId));

                const response = await fetch(url.toString(), {
                    method: 'GET',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                if (!response.ok) {
                    return;
                }

                applySyncPayload(await response.json());
            } catch (error) {
            }
        };

        updateChatStatus();
        syncChatState();
        window.setInterval(syncChatState, 4000);

        launcher.addEventListener('click', () => {
            chatBox.classList.add('open');
            input.focus();
            syncChatState();
        });

        closeBtn.addEventListener('click', () => {
            chatBox.classList.remove('open');
        });

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const text = input.value.trim();
            if (!text) {
                return;
            }

            appendMessage(text, 'user');
            input.value = '';
            sendBtn.disabled = true;
            appendMessage(humanTakeoverActive ? 'Sending your message to the SARAB team…' : 'Assistant is typing…', humanTakeoverActive ? 'system' : 'bot');

            const typingBubble = messages.lastElementChild;

            try {
                const response = await fetch('{{ route('chatbot.message') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        message: text,
                        page_url: window.location.href,
                    }),
                });

                const data = await response.json();
                typingBubble.remove();

                applySyncPayload(data);

                if (typeof data.reply === 'string' && data.reply.trim() !== '') {
                    appendMessage(data.reply, humanTakeoverActive ? 'human' : 'bot');
                }

                if (data.redirect && typeof data.redirect === 'string') {
                    const redirectLabel = data.redirect === '/contact-us' ? 'Contact Us' : 'this page';

                    appendMessage(
                        `Redirecting you now. <a href="${data.redirect}">Go to ${redirectLabel}</a>`,
                        'bot',
                        { html: true }
                    );

                    setTimeout(() => {
                        window.location.href = data.redirect;
                    }, 2200);
                }

                syncChatState();
            } catch (error) {
                typingBubble.remove();
                appendMessage('Connection issue. Please try again.', 'bot');
            } finally {
                sendBtn.disabled = false;
                input.focus();
            }
        });
    })();
</script>

</body>
</html>
