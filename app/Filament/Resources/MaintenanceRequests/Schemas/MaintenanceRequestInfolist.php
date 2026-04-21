<?php

namespace App\Filament\Resources\MaintenanceRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class MaintenanceRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Request')
                    ->schema([
                        TextEntry::make('ticket_number')->label('Nomor Tiket'),
                        TextEntry::make('title')->label('Judul'),
                        TextEntry::make('requester.name')->label('Diajukan Oleh')->placeholder('-'),
                        TextEntry::make('employee.name')->label('Diajukan Untuk')->placeholder('-'),
                        TextEntry::make('asset.name')->label('Aset')->placeholder('-'),
                        TextEntry::make('priority')
                            ->label('Prioritas')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'low' => 'Low',
                                'medium' => 'Medium',
                                'high' => 'High',
                                'urgent' => 'Urgent',
                                default => $state,
                            }),
                        TextEntry::make('status')
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
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Alur Proses')
                    ->schema([
                        TextEntry::make('manager.name')->label('Manager')->placeholder('-'),
                        TextEntry::make('technician.name')->label('Technician')->placeholder('-'),
                        TextEntry::make('submitted_at')->label('Waktu Submit')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('assigned_at')->label('Waktu Assign')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('started_at')->label('Waktu Mulai')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('completed_at')->label('Waktu Selesai')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('manager_signed_at')->label('Tanda Tangan Manager')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('employee_signed_at')->label('Tanda Tangan Karyawan')->dateTime('d M Y H:i')->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Catatan')
                    ->schema([
                        TextEntry::make('manager_note')
                            ->label('Catatan Manager')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('technician_note')
                            ->label('Catatan Technician')
                            ->placeholder('-')
                            ->columnSpanFull(),
                        TextEntry::make('completion_note')
                            ->label('Catatan Penyelesaian')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ]),

                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}