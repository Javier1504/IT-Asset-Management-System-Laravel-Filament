<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="editForm">
                @csrf
                @method('PUT')
                <input type="hidden" id="edit_id" name="id">

                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Edit Data Keluar/Masuk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_tipe" class="form-label">Tipe <span class="text-danger">*</span></label>
                        <select class="form-select" id="edit_tipe" name="tipe" required disabled>
                            <option value="checkin">Check In</option>
                            <option value="checkout">Check Out</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="edit_tanggal" class="form-label">Tanggal <span class="text-danger">*</span></label>
                        <input type="date" class="form-control" id="edit_tanggal" name="tanggal" required>
                    </div>

                    <div class="mb-3">
                        <label for="edit_qty" class="form-label">Quantity <span class="text-danger">*</span></label>
                        <input type="number" class="form-control" id="edit_qty" name="qty" min="1"
                            required>
                    </div>

                    <div class="mb-3 field-edit-alasan">
                        <label for="edit_alasan" class="form-label">Keterangan <span
                                class="text-danger">*</span></label>
                        <textarea class="form-control" id="edit_alasan" name="alasan" rows="3"></textarea>
                    </div>

                    <div class="mb-3 field-edit-user">
                        <label for="edit_user_id" class="form-label">Pemegang</label>
                        <select class="form-select" id="edit_user_id" name="user_id">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name_karyawan }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3 field-edit-aset">
                        <label for="edit_aset_id" class="form-label">Nomor Aset Tujuan</label>
                        <select class="form-select" id="edit_aset_id" name="aset_id">
                            <option value="">Pilih Aset</option>
                            @foreach ($asets as $aset)
                                <option value="{{ $aset->id }}">{{ $aset->nomor_aset }}</option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
