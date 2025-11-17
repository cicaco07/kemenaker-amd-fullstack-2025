<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Klinik Hewan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        .sidebar {
            min-height: 100vh;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            margin: 5px 10px;
            border-radius: 8px;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover, .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.15);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .stat-card-2 {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .stat-card-3 {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .stat-card-4 {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            color: white;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-2 p-0 sidebar">
                <div class="p-4 text-center">
                    <h4 class="text-white mb-0"><i class="bi bi-hospital"></i> Klinik Hewan</h4>
                </div>
                <nav class="nav flex-column">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i> Dashboard
                    </a>
                    <a class="nav-link {{ request()->routeIs('owners.*') ? 'active' : '' }}" href="{{ route('owners.index') }}">
                        <i class="bi bi-people"></i> Data Pemilik
                    </a>
                    <a class="nav-link {{ request()->routeIs('pets.*') ? 'active' : '' }}" href="{{ route('pets.index') }}">
                        <i class="bi bi-heart"></i> Data Hewan
                    </a>
                    <a class="nav-link {{ request()->routeIs('checkups.*') ? 'active' : '' }}" href="{{ route('checkups.index') }}">
                        <i class="bi bi-clipboard2-pulse"></i> Data Pemeriksaan
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-10 p-4">
                <!-- Header -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h2 class="mb-0">@yield('header', 'Dashboard')</h2>
                    <div class="text-muted">
                        <i class="bi bi-calendar-event"></i> {{ date('d F Y') }}
                    </div>
                </div>

                <!-- Alert Messages -->
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                @endif

                <!-- Content -->
                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
