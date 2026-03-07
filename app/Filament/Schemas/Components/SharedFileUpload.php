<?php

namespace App\Filament\Schemas\Components;

use Filament\Forms\Components\FileUpload;

class SharedFileUpload
{
    public static function make(string $name, string $label, string $directory): FileUpload
    {
        return FileUpload::make($name)
            ->label($label)
            ->image()
            ->directory($directory)
            ->disk('public')
            ->visibility('public')
            ->imageEditor()
            ->previewable()
            ->openable();
    }
}
