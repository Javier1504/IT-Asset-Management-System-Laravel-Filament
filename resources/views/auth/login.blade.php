<!doctype html>
<html lang="id">
<x-head></x-head>

<body>
    <main>
        <div class="grid min-vh-100">
            <div class="g-col-12 g-col-lg-6 p-4 d-flex flex-column">
                <div class="d-flex align-items-center gap-3">
                    <div class="ratio ratio-1x1" style="max-width: 3rem;">
                        <img class="w-100 h-100 object-fit-contain" src="{{ asset('assets/images/logo-sevima.png') }}"
                            alt="Logo Company" />
                    </div>
                    <hr class="vr align-self-stretch my-1" />
                    <h1 class="fs-6 fw-semibold m-0" style="max-width: 11.25rem;">
                        SEVIMA IT Asset Management
                    </h1>
                </div>
                <div class="w-100 m-auto py-5" style="max-width: 26.75rem;">
                    @if (session('alert_message'))
                        <div class="alert alert-{{ session('alert_type', 'primary') }} alert-dismissible fade show d-flex gap-2"
                            role="alert">
                            <i class="sym sym-x-circle-solid"></i>
                            <div class="d-block">
                                @if (session('alert_title'))
                                    <h6 class="alert-heading mb-1">{{ session('alert_title') }}</h6>
                                @endif
                                {!! session('alert_message') !!}
                            </div>
                            <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif
                    <h2 class="fs-4 fw-semibold mb-2">Masuk ke IT Asset Management</h2>
                    <p class="text-body-secondary mb-4">
                        Masuk ke akun yang telah terdaftar untuk mengelola aset IT dengan mudah. </p>
                    <div class="d-flex align-items-center gap-2 my-4">
                        <hr class="w-100 m-0" />
                        <p class="text-secondary m-0" style="min-width: fit-content;">
                            Login menggunakan akun LDAP
                        </p>
                        <hr class="w-100 m-0" />
                    </div>
                    <form action="{{ route('auth.verify') }}" method="POST" class="row row-cols-1 g-3">
                        @csrf
                        <div class="col">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control"
                                placeholder="Masukkan username" required>
                        </div>
                        <div class="col">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" name="password" id="password" class="form-control"
                                placeholder="Masukkan password" required>
                        </div>
                        <div class="col d-flex align-items-center justify-content-between">
                            <div class="form-check">
                                <input type="checkbox" name="remember" id="remember" class="form-check-input"
                                    {{ old('remember') ? 'checked' : '' }}>
                                <label class="form-check-label" for="remember">Ingat Saya</label>
                            </div>
                        </div>
                        <div class="col mt-4">
                            <button type="submit" class="btn btn-primary w-100">Sign In</button>

                        </div>
                    </form>
                </div>

                <!-- [START] Footer -->
                <div class="container-fluid mt-auto bg-white border-top">
                    <footer
                        class="d-flex flex-column-reverse flex-lg-row flex-wrap justify-content-center justify-content-lg-between align-items-center py-1 py-md-3 gap-3">
                        <div class="d-flex gap-2 align-items-center">
                            <a href="#"
                                class="d-none d-md-block mb-md-0 text-body-secondary text-decoration-none lh-1">
                                <img src="data:image/webp;base64,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"
                                    class="w-auto" height="18" alt="Logo SEVIMA" />
                            </a>
                            <span class="mb-0 fs-7 text-body-tertiary">
                                © 2005-2023 SEVIMA. All Rights Reserved
                            </span>
                        </div>
                    </footer>
                </div>
                <!-- [END] Footer -->
            </div>
            <div class="d-none d-lg-block g-col-lg-6 p-4">
                <img class="w-100 h-100 object-fit-cover rounded-4" src="{{ asset('assets/images/foto-kantor.png') }}"
                    alt="" />
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        (function() {
            const maxIdle = 2 * 60 * 60 * 1000; // 2 jam dalam milidetik
            // const maxIdle = 0.05 * 60 * 1000; // 3 detik untuk testing
            let lastActive = Date.now();

            function resetIdle() {
                lastActive = Date.now();
            }

            // Reset saat ada aktivitas user
            window.onload = resetIdle;
            window.onmousemove = resetIdle;
            window.onkeydown = resetIdle;
            window.onscroll = resetIdle;
            window.onclick = resetIdle;

            // Saat kembali ke tab
            document.addEventListener('visibilitychange', function() {
                if (document.visibilityState === 'visible') {
                    const now = Date.now();
                    if (now - lastActive > maxIdle) {
                        location.reload(); // Langsung reload tanpa notif
                    } else {
                        resetIdle();
                    }
                }
            });

            // Cek berkala jika halaman didiamkan terlalu lama
            setInterval(function() {
                const now = Date.now();
                if (now - lastActive > maxIdle) {
                    location.reload(); // Langsung reload tanpa notif
                }
            }, 60 * 1000); // Cek setiap 1 menit

        })();
    </script>

</body>

</html>
