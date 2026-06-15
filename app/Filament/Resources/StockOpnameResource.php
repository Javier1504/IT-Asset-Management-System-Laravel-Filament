<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StockOpnameResource\Pages;
use App\Models\StockOpname;
use App\Models\User;
use App\Services\StockOpname\StockOpnameService;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\HtmlString;

class StockOpnameResource extends Resource
{
    protected static ?string $model = StockOpname::class;
    protected static ?string $navigationGroup = 'Stock Opname';
    protected static ?string $navigationLabel = 'Stock Opname';
    protected static ?string $modelLabel = 'Stock Opname';
    protected static ?string $pluralModelLabel = 'Stock Opname';
    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Informasi Stock Opname')
                    ->description('Satu pilihan cakupan menentukan target pemeriksaan. Tim/personel/aset akan digenerate otomatis setelah data disimpan.')
                    ->schema([
                        Grid::make(2)->schema([
                            Placeholder::make('code_preview')
                                ->label('Kode Stock Opname')
                                ->content(fn (?StockOpname $record) => $record?->code ?: 'Otomatis dibuat setelah disimpan'),

                            TextInput::make('title')
                                ->label('Judul')
                                ->required()
                                ->maxLength(255),

                            Select::make('scope_type')
                                ->label('Cakupan Pemeriksaan')
                                ->options([
                                    'multi_team' => 'Multi Tim',
                                    'single_team' => 'Single Tim',
                                    'personnel' => 'Personel Tertentu',
                                    'office_asset' => 'Aset Kantor',
                                ])
                                ->default('single_team')
                                ->required()
                                ->live()
                                ->helperText('Pilih satu cakupan saja. Field target di bawah akan menyesuaikan.'),

                            Select::make('status')
                                ->label('Status')
                                ->options([
                                    'draft' => 'Draft',
                                    'in_progress' => 'Berjalan',
                                    'need_follow_up' => 'Perlu Tindak Lanjut',
                                    'completed' => 'Selesai',
                                    'cancelled' => 'Dibatalkan',
                                ])
                                ->default('draft')
                                ->required(),

                            DatePicker::make('start_date')
                                ->label('Tanggal Mulai')
                                ->native(false),

                            DatePicker::make('end_date')
                                ->label('Tanggal Selesai')
                                ->native(false),

                            Select::make('checked_by')
                                ->label('Petugas/Penanggung Jawab Pemeriksaan')
                                ->relationship('checker', 'name')
                                ->searchable()
                                ->preload()
                                ->default(fn () => auth()->id())
                                ->required(),
                        ]),

                        Textarea::make('notes')
                            ->label('Catatan')
                            ->columnSpanFull(),
                    ]),

