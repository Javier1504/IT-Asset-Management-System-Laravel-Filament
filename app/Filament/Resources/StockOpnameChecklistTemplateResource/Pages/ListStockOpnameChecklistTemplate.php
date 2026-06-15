<?php
namespace App\Filament\Resources\StockOpnameChecklistTemplateResource\Pages;

use App\Filament\Resources\StockOpnameChecklistTemplateResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListStockOpnameChecklistTemplate extends ListRecords
{
    protected static string $resource = StockOpnameChecklistTemplateResource::class;
    protected function getHeaderActions(): array { return [Actions\CreateAction::make()]; }
}
