<?php

namespace App\Filament\Resources\StockOpnameResource\RelationManagers;

use App\Models\InternalNote;
use App\Services\StockOpname\StockOpnameService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Item Pemeriksaan';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('asset_id')
                    ->label('Aset')
                    ->relationship('asset', 'asset_number')
                    ->searchable()
                    ->preload(),

                Select::make('user_id')
                    ->label('Pengguna')
                    ->relationship('user', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('location_id')
                    ->label('Lokasi')
                    ->relationship('location', 'name')
                    ->searchable()
                    ->preload(),

                Select::make('asset_source')
                    ->label('Sumber Aset')
                    ->options([
                        'end_user' => 'Aset Pengguna',
                        'office' => 'Aset Kantor',
                    ])
                    ->required(),

                Select::make('result_status')
                    ->label('Hasil Pemeriksaan')
                    ->options([
                        'pending' => 'Belum Dicek',
                        'matched' => 'Sesuai',
                        'mismatch' => 'Tidak Sesuai',
                        'not_found' => 'Tidak Ditemukan',
                    ])
                    ->required(),

                Select::make('physical_condition')
                    ->label('Kondisi Fisik')
                    ->options([
                        'good' => 'Baik',
                        'minor_issue' => 'Catatan Ringan',
                        'broken' => 'Rusak',
                        'lost' => 'Hilang',
                    ]),

                Toggle::make('user_match')
                    ->label('Pengguna Sesuai'),

                Toggle::make('need_follow_up')
                    ->label('Perlu Tindak Lanjut'),

                TextInput::make('issue_type')
                    ->label('Jenis Masalah'),

                DateTimePicker::make('scheduled_at')
                    ->label('Jadwal Tindak Lanjut'),

                TextInput::make('additional_budget')
                    ->label('Estimasi Biaya Tambahan')
                    ->numeric()
                    ->prefix('Rp'),

                Textarea::make('follow_up_summary')
                    ->label('Ringkasan Tindak Lanjut')
                    ->columnSpanFull(),

                Textarea::make('notes')
                    ->label('Catatan Pemeriksaan')
                    ->columnSpanFull(),

                DateTimePicker::make('checked_at')
                    ->label('Waktu Dicek'),
            ])
            ->columns(2);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('snapshot_asset_number')
                    ->label('Kode Aset')
                    ->searchable(),

                TextColumn::make('snapshot_asset_name')
                    ->label('Nama Aset')
                    ->searchable(),

                TextColumn::make('asset_source')
                    ->label('Sumber')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'end_user' => 'Aset Pengguna',
                        'office' => 'Aset Kantor',
                        default => $state ?: '-',
                    }),

                TextColumn::make('snapshot_user_name')
                    ->label('Pengguna')
                    ->searchable(),

                TextColumn::make('snapshot_location_name')
                    ->label('Lokasi')
                    ->searchable(),

                TextColumn::make('result_status')
                    ->label('Hasil')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'pending' => 'Belum Dicek',
                        'matched' => 'Sesuai',
                        'mismatch' => 'Tidak Sesuai',
                        'not_found' => 'Tidak Ditemukan',
                        default => $state ?: '-',
                    }),

                IconColumn::make('need_follow_up')
                    ->label('Tindak Lanjut')
                    ->boolean(),

                TextColumn::make('checked_at')
                    ->label('Dicek Pada')
                    ->dateTime('d M Y H:i'),
            ])
            ->headerActions([
                Action::make('recalculate_summary')
                    ->label('Hitung Ulang Summary')
                    ->action(function (): void {
                        app(StockOpnameService::class)->recalculateSummary($this->getOwnerRecord());

                        Notification::make()
                            ->title('Summary berhasil dihitung ulang')
                            ->success()
                            ->send();
                    }),
            ])
            ->actions([
                Action::make('create_follow_up_note')
                    ->label('Catatan Tindak Lanjut')
                    ->icon('heroicon-o-chat-bubble-left-ellipsis')
                    ->visible(fn ($record): bool => (bool) $record->need_follow_up)
                    ->form([
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

                        Textarea::make('content')
                            ->label('Catatan')
                            ->required(),
                    ])
                    ->action(function ($record, array $data): void {
                        InternalNote::query()->create([
                            'company_id' => auth()->user()?->company_id,
                            'stock_opname_id' => $this->getOwnerRecord()->id,
                            'stock_opname_item_id' => $record->id,
                            'created_by' => auth()->id(),
                            'type' => 'follow_up',
                            'priority' => $data['priority'],
                            'due_date' => $data['due_date'] ?? null,
                            'status' => 'open',
                            'content' => $data['content'],
                        ]);

                        Notification::make()
                            ->title('Catatan tindak lanjut berhasil dibuat')
                            ->success()
                            ->send();
                    }),

                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([]);
    }
}
