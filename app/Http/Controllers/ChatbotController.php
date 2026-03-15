<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\ChatSession;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Throwable;

class ChatbotController extends Controller
{
    public function message(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'min:1', 'max:1000'],
            'page_url' => ['nullable', 'string', 'max:2048'],
        ]);

        $message = trim($validated['message']);
        $sessionId = $this->resolveSessionId($request);
        $pageUrl = $validated['page_url'] ?? null;
        $isArabic = $this->containsArabic($message);
        $language = $isArabic ? 'ar' : 'en';

        $existingSession = $this->findSession($sessionId);

        if ($existingSession?->human_takeover_active) {
            return $this->queueForHuman(
                session: $existingSession,
                sessionId: $sessionId,
                userMessage: $message,
                language: $language,
                pageUrl: $pageUrl
            );
        }

        if (mb_strlen($message) < 2) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $this->unclearInputReply($isArabic),
                language: $language,
                pageUrl: $pageUrl,
                matchedIntent: 'unclear_input'
            );
        }

        $intentResponse = $this->matchIntentResponse($message, $isArabic);
        if ($intentResponse !== null) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $intentResponse['reply'],
                language: $language,
                pageUrl: $pageUrl,
                matchedIntent: $intentResponse['intent'] ?? null,
                redirectUrl: $intentResponse['redirect'] ?? null
            );
        }

        $apiKey = config('services.gemini.api_key');
        $model = config('services.gemini.model', 'gemini-1.5-flash');

        if (! filled($apiKey)) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $this->geminiNotConfiguredReply($isArabic),
                language: $language,
                pageUrl: $pageUrl,
                status: 500,
                matchedIntent: 'system_not_configured'
            );
        }

        try {
            $response = $this->requestGeminiReply($apiKey, $model, $message);
        } catch (ConnectionException|Throwable $exception) {
            return $this->respondWithGeminiFailure(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                language: $language,
                pageUrl: $pageUrl,
                isArabic: $isArabic,
                matchedIntent: 'gemini_connection_error'
            );
        }

        if (! $response->successful()) {
            return $this->respondWithGeminiFailure(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                language: $language,
                pageUrl: $pageUrl,
                isArabic: $isArabic,
                matchedIntent: 'gemini_http_error'
            );
        }

        return $this->respondAndLog(
            request: $request,
            sessionId: $sessionId,
            userMessage: $message,
            botReply: $this->extractGeminiReply($response, $isArabic),
            language: $language,
            pageUrl: $pageUrl,
            matchedIntent: 'gemini_ai'
        );
    }

    public function sync(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'after_log_id' => ['nullable', 'integer', 'min:0'],
        ]);

        $sessionId = trim((string) $request->session()->get('chat_session_id', ''));
        $afterLogId = (int) ($validated['after_log_id'] ?? 0);

        if ($sessionId === '') {
            return $this->emptySyncResponse($afterLogId);
        }

        $session = $this->findSession($sessionId);

        if (! $session) {
            return $this->emptySyncResponse($afterLogId, $sessionId);
        }

        $logs = $session->logs()
            ->where('id', '>', $afterLogId)
            ->orderBy('id')
            ->get();

        return response()->json([
            'session_id' => $session->session_id,
            'human_takeover_active' => (bool) $session->human_takeover_active,
            'takeover_by' => $session->humanTakeoverBy?->name,
            'last_log_id' => (int) ($logs->max('id') ?? $afterLogId),
            'messages' => $logs
                ->filter(fn (ChatLog $log): bool => filled(trim((string) $log->bot_reply)))
                ->map(function (ChatLog $log): array {
                    $source = data_get($log->meta, 'source');

                    return [
                        'id' => $log->id,
                        'text' => $log->bot_reply,
                        'kind' => match ($source) {
                            'human-agent' => 'human',
                            'system' => 'system',
                            default => 'assistant',
                        },
                        'created_at' => $log->created_at?->toIso8601String(),
                    ];
                })
                ->values(),
        ]);
    }

    private function emptySyncResponse(int $afterLogId = 0, ?string $sessionId = null): JsonResponse
    {
        return response()->json([
            'session_id' => $sessionId,
            'human_takeover_active' => false,
            'takeover_by' => null,
            'last_log_id' => $afterLogId,
            'messages' => [],
        ]);
    }

    private function findSession(string $sessionId): ?ChatSession
    {
        return ChatSession::query()
            ->with('humanTakeoverBy')
            ->where('session_id', $sessionId)
            ->first();
    }

    private function unclearInputReply(bool $isArabic): string
    {
        return $isArabic
            ? 'عذرًا، لم أفهم سؤالك. هل يمكنك توضيحه أكثر؟'
            : 'Sorry, I didn’t get that. Could you rephrase your question?';
    }

    private function geminiNotConfiguredReply(bool $isArabic): string
    {
        return $isArabic
            ? 'المساعد غير مهيأ بعد. يرجى إضافة GEMINI_API_KEY في ملف .env.'
            : 'Chat assistant is not configured yet. Please set GEMINI_API_KEY in your .env file.';
    }

    private function geminiConnectionReply(bool $isArabic): string
    {
        return $isArabic
            ? 'أواجه مشكلة في الاتصال حاليًا. يرجى المحاولة مرة أخرى بعد قليل.'
            : 'I am having trouble connecting right now. Please try again in a moment.';
    }

    private function defaultAssistantReply(bool $isArabic): string
    {
        return $isArabic
            ? 'يمكنني مساعدتك في خدمات SARAB.tech، والأعمال السابقة، وتخطيط المشاريع، وطرق التواصل.'
            : 'I can help with SARAB.tech services, portfolio, project planning, and contact information.';
    }

    private function buildSystemPrompt(): string
    {
        return <<<'PROMPT'
    You are the SARAB.tech assistant.

    Conversation start policy:
    - Greet the user with one short, friendly sentence.
    - Do not list services or features in the greeting.
    - Only answer details once the user asks a question.

    Behavior rules:
    - Answer user questions using AI reasoning, not only fixed Q&A.
    - Scope is SARAB.tech only: company identity, services, products, portfolio, process, pricing/quotes, hosting, SEO, training, and contact.
    - If question is outside SARAB.tech scope, politely refuse and ask user to ask SARAB.tech-related questions.
    - If user asks to contact/reach SARAB.tech, guide them to the Contact Us page at /contact-us.
    - Keep responses concise, practical, and friendly.
    - Reply in the same language as the user's question when possible (Arabic or English).
    - If replying in Arabic, use formal Modern Standard Arabic only.
    - Avoid Arabic dialects, slang, colloquial phrasing, and informal expressions.
    - Keep Arabic wording polished, respectful, and professional.
    - Never invent hard facts, numbers, or promises not present in provided knowledge.

    Trusted SARAB.tech knowledge:
    - Sarab Tech is a Benghazi-based technology company focused on innovation, digital transformation, and creative solutions.
    - Services: website and mobile app development, chatbot-as-a-service (Rodood), crowdfunding platforms, professional training and consulting, ethical SEO, and Linux-based web hosting.
    - Track record: over 250 happy customers and more than 2,000,000 service users.
    - Rodood: first chatbot-as-a-service platform in Libya for customer communication, social media engagement, and eCommerce automation using AI.
    - SmartBank: modern online banking platform with QR transfers, prepaid card management, and secure account monitoring.
    - Headquarters: Benghazi, Libya.
    - Training: over 50 trainees.
    PROMPT;
    }

    private function requestGeminiReply(string $apiKey, string $model, string $message): Response
    {
        return Http::timeout(20)
            ->withHeaders([
                'x-goog-api-key' => $apiKey,
            ])
            ->post(
                "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                [
                    'systemInstruction' => [
                        'parts' => [
                            ['text' => $this->buildSystemPrompt()],
                        ],
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $message],
                            ],
                        ],
                    ],
                    'generationConfig' => [
                        'temperature' => 0.4,
                        'maxOutputTokens' => 350,
                    ],
                ]
            );
    }

    private function extractGeminiReply(Response $response, bool $isArabic): string
    {
        $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (! is_string($reply) || trim($reply) === '') {
            return $this->defaultAssistantReply($isArabic);
        }

        return trim($reply);
    }

    private function respondWithGeminiFailure(
        Request $request,
        string $sessionId,
        string $userMessage,
        string $language,
        ?string $pageUrl,
        bool $isArabic,
        string $matchedIntent,
    ): JsonResponse {
        return $this->respondAndLog(
            request: $request,
            sessionId: $sessionId,
            userMessage: $userMessage,
            botReply: $this->geminiConnectionReply($isArabic),
            language: $language,
            pageUrl: $pageUrl,
            status: 502,
            matchedIntent: $matchedIntent
        );
    }

    private function matchIntentResponse(string $message, bool $isArabic = false): ?array
    {
        $text = mb_strtolower($message);

        $rules = [
            [
                'intent' => 'identity',
                'patterns' => ['who is sarab', 'what is sarab tech', 'about sarab tech', 'who are you', 'من هي شركة سراب', 'من هو سراب تك', 'ما هي سراب تك', 'نبذة عن سراب'],
                'reply' => 'Sarab Tech is a Benghazi-based technology company founded to help brands grow through innovation, digital transformation, and creative solutions.',
                'ar_reply' => 'سراب تك شركة تقنية مقرها بنغازي، تأسست لمساعدة العلامات التجارية على النمو عبر الابتكار والتحول الرقمي والحلول الإبداعية.',
            ],
            [
                'intent' => 'capabilities',
                'patterns' => ['what do you do', 'what services', 'your services', 'capabilities', 'ماذا تقدمون', 'ما خدماتكم', 'الخدمات', 'قدراتكم'],
                'reply' => 'We specialize in website and mobile app development, chatbot-as-a-service (Rodood), crowdfunding platforms, and professional training and consulting.',
                'ar_reply' => 'نتخصص في تطوير المواقع وتطبيقات الجوال، وخدمة الشات بوت (Rodood)، ومنصات التمويل الجماعي، إضافة إلى التدريب والاستشارات المهنية.',
            ],
            [
                'intent' => 'track_record',
                'patterns' => ['how many clients', 'how many customer', 'track record', 'users served', 'كم عدد العملاء', 'عدد العملاء', 'سجل الإنجازات', 'كم عدد المستخدمين'],
                'reply' => 'We have served over 250 happy customers and supported more than 2,000,000 service users across our digital platforms.',
                'ar_reply' => 'خدمنا أكثر من 250 عميلاً سعيداً، ودعمنا أكثر من 2,000,000 مستخدم عبر منصاتنا الرقمية.',
            ],
            [
                'intent' => 'rodood',
                'patterns' => ['what is rodood', 'rodood', 'ما هو ردود', 'منصة ردود', 'ردود'],
                'reply' => 'Rodood is the first chatbot-as-a-service platform in Libya, helping businesses automate customer communication, social media engagement, and eCommerce operations using AI.',
                'ar_reply' => 'Rodood هي أول منصة لروبوتات المحادثة كخدمة في ليبيا، وتساعد الشركات على أتمتة تواصل العملاء، وتعزيز التفاعل عبر وسائل التواصل الاجتماعي، وإدارة عمليات التجارة الإلكترونية باستخدام الذكاء الاصطناعي.',
            ],
            [
                'intent' => 'smartbank',
                'patterns' => ['what is smartbank', 'smartbank', 'ما هو سمارت بنك', 'سمارت بنك'],
                'reply' => 'SmartBank is a modern online banking platform developed by Sarab Tech, featuring QR code transfers, prepaid card management, and secure account monitoring.',
                'ar_reply' => 'SmartBank منصة مصرفية رقمية حديثة طورتها سراب تك، وتتميز بتحويلات QR وإدارة البطاقات المسبقة الدفع ومراقبة الحسابات بشكل آمن.',
            ],
            [
                'intent' => 'location',
                'patterns' => ['where are you based', 'where are you located', 'location', 'benghazi', 'libya', 'اين مقركم', 'وين مكانكم', 'المقر', 'بنغازي', 'ليبيا'],
                'reply' => 'Our headquarters are in Benghazi, Libya.',
                'ar_reply' => 'مقرنا الرئيسي في بنغازي، ليبيا.',
            ],
            [
                'intent' => 'service_logic',
                'patterns' => ['how can i get an app built', 'build an app', 'start app project', 'get your offer', 'كيف ابني تطبيق', 'ابي تطبيق', 'ابدأ مشروع تطبيق', 'احصل على عرض'],
                'reply' => 'Our expert team designs visually engaging and highly functional websites and mobile apps tailored to your needs. Click “Get Your Offer” to start your project with us.',
                'ar_reply' => 'يعمل فريقنا على تصميم وتطوير مواقع إلكترونية وتطبيقات جوال احترافية وجذابة، ومصممة بما يلائم احتياجاتك. يرجى الضغط على "احصل على عرض" لبدء مشروعك معنا.',
            ],
            [
                'intent' => 'training',
                'patterns' => ['do you offer courses', 'training', 'consulting', 'courses', 'هل تقدمون دورات', 'تدريب', 'استشارات', 'دورات'],
                'reply' => 'Yes. Sarab Tech has trained over 50 trainees through hands-on programs and consulting designed to build strong digital and technical skills.',
                'ar_reply' => 'نعم. قامت سراب تك بتدريب أكثر من 50 متدرباً عبر برامج عملية واستشارات تهدف لبناء مهارات رقمية وتقنية قوية.',
            ],
            [
                'intent' => 'seo',
                'patterns' => ['seo', 'search engine optimization', 'السيو', 'تهيئة محركات البحث', 'تحسين محركات البحث'],
                'reply' => 'Our team follows ethical SEO practices and international standards to improve your website’s visibility and ranking across major search engines.',
                'ar_reply' => 'يتبع فريقنا ممارسات SEO أخلاقية ومعايير دولية لتحسين ظهور موقعك وترتيبه في محركات البحث الرئيسية.',
            ],
            [
                'intent' => 'hosting',
                'patterns' => ['hosting', 'host my website', 'server', 'استضافة', 'استضافة موقعي', 'سيرفر'],
                'reply' => 'We provide cost-effective, high-performance web hosting on fast and secure Linux-based servers.',
                'ar_reply' => 'نوفر استضافة ويب عالية الأداء وبتكلفة مناسبة على خوادم لينكس سريعة وآمنة.',
            ],
            [
                'intent' => 'contact_navigation',
                'patterns' => ['how can i contact you', 'how do i reach you', 'how can i reach you', 'how can i reach sarab', 'how can i reach sarab tech', 'reach sarab', 'reach sarab tech', 'contact us', 'contact', 'how can i reach', 'كيف اتواصل معكم', 'طريقة التواصل', 'اتصل بنا', 'تواصل', 'كيف اوصل لكم', 'كيف اتواصل مع سراب'],
                'reply' => 'You can reach us through our Contact Us page. I’ll take you there now.',
                'ar_reply' => 'يمكنك التواصل معنا عبر صفحة اتصل بنا. سأحوّلك إليها الآن.',
                'redirect' => '/contact-us',
            ],
        ];

        foreach ($rules as $rule) {
            foreach ($rule['patterns'] as $pattern) {
                if (str_contains($text, $pattern)) {
                    return [
                        'reply' => $isArabic ? ($rule['ar_reply'] ?? $rule['reply']) : $rule['reply'],
                        'intent' => $rule['intent'] ?? null,
                        'redirect' => $rule['redirect'] ?? null,
                    ];
                }
            }
        }

        return null;
    }

    private function containsArabic(string $text): bool
    {
        return preg_match('/[\x{0600}-\x{06FF}]/u', $text) === 1;
    }

    private function resolveSessionId(Request $request): string
    {
        $sessionId = trim((string) $request->session()->get('chat_session_id', ''));

        if ($sessionId === '' || mb_strlen($sessionId) > 64) {
            $sessionId = (string) Str::uuid();
            $request->session()->put('chat_session_id', $sessionId);

            return $sessionId;
        }

        $existingSession = ChatSession::query()
            ->where('session_id', $sessionId)
            ->first();

        if (! $existingSession) {
            $newSessionId = (string) Str::uuid();
            $request->session()->put('chat_session_id', $newSessionId);

            return $newSessionId;
        }

        if ($existingSession->hasEnded()) {
            $newSessionId = (string) Str::uuid();
            $request->session()->put('chat_session_id', $newSessionId);

            return $newSessionId;
        }

        return $sessionId;
    }

    private function respondAndLog(
        Request $request,
        string $sessionId,
        string $userMessage,
        string $botReply,
        string $language,
        ?string $pageUrl = null,
        ?string $matchedIntent = null,
        ?string $redirectUrl = null,
        int $status = 200
    ): JsonResponse {
        $log = $this->storeChatLog(
            sessionId: $sessionId,
            userMessage: $userMessage,
            botReply: $botReply,
            language: $language,
            pageUrl: $pageUrl,
            matchedIntent: $matchedIntent,
            redirectUrl: $redirectUrl,
            ipAddress: $request->ip(),
            userAgent: $request->userAgent()
        );

        $session = $this->findSession($sessionId);

        return response()->json([
            'reply' => $botReply,
            'redirect' => $redirectUrl,
            'session_id' => $sessionId,
            'last_log_id' => $log?->id,
            'human_takeover_active' => (bool) $session?->human_takeover_active,
            'takeover_by' => $session?->humanTakeoverBy?->name,
        ], $status);
    }

    private function storeChatLog(
        string $sessionId,
        string $userMessage,
        string $botReply,
        string $language,
        ?string $pageUrl,
        ?string $matchedIntent,
        ?string $redirectUrl,
        ?string $ipAddress,
        ?string $userAgent
    ): ?ChatLog {
        try {
            $session = ChatSession::query()->firstOrCreate(
                ['session_id' => $sessionId],
                [
                    'started_at' => now(),
                    'first_page_url' => $pageUrl,
                    'language' => $language,
                    'ip_address' => $ipAddress,
                    'user_agent' => $userAgent,
                ]
            );

            $session->forceFill([
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
            ])->save();

            return $session->appendLog(
                userMessage: $userMessage,
                botReply: $botReply,
                language: $language,
                matchedIntent: $matchedIntent,
                redirectUrl: $redirectUrl,
                pageUrl: $pageUrl,
                meta: [
                    'source' => 'website-chat-widget',
                ],
            );
        } catch (Throwable $exception) {
            report($exception);

            return null;
        }
    }

    private function queueForHuman(
        ChatSession $session,
        string $sessionId,
        string $userMessage,
        string $language,
        ?string $pageUrl = null,
    ): JsonResponse {
        $log = $session->appendLog(
            userMessage: $userMessage,
            botReply: '',
            language: $language,
            matchedIntent: 'human_takeover_queue',
            pageUrl: $pageUrl,
            meta: [
                'source' => 'website-chat-widget',
                'queued_for_human' => true,
            ],
        );

        return response()->json([
            'reply' => null,
            'redirect' => null,
            'session_id' => $sessionId,
            'queued_for_human' => true,
            'last_log_id' => $log->id,
            'human_takeover_active' => true,
            'takeover_by' => $session->humanTakeoverBy?->name,
        ]);
    }

}
