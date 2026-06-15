@extends('layouts.admin')

@section('title', 'Ajukan Permintaan Aset Pribadi')

@section('content')

    <header class="qn-header z-1 sticky-top p-md-3 py-3 px-xl-5 bg-white">
        <div class="container-fluid d-grid d-flex justify-content-between align-items-center position-relative">
            <div class="d-flex align-items-center gap-3">
                <a href="{{ route('aset-pribadi-request') }}" class="btn btn-close"
                    aria-label="Kembali ke halaman list"></a>
                <span class="m-0 fs-6 fw-medium">Form Permintaan Aset Pribadi</span>
            </div>
            <div class="d-flex gap-2 align-items-center">
                <button type="submit" class="d-none d-md-block btn btn-primary" form="formPermintaanAsetPribadi">
                    Ajukan Permintaan
                </button>
            </div>
        </div>
    </header>

    <main class="qn-main bg-body-tertiary d-flex flex-column">
        <div class="container-fluid">
            <div class="w-100 p-2 bg-white">
                <div class="w-100 bg-body-tertiary rounded-4 p-2 py-md-3 py-xl-4 pb-5">
                    <form method="POST" action="{{ route('aset-pribadi-store-request') }}" id="formPermintaanAsetPribadi"
                        class="qn-form w-100 position-relative" enctype="multipart/form-data">
                        @csrf
                        <div class="row px-3 row-cols-1 gy-4">
                            <!-- Informasi Umum -->
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 g-3">
                                        <div class="col-12">
                                            <h1 class="fs-5 fw-medium mb-0">Informasi Umum</h1>
                                            <p class="fs-6 fw-medium text-secondary">Masukkan informasi dasar permintaan aset pribadi.</p>
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">
                                                Nama Pegawai
                                            </label>
                                            <input type="text" class="form-control" name=""
                                                 readonly  value="{{ $users->name_karyawan }}">
                                            @error('jabatan_manager')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-12 col-md-6">
                                            <label class="form-label">
                                                Divisi
                                            </label>
                                            <input type="text" class="form-control" name="divisi"
                                                   required readonly value="{{ $users->team }}">
                                            @error('divisi')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">
                                                Jabatan personel
                                            </label>
                                            <input type="text" class="form-control" name="jabatan_user"
                                                   required readonly  value="{{ $users->job_role }}">
                                            @error('jabatan_user')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        {{-- @dd($users) --}}
                                        <div class="col-12">
                                            <label class="form-label">
                                                Apakah Anda seorang Manager?
                                            </label>
                                            <input class="form-check-input" type="hidden" name="is_manager" value="{{ $users->role == 'manager' ? '1' : '0' }}">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_manager" id="is_manager_yes"
                                                       value="1" {{ old('is_manager', $users->role == 'manager' ? '1' : '0') == '1' ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="is_manager_yes">
                                                    Ya
                                                </label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="is_manager" id="is_manager_no"
                                                       value="0" {{ old('is_manager', $users->role == 'manager' ? '1' : '0') == '0' ? 'checked' : '' }} disabled>
                                                <label class="form-check-label" for="is_manager_no">
                                                    Tidak
                                                </label>
                                            </div>
                                            @error('is_manager')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @if($users->role != 'manager')
                                        <div class="col-12 col-md-6">
                                            <label class="form-label">
                                                Pilih manager kamu <span class="text-danger">*</span>
                                            </label>
                                            <select id="manager-selected" class="form-select" name="id_manager" required>
                                                <option value="">Pilih manager kamu</option>
                                                @foreach($managers as $manager)
                                                    <option value="{{ $manager->id }}" data-job-role="{{ $manager->job_role }}" {{ old('id_manager') == $manager->id ? 'selected' : '' }}>
                                                        {{ $manager->name_karyawan }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @error('id_manager')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>


                                        <div class="col-12 col-md-6">
                                            <label class="form-label">
                                                Jabatan manager
                                            </label>
                                            <input type="text" class="form-control" name="jabatan_manager" id="jabatan-manager"
                                                   value="{{ old('jabatan_manager') }}" required readonly>
                                            @error('jabatan_manager')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Daftar Aset Pribadi -->
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 g-3">
                                        <div class="col-12">
                                            <h1 class="fs-5 fw-medium mb-0">Daftar Aset Pribadi</h1>
                                            <p class="fs-6 fw-medium text-secondary">Masukkan detail aset pribadi yang dibawa ke kantor.</p>
                                        </div>

                                        <div class="col-12">
                                            <div id="aset-container">
                                                <div class="aset-item border rounded p-3 mb-3">
                                                    <div class="row g-3">
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Nama Laptop<span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="aset_pribadi[0][nama]" placeholder="Laptop Asus Vivobook Go 14....." required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Merk <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="aset_pribadi[0][merk]" placeholder="ASUS" required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Tipe <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="aset_pribadi[0][tipe]" placeholder="Go 14 Flip....." required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">No. Seri <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="aset_pribadi[0][no_seri]" placeholder="20230715-001-123....." required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Sistem OS <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="aset_pribadi[0][sistem_os]" placeholder="Windows 10 Home edition....." required>
                                                        </div>
                                                        <div class="col-12 col-md-6">
                                                            <label class="form-label">Mac Address <span class="text-danger">*</span></label>
                                                            <input type="text" class="form-control" name="aset_pribadi[0][mac_address]" placeholder="C8:5B:76:44:83:1B....." required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 g-3">
                                        <div class="col-12">
                                            <h1 class="fs-5 fw-medium mb-0">Isi alasan penggunaan aset pribadi</h1>
                                            <p class="fs-6 fw-medium text-secondary">Buktikan kenapa kamu harus menggunakan aset pribadi untuk menunjang pekerjaan.</p>
                                        </div>

                                        <div class="col-12">
                                            <label class="form-label">Alasan Penggunaan</label><span class="text-danger">*</span>
                                            <textarea class="form-control" name="catatan_user" rows="4" placeholder="Jelaskan alasan penggunaan aset pribadi secara singkat dan jelas..." required></textarea>
                                            @error('catatan_user')
                                                <div class="text-danger small">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Lampiran -->
                            <div class="card p-0 border-0 rounded-4 shadow-sm">
                                <div class="card-body p-3 px-md-4 p-xl-4 px-xl-5">
                                    <div class="row row-cols-1 g-3">
                                        <div class="col-12">
                                            <h1 class="fs-5 fw-medium mb-0">Lampiran</h1>
                                            <p class="fs-6 fw-medium text-secondary">Upload foto laptop secara lengkap.</p>
                                        </div>                        <div class="col-12">
                            <label class="form-label">Upload File</label>
                            <div id="upload-container">
                                <div class="upload-item mb-3">
                                    <input type="file" class="form-control file-input" name="lampiran[]" multiple
                                           accept=".jpg,.jpeg,.png" required>
                                    <div class="form-text">
                                        Format yang diizinkan: JPG, JPEG, PNG. Maksimal 5MB per file.
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Container -->
                            <div id="preview-container" class="mt-3" style="display: none;">
                                <h6 class="fw-medium mb-3">Preview File:</h6>
                                <div id="preview-grid" class="row g-3"></div>
                            </div>

                            <!-- Add More Button -->
                            <button type="button" id="add-more-files" class="btn btn-outline-primary mt-3" style="display: none;">
                                <i class="fas fa-plus me-2"></i>Upload File Lainnya
                            </button>

                            @error('lampiran.*')
                                <div class="text-danger small">{{ $message }}</div>
                            @enderror
                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>

    <!-- Submit Button Mobile -->
    <div class="qn-mobile-action d-block d-md-none fixed-bottom bg-white p-3 border-top">
        <button type="submit" class="btn w-100 btn-primary" form="formPermintaanAsetPribadi">
            Ajukan Permintaan
        </button>
    </div>

@section('footer', '')

<!-- jQuery (required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Select2 CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* Custom Select2 styling for better integration */
.select2-container--default .select2-selection--single {
    height: 38px !important;
    border: 1px solid #dee2e6 !important;
    border-radius: 0.375rem !important;
}

.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 36px !important;
    padding-left: 12px !important;
    color: #495057 !important;
}

.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 36px !important;
}

.select2-dropdown {
    border-radius: 0.375rem !important;
    border: 1px solid #dee2e6 !important;
}

.select2-container {
    width: 100% !important;
}

/* File Preview Styles */
.preview-item {
    position: relative;
    border: 1px solid #dee2e6;
    border-radius: 0.375rem;
    overflow: hidden;
    background: #f8f9fa;
}

.preview-image {
    width: 100%;
    height: 150px;
    object-fit: cover;
}

.preview-info {
    padding: 0.5rem;
    font-size: 0.875rem;
}

.preview-name {
    font-weight: 500;
    color: #495057;
    word-break: break-word;
}

.preview-size {
    color: #6c757d;
    font-size: 0.75rem;
}

.remove-file {
    position: absolute;
    top: 0.5rem;
    right: 0.5rem;
    background: rgba(220, 53, 69, 0.9);
    color: white;
    border: none;
    border-radius: 50%;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    cursor: pointer;
    transition: background-color 0.2s;
}

.remove-file:hover {
    background: rgba(220, 53, 69, 1);
}

.file-input-hidden {
    display: none;
}
</style>

<script>
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: '{{ session('success') }}',
        });
    @endif

    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal',
            text: '{{ session('error') }}',
        });
    @endif

    $(document).ready(function() {
        // Initialize Select2 for manager selection
        $('#manager-selected').select2({
            placeholder: "Pilih manager kamu",
            allowClear: true,
            width: '100%'
        });

        // Handle manager selection change with Select2
        $('#manager-selected').on('change', function() {
            const selectedValue = $(this).val();
            const jabatanManagerInput = document.getElementById('jabatan-manager');

            if (selectedValue) {
                const selectedOption = $(this).find('option:selected');
                const jobRole = selectedOption.data('job-role');
                jabatanManagerInput.value = jobRole || '';
            } else {
                jabatanManagerInput.value = '';
            }
        });

        // Auto-fill jabatan manager jika ada old value
        const managerSelect = $('#manager-selected');
        const selectedValue = managerSelect.val();
        const jabatanManagerInput = document.getElementById('jabatan-manager');

        if (selectedValue) {
            const selectedOption = managerSelect.find('option:selected');
            const jobRole = selectedOption.data('job-role');
            jabatanManagerInput.value = jobRole || '';
        }
    });
    // Script untuk mengisi jabatan manager berdasarkan pilihan manager (fallback untuk non-jQuery)
    if (document.getElementById('manager-selected')) {
        document.getElementById('manager-selected').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const jabatanManagerInput = document.getElementById('jabatan-manager');

            if (selectedOption.value) {
                const jobRole = selectedOption.getAttribute('data-job-role');
                jabatanManagerInput.value = jobRole || '';
            } else {
                jabatanManagerInput.value = '';
            }
        });

        // Auto-fill jabatan manager jika ada old value (fallback)
        document.addEventListener('DOMContentLoaded', function() {
            const managerSelect = document.getElementById('manager-selected');
            const selectedOption = managerSelect.options[managerSelect.selectedIndex];
            const jabatanManagerInput = document.getElementById('jabatan-manager');

            if (selectedOption.value) {
                const jobRole = selectedOption.getAttribute('data-job-role');
                jabatanManagerInput.value = jobRole || '';
            }
        });
    }

    // File Upload with Preview Functionality
    let fileCount = 0;
    let uploadedFiles = [];

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 Bytes';
        const k = 1024;
        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
        const i = Math.floor(Math.log(bytes) / Math.log(k));
        return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
    }

    function createPreviewItem(file, index) {
        const previewItem = document.createElement('div');
        previewItem.className = 'col-md-4 col-lg-3';
        previewItem.setAttribute('data-file-index', index);

        const reader = new FileReader();
        reader.onload = function(e) {
            previewItem.innerHTML = `
                <div class="preview-item">
                    <img src="${e.target.result}" alt="Preview" class="preview-image">
                    <div class="preview-info">
                        <div class="preview-name">${file.name}</div>
                        <div class="preview-size">${formatFileSize(file.size)}</div>
                    </div>
                    <button type="button" class="remove-file" onclick="removeFile(${index})">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            `;
        };
        reader.readAsDataURL(file);

        return previewItem;
    }

    function updateFileInput() {
        const container = document.getElementById('upload-container');
        const existingInputs = container.querySelectorAll('.file-input');

        // Remove all existing inputs
        existingInputs.forEach(input => {
            input.parentElement.remove();
        });

        // Create new file input with current files
        const uploadItem = document.createElement('div');
        uploadItem.className = 'upload-item mb-3';

        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.className = 'form-control file-input file-input-hidden';
        fileInput.name = 'lampiran[]';
        fileInput.multiple = true;
        fileInput.accept = '.jpg,.jpeg,.png';

        // Create DataTransfer object to hold our files
        const dt = new DataTransfer();
        uploadedFiles.forEach(file => {
            dt.items.add(file);
        });
        fileInput.files = dt.files;

        uploadItem.appendChild(fileInput);
        container.appendChild(uploadItem);
    }

    function removeFile(index) {
        // Remove from uploadedFiles array
        uploadedFiles.splice(index, 1);

        // Remove preview item
        const previewItem = document.querySelector(`[data-file-index="${index}"]`);
        if (previewItem) {
            previewItem.remove();
        }

        // Update remaining preview items' indices
        const remainingItems = document.querySelectorAll('[data-file-index]');
        remainingItems.forEach((item, newIndex) => {
            item.setAttribute('data-file-index', newIndex);
            const removeBtn = item.querySelector('.remove-file');
            if (removeBtn) {
                removeBtn.setAttribute('onclick', `removeFile(${newIndex})`);
            }
        });

        // Update file input
        updateFileInput();

        // Hide preview container if no files
        if (uploadedFiles.length === 0) {
            document.getElementById('preview-container').style.display = 'none';
            document.getElementById('add-more-files').style.display = 'none';

            // Show the original file input
            const newUploadItem = document.createElement('div');
            newUploadItem.className = 'upload-item mb-3';
            newUploadItem.innerHTML = `
                <input type="file" class="form-control file-input" name="lampiran[]" multiple
                       accept=".jpg,.jpeg,.png" required>
                <div class="form-text">
                    Format yang diizinkan: JPG, JPEG, PNG. Maksimal 5MB per file.
                </div>
            `;

            const container = document.getElementById('upload-container');
            container.innerHTML = '';
            container.appendChild(newUploadItem);

            // Re-attach event listener
            attachFileInputListener();
        }
    }

    function handleFileSelection(files) {
        const maxSize = 5 * 1024 * 1024; // 5MB
        const allowedTypes = ['image/jpeg', 'image/jpg', 'image/png'];

        Array.from(files).forEach((file, index) => {
            // Validate file size
            if (file.size > maxSize) {
                Swal.fire({
                    icon: 'error',
                    title: 'File Terlalu Besar',
                    text: `File ${file.name} melebihi batas maksimal 5MB.`,
                });
                return;
            }

            // Validate file type
            if (!allowedTypes.includes(file.type)) {
                Swal.fire({
                    icon: 'error',
                    title: 'Format File Tidak Valid',
                    text: `File ${file.name} harus berformat JPG, JPEG, atau PNG.`,
                });
                return;
            }

            // Add to uploaded files
            uploadedFiles.push(file);

            // Create preview
            const previewGrid = document.getElementById('preview-grid');
            const previewItem = createPreviewItem(file, uploadedFiles.length - 1);
            previewGrid.appendChild(previewItem);
        });

        if (uploadedFiles.length > 0) {
            // Show preview container and add more button
            document.getElementById('preview-container').style.display = 'block';
            document.getElementById('add-more-files').style.display = 'inline-block';

            // Update file input
            updateFileInput();
        }
    }

    function attachFileInputListener() {
        const fileInputs = document.querySelectorAll('.file-input');
        fileInputs.forEach(input => {
            input.addEventListener('change', function() {
                if (this.files.length > 0) {
                    handleFileSelection(this.files);

                    // Hide the original upload area
                    this.parentElement.style.display = 'none';
                }
            });
        });
    }

    // Add more files button functionality
    document.getElementById('add-more-files').addEventListener('click', function() {
        const fileInput = document.createElement('input');
        fileInput.type = 'file';
        fileInput.multiple = true;
        fileInput.accept = '.jpg,.jpeg,.png';
        fileInput.style.display = 'none';

        fileInput.addEventListener('change', function() {
            if (this.files.length > 0) {
                handleFileSelection(this.files);
            }
        });

        document.body.appendChild(fileInput);
        fileInput.click();
        document.body.removeChild(fileInput);
    });

    // Initialize file input listeners
    document.addEventListener('DOMContentLoaded', function() {
        attachFileInputListener();
    });
</script>

@endsection
