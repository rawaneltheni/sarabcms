<?php

namespace App\Http\Controllers;

use App\Models\ChatLog;
use App\Models\ChatSession;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Client\ConnectionException;
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

        if (mb_strlen($message) < 2) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $isArabic
                    ? 'عذرًا، ما فهمتش سؤالك. ممكن توضحه أكثر؟'
                    : 'Sorry, I didn’t get that. Could you rephrase your question?',
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

        if (! $apiKey) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $isArabic
                    ? 'المساعد غير مهيأ بعد. الرجاء إضافة GEMINI_API_KEY في ملف .env.'
                    : 'Chat assistant is not configured yet. Please set GEMINI_API_KEY in your .env file.',
                language: $language,
                pageUrl: $pageUrl,
                status: 500,
                matchedIntent: 'system_not_configured'
            );
        }

        $systemPrompt = <<<'PROMPT'
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

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'x-goog-api-key' => $apiKey,
                ])
                ->post(
                    "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent",
                    [
                        'systemInstruction' => [
                            'parts' => [
                                ['text' => $systemPrompt],
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
        } catch (ConnectionException|Throwable $exception) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $isArabic
                    ? 'أواجه مشكلة اتصال حالياً. حاول مرة أخرى بعد قليل.'
                    : 'I am having trouble connecting right now. Please try again in a moment.',
                language: $language,
                pageUrl: $pageUrl,
                status: 502,
                matchedIntent: 'gemini_connection_error'
            );
        }

        if (! $response->successful()) {
            return $this->respondAndLog(
                request: $request,
                sessionId: $sessionId,
                userMessage: $message,
                botReply: $isArabic
                    ? 'أواجه مشكلة اتصال حالياً. حاول مرة أخرى بعد قليل.'
                    : 'I am having trouble connecting right now. Please try again in a moment.',
                language: $language,
                pageUrl: $pageUrl,
                status: 502,
                matchedIntent: 'gemini_http_error'
            );
        }

        $reply = data_get($response->json(), 'candidates.0.content.parts.0.text');

        if (! is_string($reply) || trim($reply) === '') {
            $reply = $isArabic
                ? 'يمكنني مساعدتك في خدمات SARAB.tech، والأعمال السابقة، وتخطيط المشاريع، وطرق التواصل.'
                : 'I can help with SARAB.tech services, portfolio, project planning, and contact information.';
        }

        return $this->respondAndLog(
            request: $request,
            sessionId: $sessionId,
            userMessage: $message,
            botReply: trim($reply),
            language: $language,
            pageUrl: $pageUrl,
            matchedIntent: 'gemini_ai'
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
                'ar_reply' => 'Rodood هي أول منصة شات بوت كخدمة في ليبيا، تساعد الشركات على أتمتة تواصل العملاء، والتفاعل عبر السوشيال ميديا، وعمليات التجارة الإلكترونية باستخدام الذكاء الاصطناعي.',
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
                'ar_reply' => 'فريقنا يصمم مواقع وتطبيقات جوال احترافية وجذابة ومخصصة لاحتياجك. اضغط على "احصل على عرض" لبدء مشروعك معنا.',
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
                'ar_reply' => 'تقدر تتواصل معنا عبر صفحة اتصل بنا. سأحوّلك لها الآن.',
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

        $inactivityLimitMinutes = 45;

        if (
            $existingSession->last_message_at &&
            $existingSession->last_message_at->lt(now()->subMinutes($inactivityLimitMinutes))
        ) {
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
        $this->storeChatLog(
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

        return response()->json([
            'reply' => $botReply,
            'redirect' => $redirectUrl,
            'session_id' => $sessionId,
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
    ): void {
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

            $session->update([
                'language' => $language,
                'last_message_at' => now(),
                'ended_at' => null,
                'last_page_url' => $pageUrl,
                'ip_address' => $ipAddress,
                'user_agent' => $userAgent,
                'messages_count' => $session->messages_count + 1,
            ]);

            ChatLog::query()->create([
                'chat_session_id' => $session->id,
                'user_message' => $userMessage,
                'bot_reply' => $botReply,
                'language' => $language,
                'matched_intent' => $matchedIntent,
                'redirect_url' => $redirectUrl,
                'page_url' => $pageUrl,
                'meta' => [
                    'source' => 'website-chat-widget',
                ],
            ]);
        } catch (Throwable $exception) {
        }
    }

}
