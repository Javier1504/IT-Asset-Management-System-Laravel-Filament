# Jalankan dari root project: D:\Kehidupan\Mitral\assetflow_filament
# Script ini menghapus sisa konsep lama yang keliru: frontend /app terpisah dan Knowledge Base.

$paths = @(
    "app\Http\Controllers\AppDashboardController.php",
    "app\Http\Controllers\AppAssetController.php",
    "app\Http\Controllers\AppAssetRequestController.php",
    "app\Http\Controllers\AppStockOpnameController.php",
    "resources\views\app",
    "resources\views\knowledge-base",
    "resources\views\components\chatbot-widget.blade.php"
)

foreach ($path in $paths) {
    if (Test-Path $path) {
        Remove-Item -Recurse -Force $path
        Write-Host "Removed: $path"
    }
}

Write-Host "Cleanup selesai. Jalankan: composer dump-autoload; php artisan optimize:clear; php artisan migrate"
