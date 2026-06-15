<?php
namespace App\Filament\Resources\PhysicalHostAssetResource\Pages;

use App\Filament\Resources\PhysicalHostAssetResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPhysicalHostAsset extends ListRecords
{
    protected static string $resource = PhysicalHostAssetResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
