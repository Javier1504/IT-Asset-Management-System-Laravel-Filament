<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        if (! Schema::hasColumn('asset_requests', 'ticket_code')) {
            Schema::table('asset_requests', function (Blueprint $table): void {
                $table->string('ticket_code')->nullable()->unique()->after('id');
            });
        }

        DB::table('asset_requests')
            ->whereNull('ticket_code')
            ->orderBy('id')
            ->get(['id', 'created_at'])
            ->each(function ($row): void {
                $date = $row->created_at ? \Carbon\Carbon::parse($row->created_at)->format('Ymd') : now()->format('Ymd');
                DB::table('asset_requests')
                    ->where('id', $row->id)
                    ->update(['ticket_code' => 'TKT-' . $date . '-' . str_pad((string) $row->id, 4, '0', STR_PAD_LEFT)]);
            });
    }

    public function down(): void
    {
        if (Schema::hasColumn('asset_requests', 'ticket_code')) {
            Schema::table('asset_requests', function (Blueprint $table): void {
                $table->dropColumn('ticket_code');
            });
        }
    }
};
