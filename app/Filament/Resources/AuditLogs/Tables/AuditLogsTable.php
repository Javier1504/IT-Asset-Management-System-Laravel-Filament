<?php

namespace App\Filament\Resources\AuditLogs\Tables;

use Filament\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class AuditLogsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Waktu')
                    ->dateTime('d M Y H:i:s')
                    ->sortable(),

                TextColumn::make('user.name')
                    ->label('User')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-'),

                TextColumn::make('module')
                    ->label('Module')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('event')
                    ->label('Event')
                    ->badge()
                    ->searchable()
                    ->sortable(),

                TextColumn::make('auditable_type')
                    ->label('Target')
                    ->formatStateUsing(fn ($state) => $state ? Str::afterLast($state, '\\') : '-')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('auditable_id')
                    ->label('Target ID')
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('description')
                    ->label('Description')
                    ->limit(50)
                    ->wrap()
                    ->placeholder('-'),

                TextColumn::make('ip_address')
                    ->label('IP')
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->label('Updated')
                    ->dateTime('d M Y H:i:s')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('module')
                    ->label('Module')
                    ->options([
                        'maintenance' => 'maintenance',
                        'procurement' => 'procurement',
                        'asset' => 'asset',
                        'auth' => 'auth',
                        'user_management' => 'user_management',
                    ]),

                SelectFilter::make('event')
                    ->label('Event')
                    ->options([
                        'created' => 'created',
                        'updated' => 'updated',
                        'deleted' => 'deleted',
                        'assigned' => 'assigned',
                        'verified' => 'verified',
                        'completed' => 'completed',
                        'login' => 'login',
                        'logout' => 'logout',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
            ]);
    }
}