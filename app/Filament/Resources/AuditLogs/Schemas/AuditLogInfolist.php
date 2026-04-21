<?php

namespace App\Filament\Resources\AuditLogs\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class AuditLogInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Audit')
                    ->schema([
                        TextEntry::make('user.name')
                            ->label('User')
                            ->placeholder('-'),

                        TextEntry::make('module')
                            ->label('Module')
                            ->badge(),

                        TextEntry::make('event')
                            ->label('Event')
                            ->badge(),

                        TextEntry::make('auditable_type')
                            ->label('Auditable Type')
                            ->formatStateUsing(fn ($state) => $state ? Str::afterLast($state, '\\') : '-')
                            ->placeholder('-'),

                        TextEntry::make('auditable_id')
                            ->label('Auditable ID')
                            ->placeholder('-'),

                        TextEntry::make('description')
                            ->label('Description')
                            ->placeholder('-')
                            ->columnSpanFull(),

                        TextEntry::make('ip_address')
                            ->label('IP Address')
                            ->placeholder('-'),

                        TextEntry::make('created_at')
                            ->label('Waktu')
                            ->dateTime('d M Y H:i:s'),
                    ])
                    ->columns(2),

                Section::make('Old Values')
                    ->schema([
                        TextEntry::make('old_values')
                            ->label('Data Lama')
                            ->formatStateUsing(fn ($state) => empty($state) ? '-' : json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('New Values')
                    ->schema([
                        TextEntry::make('new_values')
                            ->label('Data Baru')
                            ->formatStateUsing(fn ($state) => empty($state) ? '-' : json_encode($state, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('User Agent')
                    ->schema([
                        TextEntry::make('user_agent')
                            ->label('User Agent')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}