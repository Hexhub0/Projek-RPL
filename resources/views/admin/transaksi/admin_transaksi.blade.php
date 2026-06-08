<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>History Transaksi - Beranda Coffee Admin</title>
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
                        <a href="/admin">
                            <i class="fas fa-tachometer-alt"></i> Dashboard
                        </a>
                    </li>
                    <li>
                        <a href="/admin/transaksi" class="active">
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
            <!-- Header -->
            <div class="dashboard-header">
                <h1><i class="fas fa-history"></i> History Transaksi</h1>
                <p>Lihat dan kelola semua riwayat transaksi pelanggan</p>
                <div class="current-time">
                    <i class="fas fa-calendar-alt"></i>
                    <span id="currentDateTime"></span>
                </div>
            </div>

            <!-- Alert Container -->
            <div id="alertContainer"></div>

            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-row">
                    <div class="filter-group">
                        <div class="filter-item">
                            <label for="startDate"><i class="fas fa-calendar"></i> Dari Tanggal</label>
                            <input type="date" id="startDate" class="filter-input">
                        </div>
                        <div class="filter-item">
                            <label for="endDate"><i class="fas fa-calendar"></i> Sampai Tanggal</label>
                            <input type="date" id="endDate" class="filter-input">
                        </div>
                        <div class="filter-item">
                            <label for="statusFilter"><i class="fas fa-filter"></i> Status</label>
                            <select id="statusFilter" class="filter-select">
                                <option value="all">Semua Status</option>
                                <option value="pending">Pending</option>
                                <option value="approved">Disetujui</option>
                                <option value="rejected">Ditolak</option>
                                <option value="completed">Selesai</option>
                                <option value="cancelled">Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                    
                    <div class="search-group">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" id="searchInput" placeholder="Cari ID transaksi">
                        </div>
                        <button class="btn-search" onclick="applyFilters()">
                            <i class="fas fa-filter"></i> Filter
                        </button>
                        <button class="btn-reset" onclick="resetFilters()">
                            <i class="fas fa-redo"></i> Reset
                        </button>
                    </div>
                </div>
            </div>

            <!-- Transaction Content -->
            <div class="transaction-content" id="transactionContent">
                <!-- Data akan dimuat di sini oleh JavaScript -->
                <div class="loading-state">
                    <div class="loading-spinner">
                        <i class="fas fa-coffee"></i>
                    </div>
                    <p>Memuat data transaksi...</p>
                </div>
            </div>

            <!-- Pagination -->
            <div class="pagination" id="pagination" style="display: none;">
                <button class="pagination-btn" id="prevBtn" onclick="changePage(-1)" disabled>
                    <i class="fas fa-chevron-left"></i> Sebelumnya
                </button>
                <div class="page-info">
                    Halaman <span id="currentPage">1</span> dari <span id="totalPages">1</span>
                </div>
                <button class="pagination-btn" id="nextBtn" onclick="changePage(1)" disabled>
                    Selanjutnya <i class="fas fa-chevron-right"></i>
                </button>
            </div>

            <!-- Export Options -->
            <div class="export-section">
                <button class="btn-print" onclick="printReport()">
                    <i class="fas fa-print"></i> Cetak Laporan
                </button>
            </div>
        </main>
    </div>

    <!-- Modal Detail Transaksi -->
    <div id="detailModal" class="modal" style="display: none;">
        <div class="modal-content detail-modal">
            <div class="modal-header">
                <h3><i class="fas fa-receipt"></i> Detail Transaksi</h3>
                <button class="modal-close" onclick="closeDetailModal()">&times;</button>
            </div>
            <div class="modal-body">
                <div id="detailContent">
                    <!-- Detail akan dimuat di sini -->
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn-print-invoice" onclick="printInvoice()">
                    <i class="fas fa-print"></i> Cetak Invoice
                </button>
                <button class="btn-close" onclick="closeDetailModal()">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}"></script>
</body>
</html>