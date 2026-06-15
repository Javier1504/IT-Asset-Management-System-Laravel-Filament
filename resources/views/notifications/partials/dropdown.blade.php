<!-- Notification Dropdown -->
<div class="dropdown" style="z-index: 100;">
    <button class="btn btn-icon btn-light position-relative" type="button" id="notificationDropdown"
        data-bs-toggle="dropdown" aria-expanded="false">
        <i class="sym sym-bell"></i>
        <span id="unread-badge"
            class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
            style="display: none;">
            0
        </span>
    </button>
    <div class="dropdown-menu dropdown-menu-end shadow-lg border-0 rounded-3 p-0"
        style="width: 380px; max-width: 90vw;" aria-labelledby="notificationDropdown">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <h6 class="mb-0 fw-bold">Notifikasi</h6>
            <div class="d-flex gap-2">
                <button id="mark-all-read" class="btn btn-sm btn-link text-primary p-0 text-decoration-none"
                    title="Tandai semua dibaca">
                    <i class="fas fa-check-double"></i>
                </button>
                <a href="{{ route('notifications.index') }}" class="btn btn-sm btn-link text-primary p-0 text-decoration-none"
                    title="Lihat semua">
                    <i class="fas fa-external-link-alt"></i>
                </a>
            </div>
        </div>

        <!-- Notification List -->
        <div id="notification-list" class="overflow-auto" style="max-height: 400px;">
            <div class="text-center py-5 text-muted">
                <i class="fas fa-bell-slash fa-2x mb-2"></i>
                <p class="mb-0 small">Tidak ada notifikasi</p>
            </div>
        </div>
    </div>
</div>

<script>
    // Load notifications when dropdown is opened
    document.getElementById('notificationDropdown').addEventListener('click', function() {
        loadNotifications();
    });

    // Load notifications on page load
    document.addEventListener('DOMContentLoaded', function() {
        loadNotifications();

        // Refresh notifications every 30 seconds
        setInterval(loadNotifications, 30000);
    });

    // Mark all as read
    document.getElementById('mark-all-read').addEventListener('click', function(e) {
        e.preventDefault();
        markAllAsRead();
    });

    function loadNotifications() {
        fetch('{{ route('notifications.unread') }}', {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            updateNotificationUI(data.notifications, data.unread_count);
        })
        .catch(error => {
            console.error('Error loading notifications:', error);
        });
    }

    function updateNotificationUI(notifications, unreadCount) {
        const badge = document.getElementById('unread-badge');
        const list = document.getElementById('notification-list');

        // Update badge
        if (unreadCount > 0) {
            badge.textContent = unreadCount > 99 ? '99+' : unreadCount;
            badge.style.display = 'block';
        } else {
            badge.style.display = 'none';
        }

        // Update list
        if (notifications.length === 0) {
            list.innerHTML = `
                <div class="text-center py-5 text-muted">
                    <i class="fas fa-bell-slash fa-2x mb-2"></i>
                    <p class="mb-0 small">Tidak ada notifikasi baru</p>
                </div>
            `;
            return;
        }

        list.innerHTML = notifications.map(notif => `
            <div class="notification-item p-3 border-bottom ${!notif.is_read ? 'bg-light' : ''}"
                data-id="${notif.id}">
                <div class="d-flex gap-2 align-items-start">
                    <div class="flex-shrink-0">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center"
                            style="width: 40px; height: 40px;">
                            <i class="fas fa-bell"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1 overflow-hidden">
                        <a href="${notif.url}" class="text-decoration-none text-dark"
                            onclick="markAsRead('${notif.id}')">
                            <h6 class="mb-1 fw-semibold text-truncate">${notif.title}</h6>
                            <p class="mb-1 small text-muted text-truncate">${notif.message}</p>
                            <small class="text-muted">
                                <i class="far fa-clock me-1"></i>${notif.created_at}
                            </small>
                        </a>
                    </div>
                    ${!notif.is_read ? '<div class="flex-shrink-0"><span class="badge bg-primary rounded-pill">Baru</span></div>' : ''}
                </div>
            </div>
        `).join('');
    }

    function markAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/mark-as-read`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(() => {
            loadNotifications();
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
        });
    }

    function markAllAsRead() {
        fetch('{{ route('notifications.mark-all-as-read') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                loadNotifications();
                showToast('Semua notifikasi telah ditandai dibaca');
            }
        })
        .catch(error => {
            console.error('Error marking all notifications as read:', error);
        });
    }

    function showToast(message) {
        // Simple toast notification
        const toast = document.createElement('div');
        toast.className = 'position-fixed bottom-0 end-0 p-3';
        toast.style.zIndex = '11';
        toast.innerHTML = `
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-body bg-success text-white rounded">
                    ${message}
                </div>
            </div>
        `;
        document.body.appendChild(toast);
        setTimeout(() => toast.remove(), 3000);
    }
</script>

<style>
    .notification-item {
        transition: background-color 0.2s;
        cursor: pointer;
    }

    .notification-item:hover {
        background-color: #f8f9fa !important;
    }

    .notification-item:last-child {
        border-bottom: none !important;
    }
</style>
