<?php

namespace App\Filament\Resources\ProcurementRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class ProcurementRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('request_number')->label('Nomor Request')->searchable()->sortable(),
                TextColumn::make('item_name')->label('Nama Barang')->searchable()->sortable()->limit(35)->wrap(),
                TextColumn::make('requester.name')->label('Diajukan Oleh')->searchable()->sortable()->placeholder('-'),
                TextColumn::make('employee.name')->label('Diajukan Untuk')->searchable()->sortable()->placeholder('-'),
                TextColumn::make('finance.name')->label('Finance')->searchable()->sortable()->placeholder('-')->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'submitted_by_manager' => 'Submitted by Manager',
                        'assigned_to_finance' => 'Assigned to Finance',
                        'approved_by_finance' => 'Approved by Finance',
                        'rejected_by_finance' => 'Rejected by Finance',
                        'signed_by_manager' => 'Signed by Manager',
                        'received_by_employee' => 'Received by Employee',
                        'cancelled' => 'Cancelled',
                        default => $state,
                    }),
                TextColumn::make('submitted_at')->label('Diajukan')->dateTime('d M Y H:i')->sortable()->toggleable(),
                TextColumn::make('manager_signed_at')->label('TTD Manager')->dateTime('d M Y H:i')->sortable()->placeholder('-')->toggleable(),
                TextColumn::make('employee_signed_at')->label('TTD Karyawan')->dateTime('d M Y H:i')->sortable()->placeholder('-')->toggleable(),
            ])
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'submitted_by_manager' => 'Submitted by Manager',
                        'assigned_to_finance' => 'Assigned to Finance',
                        'approved_by_finance' => 'Approved by Finance',
                        'rejected_by_finance' => 'Rejected by Finance',
                        'signed_by_manager' => 'Signed by Manager',
                        'received_by_employee' => 'Received by Employee',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('approve_by_finance')
                    ->label('ACC')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()?->hasRole('finance')
                        && (int) $record->finance_id === (int) auth()->id()
                        && $record->status === 'assigned_to_finance')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'approved_by_finance',
                            'finance_reviewed_at' => now(),
                            'completed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pengadaan berhasil di-ACC finance.')
                            ->success()
                            ->send();
                    }),

                Action::make('reject_by_finance')
                    ->label('Tolak')
                    ->color('danger')
                    ->form([
                        Textarea::make('finance_note')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->visible(fn ($record) => auth()->user()?->hasRole('finance')
                        && (int) $record->finance_id === (int) auth()->id()
                        && $record->status === 'assigned_to_finance')
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'rejected_by_finance',
                            'finance_note' => $data['finance_note'],
                            'finance_reviewed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Pengadaan ditolak finance.')
                            ->success()
                            ->send();
                    }),

                Action::make('sign_by_manager')
                    ->label('Tanda Tangani')
                    ->color('primary')
                    ->visible(fn ($record) => auth()->user()?->hasRole('manager')
                        && (int) $record->manager_id === (int) auth()->id()
                        && $record->status === 'approved_by_finance')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'signed_by_manager',
                            'manager_signed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Manager telah menandatangani request pengadaan.')
                            ->success()
                            ->send();
                    }),

                Action::make('sign_by_employee')
                    ->label('Tanda Tangani Penerimaan')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()?->hasRole('user')
                        && (int) $record->employee_id === (int) auth()->id()
                        && $record->status === 'signed_by_manager')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'received_by_employee',
                            'employee_signed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Karyawan telah menandatangani penerimaan pengadaan.')
                            ->success()
                            ->send();
                    }),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->visible(fn (): bool => auth()->user()?->hasAnyRole(['superadmin', 'admin']) ?? false),
                ]),
            ]);
    }
}