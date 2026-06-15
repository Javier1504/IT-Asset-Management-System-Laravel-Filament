@props(['commentableType', 'commentableId', 'comments' => []])

@push('styles')
    <style>
        .apple-comment-section {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        }

        .comment-card-modern {
            background: #ffffff;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        }

        .comment-input-wrapper {
            background: #f5f5f7;
            border-radius: 16px;
            transition: all 0.2s ease;
            border: 2px solid transparent;
        }

        .comment-input-wrapper:focus-within {
            background: #ffffff;
            border-color: #007AFF;
            box-shadow: 0 0 0 4px rgba(0, 122, 255, 0.1);
        }

        .comment-textarea {
            background: transparent;
            border: none;
            resize: none;
            padding: 12px 15px;
        }

        .comment-textarea:focus {
            background: transparent;
            box-shadow: none;
            border: none;
        }

        .btn-apple-primary {
            background: #007AFF;
            border-radius: 12px;
            padding: 8px 20px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .btn-apple-primary:hover {
            background: #0063CC;
            transform: translateY(-1px);
        }

        .avatar-apple {
            border-radius: 12px;
            /* Squircle style */
            object-fit: cover;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .comment-item-modern {
            border-bottom: 1px solid #f2f2f2;
            transition: background 0.2s;
        }

        .reply-line {
            border-left: 2px solid #e5e5e7;
            margin-left: 20px;
            padding-left: 20px;
        }
    </style>
@endpush

<div class="apple-comment-section mt-5">
    <div class="comment-card-modern p-4 p-md-5">

        <div class="d-flex align-items-center justify-content-between mb-4">
            <h5 class="fw-bold mb-0" style="letter-spacing: -0.5px;">
                Komentar <span class="text-muted ms-1" style="font-weight: 400;">({{ $comments->count() }})</span>
            </h5>
        </div>

        {{-- Comment Form --}}
        <form action="{{ route('comments.store') }}" method="POST" class="mb-5">
            @csrf
            <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
            <input type="hidden" name="commentable_id" value="{{ $commentableId }}">

            <div class="comment-input-wrapper mb-3">
                <textarea class="form-control comment-textarea @error('content') is-invalid @enderror" id="content" name="content"
                    rows="3" placeholder="Bagikan pemikiran Anda..." required></textarea>
            </div>

            <div class="d-flex justify-content-end">
                <button type="submit" class="btn btn-primary btn-apple-primary border-0">
                    <i class="sym sym-send-plane-fill me-2"></i>Kirim
                </button>
            </div>
        </form>

        {{-- Comments List --}}
        <div class="comments-list">
            @forelse($comments as $comment)
                <div class="comment-item-modern py-4" id="comment-{{ $comment->id }}">
                    <div class="d-flex justify-content-between align-items-start">
                        <div class="d-flex gap-3">
                            <div class="avatar-apple bg-primary text-white flex-shrink-0 d-flex align-items-center justify-content-center fw-bold"
                                style="width: 44px; height: 44px; font-size: 18px;">
                                {{ strtoupper(substr($comment->user->name_karyawan ?? 'U', 0, 1)) }}
                            </div>

                            <div>
                                <div class="d-flex align-items-center gap-2">
                                    <span
                                        class="fw-bold text-dark">{{ $comment->user->name_karyawan ?? 'Unknown User' }}</span>
                                    <span class="text-muted" style="font-size: 13px;">•
                                        {{ $comment->created_at->diffForHumans() }}</span>
                                </div>

                                <div class="comment-content mt-2">
                                    <p class="text-secondary lh-base mb-1" id="comment-text-{{ $comment->id }}">
                                        {{ $comment->content }}</p>
                                </div>

                                <div class="d-flex align-items-center gap-3 mt-2">
                                    <button class="btn btn-sm p-0 border-0 text-primary fw-medium"
                                        style="font-size: 13px;" onclick="toggleReplyForm({{ $comment->id }})">
                                        Balas
                                    </button>
                                    @if (auth()->id() === $comment->user_id)
                                        <button class="btn btn-sm p-0 border-0 text-muted" style="font-size: 13px;"
                                            onclick="editComment({{ $comment->id }}, '{{ addslashes($comment->content) }}')">
                                            Edit
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Dropdown Actions (Hapus) --}}
                        @if (auth()->id() === $comment->user_id || in_array(auth()->user()->role, ['admin', 'super_admin']))
                            <div class="dropdown">
                                <button class="btn btn-link text-muted p-0" data-bs-toggle="dropdown">
                                    <i class="sym sym-more-horizontal-fill"></i>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end border-0 shadow-lg rounded-4">
                                    <li>
                                        <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                            onsubmit="return confirm('Hapus komentar?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="dropdown-item text-danger py-2">Hapus</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>

                    {{-- Edit Form --}}
                    <form action="{{ route('comments.update', $comment->id) }}" method="POST"
                        id="edit-form-{{ $comment->id }}" class="mt-3 bg-light p-3 rounded-4" style="display: none;">
                        @csrf @method('PUT')
                        <textarea class="form-control border-0 bg-transparent mb-2" name="content" rows="2" required>{{ $comment->content }}</textarea>
                        <div class="d-flex gap-2 justify-content-end">
                            <button type="button" class="btn btn-sm btn-light rounded-pill px-3"
                                onclick="cancelEdit({{ $comment->id }})">Batal</button>
                            <button type="submit" class="btn btn-sm btn-primary rounded-pill px-3">Simpan</button>
                        </div>
                    </form>

                    {{-- Reply Form --}}
                    <form action="{{ route('comments.store') }}" method="POST" id="reply-form-{{ $comment->id }}"
                        class="mt-3 ps-5" style="display: none;">
                        @csrf
                        <input type="hidden" name="commentable_type" value="{{ $commentableType }}">
                        <input type="hidden" name="commentable_id" value="{{ $commentableId }}">
                        <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                        <div class="comment-input-wrapper p-2">
                            <textarea class="form-control comment-textarea" name="content" rows="2" placeholder="Tulis balasan..." required></textarea>
                            <div class="d-flex justify-content-end gap-2 p-1">
                                <button type="button" class="btn btn-sm text-muted"
                                    onclick="toggleReplyForm({{ $comment->id }})">Batal</button>
                                <button type="submit" class="btn btn-sm btn-primary rounded-pill">Balas</button>
                            </div>
                        </div>
                    </form>

                    {{-- Replies --}}
                    @if ($comment->replies && $comment->replies->count() > 0)
                        <div class="replies mt-3 reply-line">
                            @foreach ($comment->replies as $reply)
                                <div class="reply-item py-3">
                                    <div class="d-flex gap-2">
                                        <div class="avatar-apple bg-secondary text-white flex-shrink-0 d-flex align-items-center justify-content-center fw-bold"
                                            style="width: 32px; height: 32px; font-size: 13px;">
                                            {{ strtoupper(substr($reply->user->name_karyawan ?? 'U', 0, 1)) }}
                                        </div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex align-items-center gap-2">
                                                <span
                                                    class="fw-bold text-dark small">{{ $reply->user->name_karyawan ?? 'User' }}</span>
                                                <span class="text-muted"
                                                    style="font-size: 11px;">{{ $reply->created_at->diffForHumans() }}</span>
                                            </div>
                                            <p class="text-secondary small mt-1 mb-0">{{ $reply->content }}</p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-5">
                    <div class="opacity-25 mb-3">
                        <i class="sym sym-message-2-line" style="font-size: 64px;"></i>
                    </div>
                    <p class="text-muted">Mari mulai percakapan.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function toggleReplyForm(commentId) {
            const form = document.getElementById('reply-form-' + commentId);
            form.style.display = form.style.display === 'none' ? 'block' : 'none';
        }

        function editComment(commentId, content) {
            event.preventDefault();
            const textElement = document.getElementById('comment-text-' + commentId);
            const editForm = document.getElementById('edit-form-' + commentId);

            textElement.style.display = 'none';
            editForm.style.display = 'block';
        }

        function cancelEdit(commentId) {
            const textElement = document.getElementById('comment-text-' + commentId);
            const editForm = document.getElementById('edit-form-' + commentId);

            textElement.style.display = 'block';
            editForm.style.display = 'none';
        }
    </script>
@endpush
