<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Beranda Coffee</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Playfair+Display:wght@400;500;600&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-mug-hot"></i> Beranda Coffee Admin</h2>
                <button class="mobile-menu-toggle">
                    <i class="fas fa-bars"></i>
                </button>
            </div>
            
            <nav class="sidebar-menu">
                <ul>
                    <li>
                        <a href="/admin" class="active">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/admin/transaksi">
                            <i class="fas fa-receipt"></i> History Transaksi
                        </a>
                    </li>
                </ul>
            </nav>
            
            <div class="sidebar-footer">
                <div class="admin-info">
                    <i class="fas fa-user-circle"></i>
                    <div>
                        <span class="admin-name">{{ Auth::user()->name ?? 'Super Admin' }}</span>
                    </div>
                </div>
                <a href="/" class="logout-btn">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Dashboard Header -->
            <div class="dashboard-header">
                <h1><i class="fas fa-clock"></i> Pembelian Menunggu Persetujuan</h1>
                <p>Kelola pembelian yang membutuhkan persetujuan</p>
                <div class="current-time">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentDateTime"></span>
                </div>
            </div>

            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <!-- Dashboard Content -->
            <div class="dashboard-content" id="dashboardContent">
                <!-- Data akan dimuat di sini oleh JavaScript -->
                <div class="loading-state">
                    <div class="loading-spinner">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <p>Memuat data pembelian...</p>
                </div>
            </div>
        </main>
    </div>

    <!-- Modal untuk alasan penolakan -->
    <div id="rejectModal" class="modal" style="display: none;">
        <div class="modal-content">
            <div class="modal-header">
                <h3><i class="fas fa-exclamation-triangle"></i> Alasan Penolakan</h3>
                <button class="modal-close" onclick="closeRejectModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Silakan berikan alasan penolakan transaksi:</p>
                <textarea id="rejectReason" placeholder="Masukkan alasan penolakan..." rows="4"></textarea>
            </div>
            <div class="modal-footer">
                <button class="btn-cancel" onclick="closeRejectModal()">Batal</button>
                <button class="btn-submit" onclick="submitRejection()">Kirim</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>