<!doctype html>
<html lang="id">
<x-head></x-head>

<body>
    <main>
        <div class="container d-flex min-vh-100">
            <div class="w-100 m-auto py-5" style="max-width: 26.75rem;">

                {{-- Alert Message --}}
                @if(session('status'))
                <div class="alert alert-success alert-dismissible fade show d-flex gap-2" role="alert">
                    <i class="sym sym-check-circle-solid"></i>
                    <div class="d-block">
                        {{ session('status') }}
                    </div>
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show d-flex gap-2" role="alert">
                    <i class="sym sym-x-circle-solid"></i>
                    <div class="d-block">
                        <h6 class="alert-heading mb-1">Terjadi Kesalahan!</h6>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                @endif

                {{-- Logo + Heading --}}
                <div class="d-flex align-items-center justify-content-center gap-3 pb-5">
                    <div style="max-width: 2.75rem;">
                        <img class="w-100 h-100 object-fit-contain" src="{{ asset('assets/images/logo-sevima.png') }}" alt="Logo Kampus">
                    </div>
                    <hr class="vr align-self-stretch my-1" />
                    <h1 class="fs-6 fw-semibold m-0">SEVIMA ITAM</h1>
                </div>

                <h2 class="fs-4 fw-semibold mb-2 text-center">Konfirmasi Password</h2>
                <p class="text-body-secondary mb-4 text-center">
                    @if(session('password_confirmation.intended_url') || session('url.intended'))
                        Untuk keamanan, silakan konfirmasi password Anda sebelum melanjutkan aksi ini.
                    @else
                        Untuk keamanan, silakan konfirmasi password Anda sebelum melanjutkan.
                    @endif
                </p>

                {{-- Form --}}
                <form action="{{ route('password.confirm') }}" method="POST" class="row row-cols-1 g-3">
                    @csrf

                    <div class="col">
                        <label for="password" class="form-label">Password</label>
                        <input type="password"
                               name="password"
                               id="password"
                               class="form-control @error('password') is-invalid @enderror"
                               placeholder="Masukkan password Anda"
                               required
                               autofocus>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="col mt-4">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="sym sym-check me-2"></i>
                            Konfirmasi Password
                        </button>
                    </div>

                    <div class="col text-center">
                        <a href="#" onclick="history.back(); return false;" class="btn btn-link text-decoration-none">
                            <i class="sym sym-arrow-left me-2"></i>
                            Kembali
                        </a>
                    </div>
                </form>

                {{-- Info --}}
                <div class="mt-4 p-3 bg-light rounded">
                    <div class="d-flex gap-2">
                        <i class="sym sym-info-circle text-primary"></i>
                        <div class="small text-muted">
                            <strong>Mengapa diminta konfirmasi password?</strong><br>
                            Fitur ini memerlukan konfirmasi ulang password untuk menjaga keamanan data Anda.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Auto focus pada input password
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            if (passwordInput) {
                passwordInput.focus();
            }
        });

        // Session timeout handler (sama seperti login page)
        (function () {
            const maxIdle = 2 * 60 * 60 * 1000; // 2 jam dalam milidetik
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
            document.addEventListener('visibilitychange', function () {
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
            setInterval(function () {
                const now = Date.now();
                if (now - lastActive > maxIdle) {
                    location.reload(); // Langsung reload tanpa notif
                }
            }, 60 * 1000); // Cek setiap 1 menit

        })();
    </script>

</body>
</html>
