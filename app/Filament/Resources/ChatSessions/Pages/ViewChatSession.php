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
}
