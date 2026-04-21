<?php

namespace App\Filament\Resources\Users\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Profil User')
                    ->schema([
                        TextEntry::make('name')->label('Nama Lengkap'),
                        TextEntry::make('email')->label('Email'),
                        TextEntry::make('employee_id')->label('NIK / Employee ID')->placeholder('-'),
                        TextEntry::make('phone')->label('No. HP')->placeholder('-'),
                        TextEntry::make('department')->label('Departemen')->placeholder('-'),
                        TextEntry::make('position')->label('Jabatan')->placeholder('-'),
                        TextEntry::make('roles.name')
                            ->label('Role')
                            ->badge()
                            ->separator(', '),
                        IconEntry::make('is_active')
                            ->label('User Aktif')
                            ->boolean(),
                    ])
                    ->columns(2),

                Section::make('Metadata')
                    ->schema([
                        TextEntry::make('created_at')
                            ->label('Dibuat')
                            ->dateTime('d M Y H:i'),
                        TextEntry::make('updated_at')
                            ->label('Diperbarui')
                            ->dateTime('d M Y H:i'),
                    ])
                    ->columns(2),
            ]);
    }
}