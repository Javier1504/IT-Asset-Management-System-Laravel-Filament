<?php

use App\Http\Controllers\StockOpnameExportController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/admin');
Route::redirect('/login', '/admin/login')->name('login');

Route::middleware(['auth'])
    ->prefix('admin')
    ->name('filament.assetflow.')
    ->group(function (): void {
        Route::get('/stock-opnames/{stockOpname}/export-csv', StockOpnameExportController::class)
            ->name('stock-opname.export');
    });
