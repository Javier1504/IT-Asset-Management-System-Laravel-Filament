<!-- Modal untuk menampilkan gambar detail -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="imageModalLabel">Detail Gambar Bukti Dokumen</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Detail Gambar" class="img-fluid"
                    style="max-width: 100%; height: auto;">
            </div>
            <div class="modal-footer">
                <a id="downloadImageBtn" href="" download class="btn btn-primary">
                    <i class="sym sym-download-line"></i> Unduh Gambar
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
