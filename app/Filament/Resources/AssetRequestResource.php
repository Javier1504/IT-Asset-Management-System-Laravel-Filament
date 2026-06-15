<?php

namespace App\Filament\Resources;

use App\Filament\Concerns\HasRoleBasedResourceAccess;
use App\Filament\Resources\AssetRequestResource\Pages;
use App\Models\AssetRequest;
use App\Support\RoleAccess;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class AssetRequestResource extends Resource
{
    use HasRoleBasedResourceAccess;

    protected static ?string $model = AssetRequest::class;
    protected static ?string $navigationGroup = 'Operasional Aset';
    protected static ?string $navigationLabel = 'Pengajuan Aset';
    protected static ?string $modelLabel = 'Pengajuan Aset';
    protected static ?string $pluralModelLabel = 'Pengajuan Aset';
    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?int $navigationSort = 1;

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery()->with(['requester', 'targetUser', 'assetType', 'asset']);
        $user = auth()->user();

        if (! $user || $user->isAdmin()) {
            return $query;
        }

        if ($user->role === 'manager') {
            return $query->where(function (Builder $builder) use ($user): void {
                $builder
                    ->whereHas('requester', fn (Builder $q) => $q->where('team', $user->team))
                    ->orWhereHas('targetUser', fn (Builder $q) => $q->where('team', $user->team))
                    ->orWhere('requested_by', $user->id)
                    ->orWhere('target_user_id', $user->id);
            });
        }

        return $query->where(function (Builder $builder) use ($user): void {
            $builder->where('requested_by', $user->id)->orWhere('target_user_id', $user->id);
        });
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Placeholder::make('ticket_code_display')
                ->label('Kode Tiket')
                ->content(fn (?AssetRequest $record): string => $record?->ticket_code ?: 'Otomatis dibuat setelah disimpan'),

            Select::make('company_id')
                ->relationship('company', 'name')
                ->searchable()
                ->preload()
                ->visible(fn (): bool => RoleAccess::isAdmin()),

            Select::make('requested_by')
                ->label('Pemohon')
                ->relationship('requester', 'name')
                ->default(fn () => auth()->id())
                ->disabled(fn (): bool => ! RoleAccess::isManager())
                ->dehydrated()
                ->required()
                ->searchable()
                ->preload(),

            Select::make('target_user_id')
                ->label('Pengguna Tujuan')
                ->relationship('targetUser', 'name')
                ->default(fn () => auth()->id())
                ->disabled(fn (): bool => ! RoleAccess::isManager())
                ->dehydrated()
                ->searchable()
                ->preload(),

            Select::make('request_type')
                ->label('Jenis Pengajuan')
                ->options([
                    'new' => 'Aset Baru',
                    'change' => 'Penggantian Aset',
                    'repair' => 'Perbaikan',
                    'return' => 'Pengembalian',
                ])
                ->required(),

            TextInput::make('title')
                ->label('Judul Pengajuan')
                ->maxLength(255)
                ->required(),

            DateTimePicker::make('requested_at')
                ->label('Tanggal Pengajuan')
                ->default(now())
                ->seconds(false),

            Select::make('asset_type_id')
                ->label('Jenis Aset')
                ->relationship('assetType', 'name')
                ->searchable()
                ->preload(),

            Select::make('asset_id')
                ->label('Aset Terkait')
                ->relationship('asset', 'asset_number')
                ->getOptionLabelFromRecordUsing(fn ($record): string => $record->asset_number . ' - ' . $record->name)
                ->searchable()
                ->preload(),

            TextInput::make('desired_asset')
                ->label('Aset yang Dibutuhkan')
                ->maxLength(255),

            Select::make('status')
                ->label('Status')
                ->options([
                    'pending' => 'Menunggu Approval',
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'on_progress' => 'Diproses',
                    'done' => 'Selesai',
                    'cancelled' => 'Dibatalkan',
                ])
                ->default('pending')
                ->disabled(fn (): bool => ! RoleAccess::isManager())
                ->dehydrated()
                ->required(),

            Textarea::make('reason')
                ->label('Alasan / Kebutuhan')
                ->required()
                ->columnSpanFull(),

            Textarea::make('admin_notes')
                ->label('Catatan Admin / Manager')
                ->visible(fn (): bool => RoleAccess::isManager())
                ->columnSpanFull(),
        ])->columns(2);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('ticket_code')->label('Kode Tiket')->searchable()->sortable()->badge(),
                TextColumn::make('title')->label('Judul')->searchable()->sortable()->wrap(),
                TextColumn::make('requester.name')->label('Pemohon')->searchable()->sortable(),
                TextColumn::make('targetUser.name')->label('Pengguna')->searchable()->sortable(),
                TextColumn::make('request_type')->label('Jenis')->badge()->sortable(),
                TextColumn::make('status')->label('Status')->badge()->sortable(),
                TextColumn::make('requested_at')->label('Tanggal')->dateTime('d M Y H:i')->sortable(),
            ])
            ->filters([])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()->visible(fn (): bool => RoleAccess::isAdmin()),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function canCreate(): bool
    {
        return auth()->check();
    }

    public static function canEdit(Model $record): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        if ($user->isManager()) {
            return true;
        }

        return $record instanceof AssetRequest
            && $record->requested_by === $user->id
            && in_array($record->status, ['pending', 'cancelled'], true);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAssetRequest::route('/'),
            'create' => Pages\CreateAssetRequest::route('/create'),
            'edit' => Pages\EditAssetRequest::route('/{record}/edit'),
        ];
    }
}
