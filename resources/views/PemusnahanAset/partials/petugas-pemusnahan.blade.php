<div class="col-md-4">
    <label class="form-label">{{ $labelUser }}</label>
    <select class="form-select petugas-select" required name="{{ $nameUser }}" data-target-role="{{ $idRole }}">
        <option value="">-- Pilih {{ $labelUser }} --</option>

        @foreach ($users as $user)
            <option value="{{ $user->id }}" data-role="{{ $user->job_role ?? '' }}"
                {{ isset($selectedUser) && $selectedUser == $user->id ? 'selected' : '' }}>
                {{ $user->name_karyawan }}
            </option>
        @endforeach
    </select>
</div>

<div class="col-md-4">
    <label class="form-label">Job Role <span class="text-danger">*</span></label>
    <input type="text" id="{{ $idRole }}" name="{{ $nameRole }}" class="form-control"
        placeholder="Job Role" value="{{ $selectedRole ?? '' }}" readonly>
</div>

<div class="col-md-4">
    <label class="form-label">{{ $labelPeran }} <span class="text-danger">*</span></label>
    <input type="text" name="{{ $namePeran }}" class="form-control" value="{{ $selectedPeran ?? '' }}"
        placeholder="{{ $labelPeran }}" required>
</div>
