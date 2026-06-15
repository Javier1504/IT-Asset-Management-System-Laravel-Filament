# Patch Perbaikan Konsep: ITAM General Satu Panel Filament

Patch ini mengubah project dari konsep yang salah:

- `/` landing page
- `/app` frontend operasional terpisah
- `/admin` Filament admin

menjadi konsep yang diminta:

- **satu aplikasi ITAM general berbasis Laravel Filament**
- login lewat `/admin/login`
- masuk sebagai **Admin / Manager / User**
- menu dan aksi dikontrol berdasarkan role
- tidak ada frontend `/app` terpisah
- branding Sevima/Fusion dihilangkan, tetapi flow ITAM tetap dipertahankan

## Cara Pasang

1. Extract zip patch ini.
2. Copy seluruh isi folder patch ke root project:

   `D:\Kehidupan\Mitral\assetflow_filament`

3. Pilih **Replace / Overwrite** untuk file yang sama.
4. Jalankan script cleanup sekali:

```powershell
.\cleanup_wrong_frontend_and_knowledge.ps1
```

5. Jalankan command:

```powershell
composer dump-autoload
php artisan optimize:clear
php artisan view:clear
php artisan route:clear
php artisan migrate
php artisan filament:assets
php artisan serve
```

6. Buka:

```text
http://127.0.0.1:8000
```

Akan diarahkan ke:

```text
http://127.0.0.1:8000/admin
```

## Akun Demo

Jika menjalankan seeder:

```text
Admin   : admin@assetflow.local / password
Manager : manager@assetflow.local / password
User    : user@assetflow.local / password
```

## Catatan Penting

- Jangan lagi buka `/app`, karena route itu memang dihapus.
- Jangan copy patch frontend operasional lama lagi.
- Kode tiket `ticket_code` otomatis dibuat dengan format `TKT-YYYYMMDD-0001`.
- Kode stock opname otomatis dibuat dengan format `SO-YYYYMMDD-0001`.
- Field kode tiket dan kode stock opname dikunci dari backend, bukan cuma disabled di UI.
