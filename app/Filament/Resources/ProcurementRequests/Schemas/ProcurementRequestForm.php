<?php

namespace App\Filament\Resources\ProcurementRequests\Schemas;

use App\Models\User;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProcurementRequestForm
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
                Section::make('Informasi Request Pengadaan')
                    ->schema([
                        Placeholder::make('request_number_info')
                            ->label('Nomor Request')
                            ->content(fn ($record) => $record?->request_number ?? 'Otomatis dibuat setelah data disimpan')
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

                        TextInput::make('item_name')
                            ->label('Nama Barang')
                            ->required()
                            ->maxLength(255),

                        Select::make('category')
                        ->label('Kategori')
                        ->searchable()
                        ->options([
                            'Laptop' => 'Laptop',
                            'PC' => 'PC',
                            'Monitor' => 'Monitor',
                            'Printer' => 'Printer',
                            'Router' => 'Router',
                            'Switch' => 'Switch',
                            'Access Point' => 'Access Point',
                            'Server' => 'Server',
                            'Projector' => 'Projector',
                            'Keyboard' => 'Keyboard',
                            'Mouse' => 'Mouse',
                            'Scanner' => 'Scanner',
                            'UPS' => 'UPS',
                            'Kabel' => 'Kabel',
                            'Aksesoris IT' => 'Aksesoris IT',
                            'Lainnya' => 'Lainnya',
                        ])
                        ->required(),

                        TextInput::make('quantity')
                            ->label('Jumlah')
                            ->required()
                            ->numeric()
                            ->default(1)
                            ->minValue(1),

                        TextInput::make('unit')
                            ->label('Satuan')
                            ->required()
                            ->default('pcs')
                            ->maxLength(50),

                        TextInput::make('estimated_price')
                            ->label('Estimasi Harga')
                            ->numeric()
                            ->prefix('Rp')
                            ->inputMode('decimal')
                            ->required(),

                        Textarea::make('purpose')
                            ->label('Tujuan/Kebutuhan')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),

                        Textarea::make('specification')
                            ->label('Spesifikasi Barang')
                            ->rows(3)
                            ->required()
                            ->columnSpanFull(),

                        Hidden::make('priority')
                            ->default('medium')
                            ->dehydrated(true),
                    ])
                    ->columns(2),
            ]);
    }
}