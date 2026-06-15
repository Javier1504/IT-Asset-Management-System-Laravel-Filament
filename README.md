# Sistem Manajemen Aset - ITAM General Filament

Project ini adalah **versi general dari IT Asset Management**: fitur, modul, dan alur kerja mengikuti konsep ITAM yang Anda berikan, tetapi seluruh istilah/branding organisasi tertentu sudah digeneralisasi. UI utama memakai **Laravel Filament Panel** di `/admin`.

## Modul utama

- Dashboard ringkasan aset, request, maintenance, lisensi, dan stock opname.
- Master data: perusahaan, pengguna/pegawai, unit/tim, sub-tim khusus, lokasi, jenis aset, jenis sparepart.
- Inventaris aset: aset utama, aset pengguna, aset kantor, host fisik/server, network asset, security peripheral.
- Lifecycle aset: pengajuan aset, instalasi/deployment, perbaikan, pemusnahan/retirement.
- Pengadaan: vendor, permintaan penawaran, penawaran vendor.
- Sparepart: stok sparepart dan movement masuk/keluar.
- Software license: lisensi, masa aktif, PIC, pengingat expiry.
- Stock opname: sesi multi-tim, multi-personel, office asset, generate item, checklist, status pengecekan, follow-up, summary, complete, export CSV.
- Governance: catatan internal, knowledge base, audit trail.

## Stack

- PHP 8.2+
- Laravel 11
- Filament 3.3
- PostgreSQL / MySQL / SQLite

## Instalasi PostgreSQL pgAdmin

1. Extract zip ke folder pendek, contoh:

```powershell
D:\Kehidupan\Mitral\asset_management_filament
```

2. Masuk folder project:

```powershell
cd D:\Kehidupan\Mitral\asset_management_filament
```

3. Install dependency:

```powershell
composer install
```

4. Buat file `.env`:

```powershell
copy .env.example .env
```

5. Edit `.env` sesuai PostgreSQL Anda:

```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5433
DB_DATABASE=Asset_Management
DB_USERNAME=postgres
DB_PASSWORD=password_postgres_anda
```

Kalau PostgreSQL Anda memakai port 5432, ubah `DB_PORT=5432`.

6. Generate key:

```powershell
php artisan key:generate
```

7. Clear cache dan migrate fresh:

```powershell
php artisan optimize:clear
php artisan migrate:fresh --seed
```

8. Publish asset Filament:

```powershell
php artisan filament:assets
```

9. Jalankan server:

```powershell
php artisan serve
```

Buka:

```text
http://127.0.0.1:8000/admin
```

Akun demo:

```text
Email    : admin@assetflow.local
Password : password
```

## Mapping istilah general

| Konsep lama | Versi general |
|---|---|
| Sistem internal organisasi | Sistem Manajemen Aset |
| Karyawan | Pegawai/Pengguna |
| Job Family | Unit/Divisi |
| Team | Tim |
| Tim khusus internal | Sub-Tim Khusus / Matrix Sub-Team |
| Admin IT | Admin Aset |
| Manager | Manager Unit |
| Aset pribadi/end user | Aset Pengguna |
| Office item | Aset Kantor |
| Asset request | Pengajuan Aset |
| Maintenance | Perbaikan Aset |
| Disposal | Pemusnahan Aset |
| Vendor offer | Penawaran Vendor |
| Stock opname | Stock Opname Aset |

## Catatan penting

- Jangan menjalankan project langsung dari dalam ZIP. Extract dulu.
- Folder `vendor` tidak disertakan. Jalankan `composer install`.
- Setelah `php artisan filament:assets`, refresh browser dengan `CTRL + F5`.
- Jika ingin reset database, jalankan `php artisan migrate:fresh --seed`.
