<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="your-meta-description">
    <meta name="keywords" content="your-meta-keywords">
    <meta name="author" content="type-author">

    <link rel="icon" href="{{ asset('assets/images/logo-sevima.png') }}" type="image/png">

    <!-- Stylesheets -->
    <link rel="stylesheet" href="/vendor/@quantum_web-3.0.0/dist/css/quantum.min.css">
    <link rel="stylesheet" href="/vendor/@quantum_symbols-1.0.0/symbols/font/quantum-symbols.min.css">

    <!-- Scripts -->
    <script src="/vendor/bootstrap-5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="/vendor/@quantum_web-3.0.0/dist/js/quantum.bundle.min.js"></script>

    <title>IT Asset Management | @yield('title')</title>

    <style>
        /* Reset & base setup */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            width: 100%;
            height: 100%;
            background-color: #f8f9fa; /* Ganti sesuai background yg kamu mau */
        }

        body {
            overflow: hidden; /* hilangkan scroll kalau tidak diperlukan */
        }

        .main-container {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            background-color: #f8f9fa; /* pastikan sama seperti body */
        }

        .content {
            flex: 1;
            padding: 20px;
        }

        footer {
            background-color: #333;
            color: white;
            text-align: center;
            padding: 10px;
        }

        /* Hapus padding default dari Bootstrap container */
        .container-fluid,
        .container {
            padding-left: 0 !important;
            padding-right: 0 !important;
        }
    </style>
</head>

<body>
    <div class="main-container">
        <div class="content">
            @yield('content')
        </div>


    </div>
</body>

</html>
