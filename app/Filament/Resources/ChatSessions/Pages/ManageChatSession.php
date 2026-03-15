<?php

namespace App\Filament\Resources\ChatSessions\Pages;

use App\Filament\Resources\ChatSessions\ChatSessionResource;
use App\Models\ChatSession;
use Filament\Actions;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Resources\Pages\Page;
use Illuminate\Support\Facades\Auth;

class ManageChatSession extends Page
{
    use InteractsWithRecord;

    protected static string $resource = ChatSessionResource::class;

    protected string $view = 'filament.resources.chat-sessions.pages.manage-chat-session';

    public string $message = '';

    public function mount(int | string $record): void
    {
        $this->record = $this->resolveRecord($record);

        abort_unless(static::getResource()::canView($this->getRecord()), 403);

        $this->refreshChat();

        if (! $this->getRecord()->hasEnded() && ! $this->getRecord()->human_takeover_active) {
            $this->getRecord()->joinHumanTakeover(Auth::user());
            $this->refreshChat();
        }

        $this->dispatch('chat-updated');
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('back')
                ->label('Back')
                ->url(ChatSessionResource::getUrl('index'))
                ->icon('heroicon-o-arrow-left'),
            Actions\Action::make('transcript')
                ->label('Transcript')
                ->url(ChatSessionResource::getUrl('view', ['record' => $this->getRecord()]))
                ->icon('heroicon-o-document-text'),
            Actions\Action::make('returnToAi')
                ->label('Return to AI')
                ->icon('heroicon-o-arrow-uturn-left')
                ->color('warning')
                ->hidden(fn (): bool => ! $this->getRecord()->human_takeover_active)
                ->disabled(fn (): bool => $this->getRecord()->hasEnded())
                ->tooltip(fn (): ?string => $this->getRecord()->hasEnded() ? 'This chat has ended.' : null)
                ->requiresConfirmation()
                ->successNotificationTitle('AI assistant re-enabled for this chat.')
                ->action(function (): void {
                    $this->getRecord()->releaseHumanTakeover();
                    $this->refreshChat();
                    $this->dispatch('chat-updated');
                }),
        ];
    }

    public function refreshChat(): void
    {
        /** @var ChatSession $session */
        $session = ChatSession::query()
            ->with(['logs', 'humanTakeoverBy'])
            ->findOrFail($this->getRecord()->getKey());

        $this->record = $session;
    }

    public function sendReply(): void
    {
        if ($this->getRecord()->hasEnded()) {
            return;
        }

        $validated = $this->validate([
            'message' => ['required', 'string', 'min:1', 'max:2000'],
        ]);

        $this->getRecord()->sendHumanReply($validated['message'], Auth::user());
        $this->message = '';

        $this->refreshChat();
        $this->dispatch('chat-updated');
    }

    public function getSession(): ChatSession
    {
        /** @var ChatSession $session */
        $session = $this->getRecord();

        return $session;
    }
}
