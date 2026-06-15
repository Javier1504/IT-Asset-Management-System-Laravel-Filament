<?php
namespace App\Http\Controllers;

use App\Models\StockOpname;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StockOpnameExportController extends Controller
{
    public function __invoke(StockOpname $stockOpname): StreamedResponse
    {
        $fileName = $stockOpname->code.'_items.csv';
        return response()->streamDownload(function () use ($stockOpname) {
            $out = fopen('php://output', 'w');
            fputcsv($out, ['asset_number','asset_name','source','owner_or_location','status','condition','need_follow_up','notes']);
            $stockOpname->items()->chunk(200, function ($items) use ($out) {
                foreach ($items as $item) {
                    fputcsv($out, [$item->snapshot_asset_number, $item->snapshot_asset_name, $item->asset_source, $item->snapshot_user_name ?: $item->snapshot_location_name, $item->result_status, $item->physical_condition, $item->need_follow_up ? 'yes' : 'no', $item->notes]);
                }
            });
            fclose($out);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }
}
