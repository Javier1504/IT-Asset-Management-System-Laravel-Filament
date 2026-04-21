<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Utama Aset')
                    ->schema([
                        TextInput::make('asset_code')
                            ->label('Kode Aset')
                            ->required()
                            ->maxLength(255)
                            ->unique(ignoreRecord: true)
                            ->placeholder('Contoh: AST-0001'),

                        TextInput::make('name')
                            ->label('Nama Aset')
                            ->required()
                            ->maxLength(255)
                            ->placeholder('Contoh: Laptop Dell Latitude'),

                        Select::make('category')
                            ->label('Kategori')
                            ->required()
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
                                'Lainnya' => 'Lainnya',
                            ]),

                        Select::make('condition_status')
                            ->label('Kondisi')
                            ->required()
                            ->default('good')
                            ->options([
                                'good' => 'Baik',
                                'fair' => 'Cukup',
                                'damaged' => 'Rusak',
                                'under_maintenance' => 'Dalam Maintenance',
                                'retired' => 'Tidak Aktif / Pensiun',
                            ]),
                    ])
                    ->columns(2),

                Section::make('Spesifikasi dan Lokasi')
                    ->schema([
                        TextInput::make('brand')
                            ->label('Merek')
                            ->maxLength(255),

                        TextInput::make('model')
                            ->label('Model')
                            ->maxLength(255),

                        TextInput::make('serial_number')
                            ->label('Serial Number')
                            ->maxLength(255)
                            ->unique(ignoreRecord: true),

                        TextInput::make('location')
                            ->label('Lokasi')
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make('Informasi Pembelian')
                    ->schema([
                        DatePicker::make('purchase_date')
                            ->label('Tanggal Pembelian')
                            ->native(false)
                            ->displayFormat('d/m/Y'),

                        TextInput::make('purchase_price')
                            ->label('Harga Pembelian')
                            ->numeric()
                            ->prefix('Rp')
                            ->inputMode('decimal'),
                    ])
                    ->columns(2),

                Section::make('Informasi Tambahan')
                    ->schema([
                        Textarea::make('description')
                            ->label('Deskripsi')
                            ->rows(4)
                            ->columnSpanFull(),

                        Toggle::make('is_active')
                            ->label('Aset Aktif')
                            ->default(true)
                            ->inline(false),
                    ]),
            ]);
    }
}