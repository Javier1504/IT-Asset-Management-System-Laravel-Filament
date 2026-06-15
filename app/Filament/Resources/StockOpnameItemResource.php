<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockOpnameItemResource\Pages;
use App\Models\StockOpnameItem;
use App\Services\StockOpname\StockOpnameService;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class StockOpnameItemResource extends Resource
{
    protected static ?string $model = StockOpnameItem::class;

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form->schema([
            Section::make('Informasi Aset')
                ->schema([
                    TextInput::make('snapshot_asset_number')->label('Nomor Aset')->readOnly(),
                    TextInput::make('snapshot_asset_name')->label('Nama Aset')->readOnly(),
                    TextInput::make('snapshot_asset_brand')->label('Brand')->readOnly(),
                    TextInput::make('snapshot_serial_number')->label('Serial Number')->readOnly(),
                    TextInput::make('snapshot_user_name')->label('Pemegang/Lokasi')->readOnly(),
                ])
                ->columns(2),

            Section::make('Hasil Pemeriksaan')
                ->schema([
                    Select::make('result_status')
                        ->label('Status Hasil')
                        ->options([
                            'pending' => 'Belum Dicek',
                            'sesuai' => 'Sesuai',
                            'tidak_sesuai' => 'Tidak Sesuai',
                            'perlu_tindak_lanjut' => 'Perlu Tindak Lanjut',
                            'tidak_ada' => 'Tidak Ditemukan',
                        ])
                        ->required()
                        ->live(),

                    Select::make('physical_condition')
                        ->label('Kondisi Fisik')
                        ->options([
                            'baik' => 'Baik',
                            'rusak_ringan' => 'Rusak Ringan',
                            'rusak_berat' => 'Rusak Berat',
                        ])
                        ->live(),

                    Toggle::make('user_match')
                        ->label('Pemegang/lokasi sesuai')
                        ->default(true),

                    Toggle::make('need_follow_up')
                        ->label('Perlu tindak lanjut')
                        ->helperText('Akan otomatis aktif jika status/kondisi/checklist bermasalah.'),

                    TextInput::make('issue_type')
                        ->label('Jenis Masalah')
                        ->maxLength(255),

                    DateTimePicker::make('scheduled_at')
                        ->label('Jadwal Tindak Lanjut')
                        ->native(false),

                    TextInput::make('additional_budget')
                        ->label('Estimasi Biaya')
                        ->numeric()
                        ->prefix('Rp'),

                    Textarea::make('follow_up_summary')
                        ->label('Catatan Tindak Lanjut')
                        ->helperText('Jika diisi dan item bermasalah, catatan ini otomatis masuk ke Catatan Internal.')
                        ->columnSpanFull(),

                    Textarea::make('notes')
                        ->label('Catatan Pemeriksaan')
                        ->columnSpanFull(),
                ])
                ->columns(2),

            Section::make('Checklist Aset')
                ->description('Checklist otomatis mengikuti jenis aset. Ubah status per item checklist.')
                ->schema([
                    Repeater::make('checklist_data')
                        ->label('Checklist')
                        ->schema([
                            TextInput::make('label')
                                ->label('Item Checklist')
                                ->readOnly()
                                ->required(),
                            Select::make('status')
                                ->label('Kondisi')
                                ->options([
                                    'baik' => 'Baik',
                                    'rusak_ringan' => 'Rusak Ringan',
                                    'rusak_berat' => 'Rusak Berat',
                                    'tidak_ada' => 'Tidak Ada',
                                    'tidak_sesuai' => 'Tidak Sesuai',
                                ])
                                ->default('baik')
                                ->required(),
                            Textarea::make('notes')
                                ->label('Catatan')
                                ->rows(2),
                        ])
                        ->columns(3)
                        ->defaultItems(0)
                        ->columnSpanFull(),
                ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table->columns([
            TextColumn::make('stockOpname.code')->label('SO'),
            TextColumn::make('snapshot_asset_number')->label('Nomor Aset')->searchable(),
            TextColumn::make('snapshot_asset_name')->label('Aset')->searchable(),
            TextColumn::make('snapshot_user_name')->label('Pemegang')->searchable(),
            TextColumn::make('result_status')->label('Status')->badge(),
            TextColumn::make('physical_condition')->label('Kondisi')->badge(),
        ])->actions([
            Tables\Actions\EditAction::make()->label('Opname'),
        ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockOpnameItems::route('/'),
            'edit' => Pages\EditStockOpnameItem::route('/{record}/edit'),
        ];
    }
}
