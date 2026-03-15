<?php

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use App\Models\ChatSession;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ViewChatSession extends ViewRecord
{
    protected static string $resource = ChatSessionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->url(ChatSessionResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
            Actions\Action::make('openChat')
                ->label(fn (): string => $this->getRecord()->human_takeover_active ? 'Open Chat' : 'Join Chat')
                ->icon('heroicon-o-chat-bubble-left-right')
                ->color('success')
                ->disabled(fn (): bool => $this->getRecord()->hasEnded())
                ->tooltip(fn (): ?string => $this->getRecord()->hasEnded() ? 'This chat has already ended.' : null)
                ->url(fn (): string => ChatSessionResource::getUrl('live', ['record' => $this->getRecord()])),
            Actions\Action::make('returnToAi')
                ->label('Return to AI')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('warning')
                ->hidden(fn (): bool => ! $this->getRecord()->human_takeover_active)
                ->disabled(fn (): bool => $this->getRecord()->hasEnded())
                ->tooltip(fn (): ?string => $this->getRecord()->hasEnded() ? 'This chat has ended.' : null)
                ->requiresConfirmation()
                ->successNotificationTitle('AI assistant re-enabled for this chat.')
                ->action(fn (): ChatSession => $this->releaseCurrentChat()),
            Actions\Action::make('downloadHtml')
                ->label('Export Chat')
                ->icon('heroicon-o-arrow-down-tray')
                ->color('primary')
                ->action(fn (): StreamedResponse => $this->downloadHtmlTranscript()),
        ];
    }

    private function downloadHtmlTranscript(): StreamedResponse
    {
        /** @var ChatSession $session */
        $session = $this->getRecord()->loadMissing('logs');

        $html = view('filament.exports.chat-session', [
            'session' => $session,
            'logs' => $session->logs,
        ])->render();

        $fileName = 'chat-session-'.Str::slug($session->session_id).'.html';

        return response()->streamDownload(
            static function () use ($html): void {
                echo $html;
            },
            $fileName,
            ['Content-Type' => 'text/html; charset=UTF-8']
        );
    }

    private function releaseCurrentChat(): ChatSession
    {
        $session = $this->resolveFreshSession();
        $session->releaseHumanTakeover();

        return $this->refreshRecord();
    }

    private function resolveFreshSession(): ChatSession
    {
        /** @var ChatSession $session */
        $session = ChatSession::query()->findOrFail($this->getRecord()->getKey());

        return $session;
    }

    private function refreshRecord(): ChatSession
    {
        /** @var ChatSession $session */
        $session = ChatSession::query()
            ->with(['logs', 'humanTakeoverBy'])
            ->findOrFail($this->getRecord()->getKey());

        $this->record = $session;

        return $session;
    }
}
