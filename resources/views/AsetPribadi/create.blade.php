@extends('layouts.admin')

@section('title', 'Tambah Aset Pribadi')

@section('content')

    @use(Illuminate\Support\Facades\Auth)
    <!-- Main -->
    <main class="qn-main bg-body-tertiary d-flex flex-column">

        <!-- [START] Content -->
        <div class="container">
            <div class="row row-cols-1 gy-3 p-3 p-lg-4">
                <div class="d-flex align-items-center justify-content-between gap-1 px-0 mb-2">
                    <div class="d-flex flex-column gap-2">
                        <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
                            <ol class="breadcrumb mb-1">
                                <li class="breadcrumb-item"><a href="#"><i class="sym sym-home-line"></i> Master</a></li>
                                <li class="breadcrumb-item"><a href="{{ route('aset-pribadi.index') }}">Aset Pribadi</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Tambah</li>
                            </ol>
                        </nav>
                    </div>
                    <a href="{{ route('aset-pribadi.index') }}" class="btn btn-outline-secondary">
                        <i class="sym sym-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Alert Messages -->
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <h4 class="m-0 mb-2">Tambah Aset Pribadi</h4>
                        <span class="text-muted">Isi formulir di bawah ini untuk menambah data aset pribadi baru.</span>

                        <form action="{{ route('aset-pribadi.store') }}" method="POST" enctype="multipart/form-data" class="mt-4">
                            @csrf

                            <div class="row">
                                <!-- Left Column -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Informasi Aset</h5>

                                    <div class="mb-3">
                                        <label for="nama_aset" class="form-label">Nama Aset <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="nama_aset" name="nama_aset"
                                               value="{{ old('nama_aset') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="merk" class="form-label">Merk <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="merk" name="merk"
                                               value="{{ old('merk') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="tipe" name="tipe"
                                               value="{{ old('tipe') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="no_seri" class="form-label">No. Seri <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="no_seri" name="no_seri"
                                               value="{{ old('no_seri') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sistem_os" class="form-label">Sistem OS <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="sistem_os" name="sistem_os"
                                               value="{{ old('sistem_os') }}" required>
                                    </div>

                                    <div class="mb-3">
                                        <label for="mac_address" class="form-label">MAC Address <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" id="mac_address" name="mac_address"
                                               value="{{ old('mac_address') }}" required>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="col-md-6">
                                    <h5 class="text-primary mb-3">Informasi User & Manager</h5>

                                    <div class="mb-3">
                                        <label for="jabatan_user" class="form-label">Jabatan User</label>
                                        <input type="text" class="form-control" id="jabatan_user" name="jabatan_user"
                                               value="{{ old('jabatan_user', $users->job_role ?? '') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="divisi" class="form-label">Divisi</label>
                                        <input type="text" class="form-control" id="divisi" name="divisi"
                                               value="{{ old('divisi') }}">
                                    </div>

                                    <div class="mb-3">
                                        <label for="id_manager" class="form-label">Manager</label>
                                        <select class="form-select" id="id_manager" name="id_manager">
                                            <option value="">Pilih Manager</option>
                                            @foreach($managers as $manager)
                                                <option value="{{ $manager->id }}" {{ old('id_manager') == $manager->id ? 'selected' : '' }}>
                                                    {{ $manager->name_karyawan }} - {{ $manager->job_role }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jabatan_manager" class="form-label">Jabatan Manager</label>
                                        <input type="text" class="form-control" id="jabatan_manager" name="jabatan_manager"
                                               value="{{ old('jabatan_manager') }}">
                                    </div>

                                    <div class="mb-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="is_manager" name="is_manager"
                                                   value="1" {{ old('is_manager') ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_manager">
                                                Adalah seorang Manager
                                            </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pencabutan Section -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">Informasi Pencabutan (Opsional)</h5>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="nomor_pencabutan_user" class="form-label">Nomor Pencabutan</label>
                                        <input type="text" class="form-control" id="nomor_pencabutan_user" name="nomor_pencabutan_user"
                                               value="{{ old('nomor_pencabutan_user') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="alasan_pencabutan_user" class="form-label">Alasan Pencabutan</label>
                                        <textarea class="form-control" id="alasan_pencabutan_user" name="alasan_pencabutan_user"
                                                  rows="3">{{ old('alasan_pencabutan_user') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Section (for Admin) -->
                            @if(in_array(Auth::user()->role, ['admin', 'super_admin']))
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">Status & Keputusan</h5>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="pending" {{ old('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="menunggu_admin" {{ old('status') == 'menunggu_admin' ? 'selected' : '' }}>Menunggu Admin</option>
                                            <option value="disetujui" {{ old('status') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="ditolak" {{ old('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status_reset_os" class="form-label">Status Reset OS</label>
                                        <select class="form-select" id="status_reset_os" name="status_reset_os">
                                            <option value="">Pilih Status</option>
                                            <option value="sudah" {{ old('status_reset_os') == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                            <option value="belum" {{ old('status_reset_os') == 'belum' ? 'selected' : '' }}>Belum</option>
                                            <option value="tidak_perlu" {{ old('status_reset_os') == 'tidak_perlu' ? 'selected' : '' }}>Tidak Perlu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="mb-3">
                                        <label for="status_backup" class="form-label">Status Backup</label>
                                        <select class="form-select" id="status_backup" name="status_backup">
                                            <option value="">Pilih Status</option>
                                            <option value="sudah" {{ old('status_backup') == 'sudah' ? 'selected' : '' }}>Sudah</option>
                                            <option value="belum" {{ old('status_backup') == 'belum' ? 'selected' : '' }}>Belum</option>
                                            <option value="tidak_perlu" {{ old('status_backup') == 'tidak_perlu' ? 'selected' : '' }}>Tidak Perlu</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="keputusan_manager" class="form-label">Keputusan Manager</label>
                                        <select class="form-select" id="keputusan_manager" name="keputusan_manager">
                                            <option value="">Pilih Keputusan</option>
                                            <option value="disetujui" {{ old('keputusan_manager') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="ditolak" {{ old('keputusan_manager') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="catatan_manager" class="form-label">Catatan Manager</label>
                                        <textarea class="form-control" id="catatan_manager" name="catatan_manager"
                                                  rows="3">{{ old('catatan_manager') }}</textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="keputusan_admin" class="form-label">Keputusan Admin</label>
                                        <select class="form-select" id="keputusan_admin" name="keputusan_admin">
                                            <option value="">Pilih Keputusan</option>
                                            <option value="disetujui" {{ old('keputusan_admin') == 'disetujui' ? 'selected' : '' }}>Disetujui</option>
                                            <option value="ditolak" {{ old('keputusan_admin') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="catatan_admin" class="form-label">Catatan Admin</label>
                                        <textarea class="form-control" id="catatan_admin" name="catatan_admin"
                                                  rows="3">{{ old('catatan_admin') }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endif

                            <!-- Lampiran -->
                            <div class="row mt-4">
                                <div class="col-12">
                                    <h5 class="text-primary mb-3">Lampiran</h5>
                                    <div class="mb-3">
                                        <label for="lampiran" class="form-label">Upload Lampiran</label>
                                        <input type="file" class="form-control" id="lampiran" name="lampiran[]"
                                               multiple accept=".jpg,.jpeg,.png,.pdf">
                                        <div class="form-text">Format yang diizinkan: JPG, JPEG, PNG, PDF. Maksimal 5MB per file.</div>
                                    </div>
                                </div>
                            </div>

                            <div class="d-flex justify-content-end gap-2 mt-4">
                                <a href="{{ route('aset-pribadi.index') }}" class="btn btn-secondary">Batal</a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="sym sym-save"></i> Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        // Auto-fill jabatan manager when manager is selected
        document.getElementById('id_manager').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const jabatanManager = document.getElementById('jabatan_manager');

            if (selectedOption.value) {
                const jabatan = selectedOption.text.split(' - ')[1];
                jabatanManager.value = jabatan || '';
            } else {
                jabatanManager.value = '';
            }
        });
    </script>
@endsection
