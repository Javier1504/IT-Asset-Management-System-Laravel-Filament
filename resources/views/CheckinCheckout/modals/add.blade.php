<div class="modal fade" id="addModal" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('checkin-checkout-spareparts.store') }}">
                @csrf
                <input type="hidden" name="sparepart_id" value="{{ $sparepartItem->id }}">

                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Tambah Data Keluar/Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe"
                            required>
                            <option value="">Pilih Tipe</option>
                            <option value="checkin">Check In</option>
                            <option value="checkout">Check Out</option>
                        </select>
                        @error('tipe')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror"
                            id="tanggal" name="tanggal" required>
                        @error('tanggal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('qty') is-invalid @enderror" id="qty"
                            name="qty" min="1" required>
                        @error('qty')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 field-alasan">
                        <label for="alasan" class="form-label">Alasan<span class="text-danger">*</span></label>
                        <textarea class="form-control @error('alasan') is-invalid @enderror" id="alasan" name="alasan" rows="3"></textarea>
                        @error('alasan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 field-user">
                        <label for="user_id" class="form-label">Pemegang</label>
                        <select class="form-select @error('user_id') is-invalid @enderror" id="user_id"
                            name="user_id">
                            <option value="">Pilih Pemegang</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name_karyawan }}</option>
                            @endforeach
                        </select>
                        @error('user_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3 field-aset">
                        <label for="aset_id" class="form-label">No Aset Tujuan</label>
                        <select class="form-select @error('aset_id') is-invalid @enderror" id="aset_id"
                            name="aset_id">
                            <option value="">Pilih Aset</option>
                            @foreach ($asets as $aset)
                                <option value="{{ $aset->id }}">{{ $aset->nomor_aset }}</option>
                            @endforeach
                        </select>
                        @error('aset_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
