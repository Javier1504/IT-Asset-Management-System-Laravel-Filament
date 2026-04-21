<?php

namespace App\Filament\Resources\AuditLogs\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuditLogForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Audit Log')
                    ->schema([
                        TextInput::make('user_id')
                            ->label('User ID')
                            ->disabled(),

                        TextInput::make('module')
                            ->label('Module')
                            ->disabled(),

                        TextInput::make('event')
                            ->label('Event')
                            ->disabled(),

                        TextInput::make('auditable_type')
                            ->label('Auditable Type')
                            ->disabled(),

                        TextInput::make('auditable_id')
                            ->label('Auditable ID')
                            ->disabled(),

                        Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->disabled()
                            ->columnSpanFull(),

                        Textarea::make('old_values')
                            ->label('Old Values')
                            ->rows(8)
                            ->disabled()
                            ->columnSpanFull(),

                        Textarea::make('new_values')
                            ->label('New Values')
                            ->rows(8)
                            ->disabled()
                            ->columnSpanFull(),

                        TextInput::make('ip_address')
                            ->label('IP Address')
                            ->disabled(),

                        Textarea::make('user_agent')
                            ->label('User Agent')
                            ->rows(3)
                            ->disabled()
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }
}