<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">Admin Panel</a>
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.layanan.index') }}">Layanan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.pesanan.index') }}">Pesanan</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.klaim.index') }}">Klaim Garansi</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.voucher.index') }}">Voucher</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('admin.notifikasi.index') }}">Notifikasi</a></li>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>
