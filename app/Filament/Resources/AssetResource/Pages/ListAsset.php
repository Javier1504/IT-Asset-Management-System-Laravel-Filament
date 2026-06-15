<?php
namespace App\Filament\Resources\AssetResource\Pages;

use App\Filament\Resources\AssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListAsset extends ListRecords
{
    protected static string $resource = AssetResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
