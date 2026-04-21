<?php

namespace App\Filament\Resources\Assets\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class AssetsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('asset_code')
                    ->label('Kode Aset')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('name')
                    ->label('Nama Aset')
                    ->searchable()
                    ->sortable()
                    ->limit(35)
                    ->wrap(),

                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->sortable()
                    ->badge(),

                TextColumn::make('brand')
                    ->label('Merek')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->sortable()
                    ->placeholder('-')
                    ->toggleable(),

                TextColumn::make('condition_status')
                    ->label('Kondisi')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'good' => 'Baik',
                        'fair' => 'Cukup',
                        'damaged' => 'Rusak',
                        'under_maintenance' => 'Dalam Maintenance',
                        'retired' => 'Tidak Aktif / Pensiun',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'good' => 'success',
                        'fair' => 'warning',
                        'under_maintenance' => 'warning',
                        'damaged' => 'danger',
                        'retired' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),

                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean()
                    ->sortable(),

                TextColumn::make('purchase_price')
                    ->label('Harga')
                    ->money('IDR', locale: 'id')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),

                TextColumn::make('purchase_date')
                    ->label('Tgl Beli')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
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

                SelectFilter::make('condition_status')
                    ->label('Kondisi')
                    ->options([
                        'good' => 'Baik',
                        'fair' => 'Cukup',
                        'damaged' => 'Rusak',
                        'under_maintenance' => 'Dalam Maintenance',
                        'retired' => 'Tidak Aktif / Pensiun',
                    ]),

                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->placeholder('Semua')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make()
                    ->visible(fn (): bool => auth()->user()?->hasAnyRole(['superadmin', 'admin']) ?? false),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->hasRole('superadmin') ?? false),
                ]),
            ]);
    }
}