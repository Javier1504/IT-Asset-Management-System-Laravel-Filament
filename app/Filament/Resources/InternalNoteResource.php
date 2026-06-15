<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InternalNoteResource\Pages;
use App\Models\InternalNote;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class InternalNoteResource extends Resource
{
    protected static ?string $model = InternalNote::class;
    protected static ?string $navigationGroup = 'Tata Kelola';
    protected static ?string $navigationLabel = 'Catatan Internal';
    protected static ?string $modelLabel = 'Catatan Internal';
    protected static ?string $pluralModelLabel = 'Catatan Internal';
    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Select::make('stock_opname_id')
                ->label('Terkait Stock Opname')
                ->relationship('stockOpname', 'code')
                ->searchable()
                ->preload()
                ->default(fn () => request()->query('stock_opname_id')),

            Select::make('stock_opname_item_id')
                ->label('Terkait Item Pemeriksaan')
                ->relationship('item', 'snapshot_asset_number')
                ->searchable()
                ->preload()
                ->default(fn () => request()->query('stock_opname_item_id')),

            Select::make('created_by')
                ->label('Dibuat Oleh')
                ->relationship('creator', 'name')
                ->searchable()
                ->preload()
                ->default(fn () => auth()->id()),

            Select::make('type')
                ->label('Tipe')
                ->options([
                    'note' => 'Catatan',
                    'follow_up' => 'Tindak Lanjut',
                    'risk' => 'Risiko',
                ])
                ->default('note')
                ->required(),

            Select::make('priority')
                ->label('Prioritas')
                ->options([
                    'low' => 'Rendah',
                    'normal' => 'Normal',
                    'high' => 'Tinggi',
                    'urgent' => 'Mendesak',
                ])
                ->default('normal')
                ->required(),

            DatePicker::make('due_date')
                ->label('Tenggat')
                ->native(false),

            Select::make('status')
                ->label('Status')
                ->options([
                    'open' => 'Open',
                    'in_progress' => 'In Progress',
                    'closed' => 'Closed',
                ])
                ->default('open')
                ->required(),

            Textarea::make('content')
                ->label('Isi Catatan')
                ->required()
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('type')->label('Tipe')->badge()->sortable(),
                TextColumn::make('priority')->label('Prioritas')->badge()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('stockOpname.code')->label('Stock Opname')->searchable()->sortable(),
                TextColumn::make('item.snapshot_asset_number')->label('Item Aset')->searchable()->toggleable(),
                TextColumn::make('creator.name')->label('Dibuat Oleh')->searchable()->sortable(),
                TextColumn::make('content')->label('Catatan')->limit(80)->searchable(),
                TextColumn::make('due_date')->label('Tenggat')->date()->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInternalNote::route('/'),
            'create' => Pages\CreateInternalNote::route('/create'),
            'edit' => Pages\EditInternalNote::route('/{record}/edit'),
        ];
    }
}
