<?php

namespace App\Filament\Resources\MaintenanceRequests\Schemas;

use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaintenanceRequestForm
{
    public static function configure(Schema $schema): Schema
    {
        $user = auth()->user();
        $isSuperadmin = $user?->hasRole('superadmin') ?? false;
        $isAdmin = $user?->hasRole('admin') ?? false;
        $isManager = $user?->hasRole('manager') ?? false;

        $isAdminLike = $isSuperadmin || $isAdmin;

        return $schema
            ->components([
                Section::make('Informasi Request Maintenance')
                    ->schema([
                        Placeholder::make('ticket_number_info')
                            ->label('Nomor Tiket')
                            ->content(fn ($record) => $record?->ticket_number ?? 'Otomatis dibuat setelah data disimpan')
                            ->visible(fn (string $operation) => $operation === 'edit'),

                        Hidden::make('requester_id')
                            ->default(fn () => auth()->id())
                            ->dehydrated(true),

                        Hidden::make('manager_id')
                            ->default(fn () => ($isManager ? auth()->id() : null))
                            ->dehydrated(fn () => $isManager),

                        Select::make('manager_id')
                            ->label('Manager')
                            ->options(
                                User::query()
                                    ->where('is_active', true)
                                    ->whereHas('roles', fn ($q) => $q->where('name', 'manager'))
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->toArray()
                            )
                            ->searchable()
                            ->preload()
                            ->required()
                            ->visible(fn () => $isAdminLike)
                            ->default(fn () => auth()->id()),

                        Select::make('employee_id')
                            ->label('Diajukan Untuk')
                            ->options(function () use ($user) {
                                $options = User::query()
                                    ->where('is_active', true)
                                    ->where(function ($q) {
                                        $q->whereHas('roles', fn ($r) => $r->where('name', 'user'))
                                          ->orWhereHas('roles', fn ($r) => $r->where('name', 'manager'));
                                    })
                                    ->orderBy('name')
                                    ->pluck('name', 'id')
                                    ->toArray();

                                if ($user && ! isset($options[$user->id])) {
                                    $options[$user->id] = $user->name . ' (Saya sendiri)';
                                }

                                return $options;
                            })
                            ->searchable()
                            ->preload()
                            ->required(),

                        Select::make('asset_id')
                            ->label('Aset Terkait')
                            ->relationship(
                                name: 'asset',
                                titleAttribute: 'name',
                                modifyQueryUsing: fn ($query) => $query->where('is_active', true)
                            )
                            ->searchable()
                            ->preload()
                            ->nullable(),

                        TextInput::make('title')
                            ->label('Judul Permasalahan')
                            ->required()
                            ->maxLength(255),

                        Textarea::make('description')
                            ->label('Deskripsi Keluhan')
                            ->required()
                            ->rows(4)
                            ->columnSpanFull(),

                        Hidden::make('priority')
                            ->default('medium')
                            ->dehydrated(true),
                    ])
                    ->columns(2),
            ]);
    }
}