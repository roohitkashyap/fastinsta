<?php

namespace App\Filament\Resources\DownloadLogs\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class DownloadLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Textarea::make('url')
                    ->required()
                    ->columnSpanFull(),
                TextInput::make('shortcode'),
                TextInput::make('media_type'),
                TextInput::make('status')
                    ->required()
                    ->default('pending'),
                TextInput::make('strategy_used'),
                TextInput::make('ip_address'),
                Textarea::make('user_agent')
                    ->columnSpanFull(),
                Textarea::make('error_message')
                    ->columnSpanFull(),
                TextInput::make('media_count')
                    ->required()
                    ->numeric()
                    ->default(0),
            ]);
    }
}
