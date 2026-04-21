<?php

namespace App\Filament\Resources\MaintenanceRequests\Tables;

use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class MaintenanceRequestsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->defaultSort('created_at', 'desc')
            ->columns([
                TextColumn::make('ticket_number')->label('Nomor Tiket')->searchable()->sortable(),
                TextColumn::make('title')->label('Judul')->searchable()->sortable()->limit(35)->wrap(),
                TextColumn::make('requester.name')->label('Diajukan Oleh')->searchable()->sortable()->placeholder('-'),
                TextColumn::make('employee.name')->label('Diajukan Untuk')->searchable()->sortable()->placeholder('-'),
                TextColumn::make('technician.name')->label('Technician')->searchable()->sortable()->placeholder('-')->toggleable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'submitted_by_manager' => 'Submitted by Manager',
                        'assigned_to_technician' => 'Assigned to Technician',
                        'in_progress' => 'In Progress',
                        'completed_by_technician' => 'Completed by Technician',
                        'signed_by_manager' => 'Signed by Manager',
                        'received_by_employee' => 'Received by Employee',
                        'rejected' => 'Rejected',
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
                        'assigned_to_technician' => 'Assigned to Technician',
                        'in_progress' => 'In Progress',
                        'completed_by_technician' => 'Completed by Technician',
                        'signed_by_manager' => 'Signed by Manager',
                        'received_by_employee' => 'Received by Employee',
                        'rejected' => 'Rejected',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),

                Action::make('approve_by_technician')
                    ->label('ACC')
                    ->color('success')
                    ->visible(fn ($record) => auth()->user()?->hasRole('technician')
                        && (int) $record->technician_id === (int) auth()->id()
                        && in_array($record->status, ['assigned_to_technician', 'in_progress']))
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'completed_by_technician',
                            'completed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Maintenance berhasil di-ACC technician.')
                            ->success()
                            ->send();
                    }),

                Action::make('reject_by_technician')
                    ->label('Tolak')
                    ->color('danger')
                    ->form([
                        Textarea::make('technician_note')
                            ->label('Alasan Penolakan')
                            ->required(),
                    ])
                    ->visible(fn ($record) => auth()->user()?->hasRole('technician')
                        && (int) $record->technician_id === (int) auth()->id()
                        && in_array($record->status, ['assigned_to_technician', 'in_progress']))
                    ->action(function ($record, array $data) {
                        $record->update([
                            'status' => 'rejected',
                            'technician_note' => $data['technician_note'],
                        ]);

                        Notification::make()
                            ->title('Maintenance ditolak technician.')
                            ->success()
                            ->send();
                    }),

                Action::make('sign_by_manager')
                    ->label('Tanda Tangani')
                    ->color('primary')
                    ->visible(fn ($record) => auth()->user()?->hasRole('manager')
                        && (int) $record->manager_id === (int) auth()->id()
                        && $record->status === 'completed_by_technician')
                    ->action(function ($record) {
                        $record->update([
                            'status' => 'signed_by_manager',
                            'manager_signed_at' => now(),
                        ]);

                        Notification::make()
                            ->title('Manager telah menandatangani request maintenance.')
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
                            ->title('Karyawan telah menandatangani penerimaan maintenance.')
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