<?php

namespace App\Filament\Resources\Assets\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AssetInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Aset')
                    ->schema([
                        TextEntry::make('asset_code')->label('Kode Aset'),
                        TextEntry::make('name')->label('Nama Aset'),
                        TextEntry::make('category')->label('Kategori'),
                        TextEntry::make('condition_status')
                            ->label('Kondisi')
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'good' => 'Baik',
                                'fair' => 'Cukup',
                                'damaged' => 'Rusak',
                                'under_maintenance' => 'Dalam Maintenance',
                                'retired' => 'Tidak Aktif / Pensiun',
                                default => $state,
                            }),
                        TextEntry::make('brand')->label('Merek')->placeholder('-'),
                        TextEntry::make('model')->label('Model')->placeholder('-'),
                        TextEntry::make('serial_number')->label('Serial Number')->placeholder('-'),
                        TextEntry::make('location')->label('Lokasi')->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Informasi Pembelian')
                    ->schema([
                        TextEntry::make('purchase_date')
                            ->label('Tanggal Pembelian')
                            ->date('d M Y')
                            ->placeholder('-'),
                        TextEntry::make('purchase_price')
                            ->label('Harga Pembelian')
                            ->money('IDR', locale: 'id')
                            ->placeholder('-'),
                        IconEntry::make('is_active')
                            ->label('Aset Aktif')
                            ->boolean(),
                    ])
                    ->columns(2),

                Section::make('Keterangan')
                    ->schema([
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}