                Section::make('Target Pemeriksaan')
                    ->description('Target ini hanya dipakai saat membuat sesi. Setelah sesi dibuat, anggota dan item akan muncul di halaman detail stock opname.')
                    ->schema([
                        Select::make('target_team_ids')
                            ->label('Pilih Banyak Tim')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(fn () => User::query()
                                ->whereNotNull('team')
                                ->where('team', '!=', '')
                                ->where('status', 'active')
                                ->distinct()
                                ->orderBy('team')
                                ->pluck('team', 'team')
                                ->all())
                            ->visible(fn (Get $get) => $get('scope_type') === 'multi_team')
                            ->required(fn (Get $get) => $get('scope_type') === 'multi_team')
                            ->live()
                            ->helperText('Bisa memilih lebih dari satu tim. Semua anggota aktif dari tim terpilih akan menjadi target pemeriksaan.'),

                        Select::make('target_team_id')
                            ->label('Pilih Satu Tim')
                            ->searchable()
                            ->preload()
                            ->options(fn () => User::query()
                                ->whereNotNull('team')
                                ->where('team', '!=', '')
                                ->where('status', 'active')
                                ->distinct()
                                ->orderBy('team')
                                ->pluck('team', 'team')
                                ->all())
                            ->visible(fn (Get $get) => $get('scope_type') === 'single_team')
                            ->required(fn (Get $get) => $get('scope_type') === 'single_team')
                            ->live()
                            ->helperText('Hanya satu tim yang bisa dipilih.'),

                        Select::make('target_user_ids')
                            ->label('Pilih Personel')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->options(fn () => User::query()
                                ->where('status', 'active')
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->visible(fn (Get $get) => $get('scope_type') === 'personnel')
                            ->required(fn (Get $get) => $get('scope_type') === 'personnel')
                            ->live()
                            ->helperText('Pilih personel tertentu yang asetnya akan diperiksa.'),

                        Placeholder::make('target_preview')
                            ->label('Preview Target')
                            ->content(function (Get $get) {
                                $scope = $get('scope_type');

                                if ($scope === 'office_asset') {
                                    return new HtmlString('<div class="text-sm text-gray-500">Sesi ini akan mengambil aset kantor.</div>');
                                }

                                $teams = [];
                                if ($scope === 'multi_team') {
                                    $teams = array_filter((array) $get('target_team_ids'));
                                } elseif ($scope === 'single_team') {
                                    $teams = array_filter([(string) $get('target_team_id')]);
                                }

                                if (! empty($teams)) {
                                    $html = collect($teams)->map(function ($team) {
                                        $members = User::query()
                                            ->where('status', 'active')
                                            ->where('team', $team)
                                            ->orderBy('name')
                                            ->pluck('name')
                                            ->all();

                                        $memberList = empty($members)
                                            ? '<span class="text-gray-500">Belum ada anggota aktif.</span>'
                                            : '<span class="text-gray-600">'.e(implode(', ', $members)).'</span>';

                                        return '<div class="rounded-xl border border-gray-200 dark:border-gray-700 p-3 mb-2">'
                                            .'<div class="font-semibold">'.e($team).' <span class="text-xs text-gray-500">('.count($members).' personel)</span></div>'
                                            .'<div class="mt-1 text-sm">'.$memberList.'</div>'
                                            .'</div>';
                                    })->implode('');

                                    return new HtmlString($html);
                                }

                                if ($scope === 'personnel') {
                                    $userIds = array_filter((array) $get('target_user_ids'));
                                    if (empty($userIds)) {
                                        return new HtmlString('<div class="text-sm text-gray-500">Belum ada personel dipilih.</div>');
                                    }

                                    $users = User::query()
                                        ->whereIn('id', $userIds)
                                        ->orderBy('team')
                                        ->orderBy('name')
                                        ->get(['name', 'team']);

                                    $html = $users->map(fn ($user) =>
                                        '<div class="rounded-xl border border-gray-200 dark:border-gray-700 p-3 mb-2">'
                                        .'<div class="font-semibold">'.e($user->name).'</div>'
                                        .'<div class="text-xs text-gray-500">'.e($user->team ?: 'Tanpa Tim').'</div>'
                                        .'</div>'
                                    )->implode('');

                                    return new HtmlString($html);
                                }

                                return new HtmlString('<div class="text-sm text-gray-500">Pilih target untuk melihat preview.</div>');
                            })
                            ->columnSpanFull(),

                        Hidden::make('type')->default('stock_opname')->dehydrated(true),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->recordUrl(fn (StockOpname $record) => static::getUrl('view', ['record' => $record]))
            ->columns([
                TextColumn::make('code')->label('Kode')->searchable()->sortable(),
                TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                TextColumn::make('scope_type')->label('Cakupan')->badge()->formatStateUsing(fn (?string $state) => match ($state) {
                    'multi_team' => 'Multi Tim',
                    'single_team' => 'Single Tim',
                    'personnel' => 'Personel',
                    'office_asset' => 'Aset Kantor',
                    default => $state ?: '-',
                }),
                TextColumn::make('status')->label('Status')->badge()->formatStateUsing(fn (?string $state) => match ($state) {
                    'draft' => 'Draft',
                    'in_progress' => 'Berjalan',
                    'need_follow_up' => 'Perlu Tindak Lanjut',
                    'completed' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                    default => $state ?: '-',
                })->color(fn (?string $state) => match ($state) {
                    'completed' => 'success',
                    'need_follow_up' => 'warning',
                    'cancelled' => 'danger',
                    'in_progress' => 'info',
                    default => 'gray',
                }),
                TextColumn::make('teams_count')->counts('teams')->label('Tim')->sortable(),
                TextColumn::make('users_count')->counts('users')->label('Personel')->sortable(),
                TextColumn::make('items_count')->counts('items')->label('Item')->sortable(),
                TextColumn::make('start_date')->label('Mulai')->date()->sortable(),
                TextColumn::make('end_date')->label('Selesai')->date()->sortable(),
                TextColumn::make('checker.name')->label('PIC')->toggleable(),
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Action::make('regenerate')
                    ->label('Generate Ulang Item')
                    ->icon('heroicon-o-arrow-path')
                    ->requiresConfirmation()
                    ->visible(fn (StockOpname $record) => $record->status !== 'completed')
                    ->action(function (StockOpname $record) {
                        $count = app(StockOpnameService::class)->generateItems($record);
                        app(StockOpnameService::class)->recalculateSummary($record);
                        Notification::make()->title("Item pemeriksaan digenerate: {$count}")->success()->send();
                    }),
                Action::make('complete')
                    ->label('Selesaikan')
                    ->icon('heroicon-o-check-circle')
                    ->color('success')
                    ->requiresConfirmation()
                    ->visible(fn (StockOpname $record) => $record->status !== 'completed')
                    ->action(function (StockOpname $record) {
                        $service = app(StockOpnameService::class);

                        if (! $service->canComplete($record)) {
                            $service->markNeedFollowUpIfNeeded($record);
                            Notification::make()
                                ->title('Stock opname belum bisa diselesaikan')
                                ->body('Masih ada item belum dicek atau butuh tindak lanjut.')
                                ->warning()
                                ->send();

                            return;
                        }

                        $service->complete($record);
                        Notification::make()->title('Stock opname selesai')->success()->send();
                    }),
                Action::make('export_csv')
                    ->label('Export')
                    ->icon('heroicon-o-arrow-down-tray')
                    ->url(fn (StockOpname $record) => route('filament.assetflow.stock-opname.export', $record))
                    ->openUrlInNewTab(),
                Tables\Actions\EditAction::make()->label('Edit Info'),
            ])
            ->bulkActions([]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListStockOpnames::route('/'),
            'create' => Pages\CreateStockOpname::route('/create'),
            'view' => Pages\ViewStockOpname::route('/{record}'),
            'edit' => Pages\EditStockOpname::route('/{record}/edit'),
        ];
    }
}
