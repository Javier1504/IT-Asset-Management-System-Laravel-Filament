<!-- Modal Review -->
<div class="modal fade" id="reviewModal" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true"
    data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="reviewModalLabel">
                    <i class="fas fa-star me-2"></i>Berikan Ulasan
                </h5>
            </div>

            <form id="reviewForm" method="POST" action="{{ route('reviews.store') }}">
                @csrf
                <div class="modal-body">
                    <input type="hidden" name="review_id" id="review_id" value="">
                    <input type="hidden" name="reference_type" id="reference_type" value="">
                    <input type="hidden" name="reference_id" id="reference_id" value="">
                    <input type="hidden" name="petugas_id" id="petugas_id" value="">

                    <!-- Rating Section -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">
                            <i class="fas fa-star text-warning me-2"></i>Rating <span class="text-danger">*</span>
                        </label>
                        <div class="rating-container d-flex align-items-center">
                            <div class="star-rating me-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span class="star" data-rating="{{ $i }}">
                                        <i class="far fa-star fs-4"></i>
                                    </span>
                                @endfor
                            </div>
                            <div class="rating-text">
                                <span id="rating-label" class="text-muted">Pilih rating</span>
                            </div>
                        </div>
                        <input type="hidden" name="rating" id="rating" value="">
                        <div class="invalid-feedback" id="rating-error"></div>
                    </div>

                    <!-- Rating Details Section -->
                    <div class="mb-3" id="rating-details-section" style="display: none;">
                        <div class="mb-2">
                            <label class="form-label fw-bold" id="rating-message"></label>
                        </div>
                        <div id="rating-details-container" class="rating-detail-container"></div>
                        <div class="invalid-feedback d-block" id="rating-details-error"></div>
                    </div>

                    <!-- Review Text -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Komentar <small
                                class="text-muted fw-normal">(opsional)</small></label>
                        <textarea class="form-control" id="review_text" name="review" rows="3"
                            placeholder="Berikan komentar mengenai pelayanan petugas..."></textarea>
                        <div class="form-text">Maksimal 1000 karakter</div>
                        <div class="invalid-feedback" id="review-error"></div>
                    </div>

                    <!-- Anonymous Option -->
                    <div class="mb-3">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="is_anonymous" name="is_anonymous"
                                value="1">
                            <label class="form-check-label" for="is_anonymous">
                                <i class="fas fa-user-secret me-2"></i>Beri ulasan secara anonim
                            </label>
                        </div>
                    </div>

                    <!-- Review Guidelines -->
                    <div class="alert alert-info mb-0 py-2">
                        <i class="fas fa-info-circle me-2"></i>
                        <small><strong>Masukan Anda sangat berarti untuk meningkatkan layanan IT Support dan
                                pengembangan ITAM.</strong></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary d-none" id="closeReviewBtn" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Tutup
                    </button>
                    <button type="submit" class="btn btn-primary" id="submitReview">
                        <i class="fas fa-paper-plane me-2"></i>Kirim Review
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    /* Star Rating */
    .star-rating {
        display: flex;
        gap: 5px;
    }

    .star {
        cursor: pointer;
        transition: all 0.2s;
        color: #ddd;
    }

    .star:hover,
    .star.active {
        color: #ffc107 !important;
    }

    .star i {
        pointer-events: none;
    }

    /* Modal Styling */
    .modal-content {
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    .modal-header {
        border-bottom: 2px solid rgba(255, 255, 255, 0.2);
    }

    .modal-dialog-scrollable .modal-body {
        max-height: calc(100vh - 200px);
        overflow-y: auto;
    }

    /* Rating Detail Items - Chip Style */
    .rating-detail-container {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
    }

    .rating-detail-item {
        padding: 6px 14px;
        border: 1px solid #dee2e6;
        border-radius: 20px;
        font-size: 13px;
        background: #fff;
        cursor: pointer;
        transition: all 0.2s ease;
        user-select: none;
    }

    .rating-detail-item:hover {
        border-color: #0d6efd;
        background-color: #f8f9fa;
        transform: translateY(-1px);
    }

    .rating-detail-item.selected {
        border-color: #0d6efd;
        background-color: #e7f1ff;
        color: #0d6efd;
        font-weight: 500;
    }

    /* Form Elements */
    .form-label.fw-bold {
        color: #495057;
        font-size: 14px;
    }

    .card.bg-light {
        border: 1px solid #dee2e6;
    }

    .alert-info {
        border-left: 4px solid #0dcaf0;
    }

    .btn {
        border-radius: 6px;
        font-weight: 500;
    }

    .form-control {
        border-radius: 6px;
    }

    .form-check-input:checked {
        background-color: #0d6efd;
        border-color: #0d6efd;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Elements
        const stars = document.querySelectorAll('.star');
        const ratingInput = document.getElementById('rating');
        const ratingLabel = document.getElementById('rating-label');
        const submitButton = document.getElementById('submitReview');
        const reviewForm = document.getElementById('reviewForm');
        const ratingDetailsSection = document.getElementById('rating-details-section');
        const ratingDetailsContainer = document.getElementById('rating-details-container');
        const reviewTextArea = document.getElementById('review_text');
        // Constants
        const RATING_LABELS = {
            1: 'Sangat Buruk',
            2: 'Buruk',
            3: 'Cukup',
            4: 'Baik',
            5: 'Sangat Baik'
        };

        const RATING_DETAILS = {
            low: [
                'Waktu penyelesaian terlalu lama',
                'Respon awal lambat',
                'Solusi belum menyelesaikan masalah',
                'Penjelasan solusi sulit dipahami',
                'Sikap petugas kurang ramah',
                'Kenyamanan ruang layanan kurang baik'
            ],
            high: [
                'Pelayanan sangat baik',
                'Penjelasan jelas dan mudah dipahami',
                'Penanganan tepat waktu',
                'Masalah diselesaikan dengan cepat',
                'Petugas ramah dan komunikatif',
                'Suasana ruang layanan nyaman'
            ]
        };

        // Star Rating Events
        stars.forEach((star) => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.dataset.rating);
                setRating(rating);
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.dataset.rating);
                updateStarDisplay(rating, true);
            });
        });

        document.querySelector('.star-rating').addEventListener('mouseleave', function() {
            const currentRating = parseInt(ratingInput.value) || 0;
            updateStarDisplay(currentRating);
        });

        // Functions
        function setRating(rating) {
            ratingInput.value = rating;
            ratingLabel.textContent = RATING_LABELS[rating];
            ratingLabel.className = 'text-warning fw-bold';
            updateStarDisplay(rating);
            showRatingDetails(rating);
            clearError('rating-error');
        }

        function updateStarDisplay(rating, isHover = false) {
            stars.forEach((star, index) => {
                const starIcon = star.querySelector('i');
                const isActive = index < rating;

                star.classList.toggle('active', isActive);
                starIcon.className = isActive ? 'fas fa-star fs-4' : 'far fa-star fs-4';

                if (!isHover && !isActive) {
                    star.style.color = '#ddd';
                }
            });
        }

        function showRatingDetails(rating) {
            const ratingMessage = document.getElementById('rating-message');

            if (rating >= 1 && rating <= 3) {
                ratingMessage.innerHTML = '<i class="fas fa-comment me-2"></i>Apa yang perlu kami tingkatkan?';
            } else if (rating >= 4 && rating <= 5) {
                ratingMessage.innerHTML = '<i class="fas fa-comment me-2"></i>Sampaikan apresiasi Anda!';
            }

            const details = rating <= 3 ? RATING_DETAILS.low : RATING_DETAILS.high;
            ratingDetailsContainer.innerHTML = '';

            details.forEach((detail) => {
                const item = document.createElement('div');
                item.className = 'rating-detail-item';
                item.textContent = detail;
                item.dataset.value = detail;

                item.addEventListener('click', function() {
                    this.classList.toggle('selected');
                });

                ratingDetailsContainer.appendChild(item);
            });

            ratingDetailsSection.style.display = 'block';
        }

        function getSelectedDetails() {
            const selected = ratingDetailsContainer.querySelectorAll('.rating-detail-item.selected');
            return Array.from(selected).map(item => item.dataset.value);
        }

        function clearError(errorId) {
            const errorElement = document.getElementById(errorId);
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }

        function showError(errorId, message) {
            const errorElement = document.getElementById(errorId);
            errorElement.textContent = message;
            errorElement.style.display = 'block';
        }

        // Form Submission
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Validate rating
            if (!ratingInput.value || ratingInput.value < 1 || ratingInput.value > 5) {
                ratingInput.classList.add('is-invalid');
                showError('rating-error', 'Silakan pilih rating terlebih dahulu');
                return;
            }

            // Validate rating details
            const rating = parseInt(ratingInput.value);
            if (rating >= 1 && rating <= 3 || rating >= 4 && rating <= 5) {
                const selectedDetails = getSelectedDetails();
                if (selectedDetails.length === 0) {
                    showError('rating-details-error', 'Silakan pilih minimal satu aspek penilaian');
                    ratingDetailsSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                    return;
                }

                // Add selected details as hidden inputs
                selectedDetails.forEach(detail => {
                    const input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'rating_details[]';
                    input.value = detail;
                    reviewForm.appendChild(input);
                });
            }

            // Submit form
            submitButton.disabled = true;
            submitButton.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Mengirim...';
            this.submit();
        });

        // Character Counter
        reviewTextArea.addEventListener('input', function() {
            const maxLength = 1000;
            const currentLength = this.value.length;
            const remaining = maxLength - currentLength;
            const helpText = this.parentNode.querySelector('.form-text');

            if (currentLength > maxLength) {
                this.value = this.value.substring(0, maxLength);
                return;
            }

            if (remaining < 100) {
                helpText.textContent = `${remaining} karakter tersisa`;
                helpText.className = 'form-text text-warning';
            } else {
                helpText.textContent = 'Maksimal 1000 karakter';
                helpText.className = 'form-text';
            }
        });
    });

    // Function to open modal with review data
    function openReviewModal(reviewData) {
        // Reset form first
        document.getElementById('reviewForm').reset();

        // Set review_id (IMPORTANT!)
        document.getElementById('review_id').value = reviewData.id;

        // Set polymorphic fields (for fallback, meskipun store method sekarang pakai review_id)
        if (reviewData.reference_type) {
            document.getElementById('reference_type').value = reviewData.reference_type;
        }
        if (reviewData.reference_id) {
            document.getElementById('reference_id').value = reviewData.reference_id;
        }
        if (reviewData.petugas_id) {
            document.getElementById('petugas_id').value = reviewData.petugas_id;
        }

        document.getElementById('rating').value = '';
        document.getElementById('rating-label').textContent = 'Pilih rating';
        document.getElementById('rating-label').className = 'text-muted';

        // Reset stars
        document.querySelectorAll('.star').forEach(star => {
            star.classList.remove('active');
            star.querySelector('i').className = 'far fa-star fs-4';
            star.style.color = '#ddd';
        });

        // Hide rating details section
        document.getElementById('rating-details-section').style.display = 'none';
        document.getElementById('rating-details-container').innerHTML = '';

        // Show modal
        const modal = new bootstrap.Modal(document.getElementById('reviewModal'));
        modal.show();

        // Reset & sembunyikan tombol Close
        const closeBtn = document.getElementById('closeReviewBtn');
        closeBtn.classList.add('d-none');

        // Tampilkan tombol Close setelah 5 detik
        setTimeout(() => {
            closeBtn.classList.remove('d-none');
        }, 5000);
    }
</script>
