<?php

namespace App\Filament\Resources\ProcurementRequests\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ProcurementRequestInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Request Pengadaan')
                    ->schema([
                        TextEntry::make('request_number')->label('Nomor Request'),
                        TextEntry::make('item_name')->label('Nama Barang'),
                        TextEntry::make('requester.name')->label('Diajukan Oleh')->placeholder('-'),
                        TextEntry::make('employee.name')->label('Diajukan Untuk')->placeholder('-'),
                        TextEntry::make('category')->label('Kategori')->placeholder('-'),
                        TextEntry::make('quantity')->label('Jumlah'),
                        TextEntry::make('unit')->label('Satuan'),
                        TextEntry::make('estimated_price')
                            ->label('Estimasi Harga')
                            ->money('IDR', locale: 'id')
                            ->placeholder('-'),
                        TextEntry::make('approved_price')
                            ->label('Harga Disetujui')
                            ->money('IDR', locale: 'id')
                            ->placeholder('-'),
                        TextEntry::make('status')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (string $state): string => match ($state) {
                                'submitted_by_manager' => 'Submitted by Manager',
                                'assigned_to_finance' => 'Assigned to Finance',
                                'in_review' => 'In Review',
                                'approved_by_finance' => 'Approved by Finance',
                                'rejected_by_finance' => 'Rejected by Finance',
                                'completed_by_finance' => 'Completed by Finance',
                                'signed_by_manager' => 'Signed by Manager',
                                'received_by_employee' => 'Received by Employee',
                                'cancelled' => 'Cancelled',
                                default => $state,
                            }),
                        TextEntry::make('purpose')
                            ->label('Tujuan/Kebutuhan')
                            ->columnSpanFull(),
                        TextEntry::make('specification')
                            ->label('Spesifikasi')
                            ->placeholder('-')
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make('Alur Proses')
                    ->schema([
                        TextEntry::make('manager.name')->label('Manager')->placeholder('-'),
                        TextEntry::make('finance.name')->label('Finance')->placeholder('-'),
                        TextEntry::make('submitted_at')->label('Waktu Submit')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('finance_assigned_at')->label('Waktu Assign Finance')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('finance_reviewed_at')->label('Waktu Review Finance')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('completed_at')->label('Waktu Selesai')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('manager_signed_at')->label('Tanda Tangan Manager')->dateTime('d M Y H:i')->placeholder('-'),
                        TextEntry::make('employee_signed_at')->label('Tanda Tangan Karyawan')->dateTime('d M Y H:i')->placeholder('-'),
                    ])
                    ->columns(2),

                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('created_at')->label('Dibuat')->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')->label('Diperbarui')->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}