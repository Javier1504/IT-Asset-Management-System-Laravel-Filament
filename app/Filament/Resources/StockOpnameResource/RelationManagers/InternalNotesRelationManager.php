<?php

namespace App\Filament\Resources\StockOpnameResource\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternalNotesRelationManager extends RelationManager
{
    protected static string $relationship = 'internalNotes';

    protected static ?string $title = 'Catatan Tindak Lanjut';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('stock_opname_item_id')
                    ->label('Item Stock Opname')
                    ->relationship('item', 'snapshot_asset_number')
                    ->searchable()
                    ->preload(),

                Select::make('type')
                    ->label('Jenis')
                    ->options([
                        'note' => 'Catatan',
                        'follow_up' => 'Tindak Lanjut',
                        'risk' => 'Risiko',
                    ])
                    ->default('follow_up')
                    ->required(),

                Select::make('priority')
                    ->label('Prioritas')
                    ->options([
                        'low' => 'Rendah',
                        'normal' => 'Normal',
                        'high' => 'Tinggi',
                        'urgent' => 'Urgent',
                    ])
                    ->default('normal')
                    ->required(),

                DatePicker::make('due_date')
                    ->label('Batas Tindak Lanjut'),

                Select::make('status')
                    ->label('Status')
                    ->options([
                        'open' => 'Open',
                        'in_progress' => 'Diproses',
                        'closed' => 'Selesai',
                    ])
                    ->default('open')
                    ->required(),

                Textarea::make('content')
                    ->label('Isi Catatan')
                    ->required()
                    ->columnSpanFull(),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('item.snapshot_asset_number')
                    ->label('Kode Aset')
                    ->placeholder('-')
                    ->searchable(),

                TextColumn::make('type')
                    ->label('Jenis')
                    ->badge(),

                TextColumn::make('priority')
                    ->label('Prioritas')
                    ->badge(),

                TextColumn::make('status')
                    ->label('Status')
                    ->badge(),

                TextColumn::make('due_date')
                    ->label('Batas')
                    ->date(),

                TextColumn::make('creator.name')
                    ->label('Dibuat Oleh')
                    ->placeholder('System'),

                TextColumn::make('content')
                    ->label('Catatan')
                    ->limit(80)
                    ->wrap(),

                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()
                    ->label('Tambah Catatan')
                    ->mutateFormDataUsing(function (array $data): array {
                        $data['created_by'] = auth()->id();
                        $data['company_id'] = auth()->user()?->company_id;

                        return $data;
                    }),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
