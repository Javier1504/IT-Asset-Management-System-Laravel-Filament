# Penjelasan Frontend dan Backend

## Frontend Pakai Apa?

Frontend aplikasi ini memakai:

- **Laravel Filament 3**
- **Livewire 3**
- **Blade**
- **Tailwind CSS bawaan Filament**

Jadi tidak ada React, Vue, atau frontend `/app` terpisah.

Semua tampilan aplikasi berada dalam panel Filament:

```text
/admin
```

Filament berperan sebagai UI utama aplikasi ITAM, bukan hanya CRUD admin biasa.

## Backend Pakai Apa?

Backend memakai:

- **Laravel 11**
- **Eloquent ORM**
- **PostgreSQL**
- **Migration + Seeder**
- **Model + Service**
- **Role-based access**

Database tetap PostgreSQL yang dibuka melalui pgAdmin.

## Alur Login

Semua role login dari halaman yang sama:

```text
/admin/login
```

Setelah login, menu sidebar akan berbeda sesuai role.

## Role dan Hak Akses

### Admin / Super Admin

Dapat mengakses semua fitur:

- Master Data
- Pengguna
- Inventaris Aset
- Pengajuan Aset
- Perbaikan
- Instalasi
- Pemusnahan
- Stock Opname
- Pengadaan
- Vendor
- Sparepart
- Lisensi Software
- Audit Trail

### Manager

Dapat mengakses fitur operasional:

- Monitoring aset
- Pengajuan aset dari tim
- Approval / update status pengajuan
- Perbaikan
- Instalasi
- Pemusnahan
- Stock Opname
- Catatan internal
- Melihat pengguna dalam tim

### User / Employee

Dapat mengakses fitur personal:

- Melihat aset yang digunakan
- Membuat pengajuan aset
- Melihat status pengajuan
- Melihat stock opname yang ditugaskan

## Kenapa tidak ada `/app` lagi?

Karena kebutuhan sebenarnya adalah meniru ITAM sebagai satu aplikasi internal.
Jadi sistem tidak boleh terpecah menjadi frontend operasional dan admin Filament.
Semua dibuat dalam satu panel Filament dengan role berbeda.
