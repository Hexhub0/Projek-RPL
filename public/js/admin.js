// Konfigurasi API endpoint
const API_CONFIG = {
    baseUrl: window.location.origin,
    endpoints: {
        pendingPurchases: '/admin/api/pending-purchases',
        approvePurchase: '/admin/api/approve-purchase',
        rejectPurchase: '/admin/api/reject-purchase',
        dashboardStats: '/admin/api/dashboard-stats',
        transactionHistory: '/admin/api/transaction-history',
        transactionDetail: '/admin/api/transaction-detail',
        logout: '/admin/api/logout'
    }
};

// CSRF Token untuk Laravel
const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

// State management
let currentRejectId = null;

// Fungsi untuk memuat data pembelian dari database
async function loadPurchases() {
    try {
        const response = await fetch(API_CONFIG.endpoints.pendingPurchases, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        });
        
        if (!response.ok) throw new Error('Network response was not ok');
        
        const result = await response.json();
        
        if (result.success) {
            renderPurchases(result.data);
        } else {
            showAlert('error', result.message || 'Gagal memuat data pembelian');
            renderEmptyState();
        }
    } catch (error) {
        console.error('Error loading purchases:', error);
        showAlert('error', 'Terjadi kesalahan saat memuat data');
        renderEmptyState();
    }
}

// Fungsi untuk merender data pembelian
function renderPurchases(purchases) {
    const dashboardContent = document.getElementById('dashboardContent');
    
    if (!purchases || purchases.length === 0) {
        renderEmptyState();
        return;
    }
    
    let tableHTML = `
        <div class="table-container">
            <table class="pending-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer</th>
                        <th>Tanggal</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
    `;

    purchases.forEach(purchase => {
        // Format items list
        const itemsList = purchase.items.map(item => 
            `${item.name} (${item.quantity}x)`
        ).join(', ');
        
        tableHTML += `
            <tr data-id="${purchase.id}">
                <td class="order-id">
                    <strong>${purchase.transaction_code}</strong><br>
                    <small>${purchase.time}</small>
                </td>
                <td class="customer-info">
                    <strong>${purchase.customer_name}</strong><br>
                    <small>${purchase.customer_phone}</small>
                </td>
                <td>${purchase.date}</td>
                <td class="total-amount">Rp ${formatCurrency(purchase.total)}</td>
                <td>
                    <span class="status-badge pending">
                        <i class="fas fa-clock"></i> Pending
                    </span>
                </td>
                <td class="action-buttons">
                    <button class="btn-approve" onclick="approvePurchase(${purchase.id})">
                        <i class="fas fa-check"></i> Approve
                    </button>
                    <button class="btn-reject" onclick="openRejectModal(${purchase.id})">
                        <i class="fas fa-times"></i> Reject
                    </button>
                </td>
            </tr>
        `;
    });

    tableHTML += `
                </tbody>
            </table>
            <div class="table-footer">
                <p>Total: <strong>${purchases.length}</strong> pembelian menunggu persetujuan</p>
                <button class="btn-refresh-table" onclick="loadPurchases()">
                    <i class="fas fa-sync-alt"></i> Refresh Data
                </button>
            </div>
        </div>
    `;

    dashboardContent.innerHTML = tableHTML;
}

// Fungsi untuk render empty state
function renderEmptyState() {
    const dashboardContent = document.getElementById('dashboardContent');
    dashboardContent.innerHTML = `
        <div class="empty-state">
            <div class="empty-icon">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <h3>Tidak ada pembelian yang menunggu persetujuan</h3>
            <p>Belum ada pesanan yang membutuhkan persetujuan. Silakan cek kembali nanti.</p>
            <button class="btn-refresh" onclick="loadPurchases()">
                <i class="fas fa-sync-alt"></i> Refresh
            </button>
        </div>
    `;
}

// Fungsi untuk approve pembelian
async function approvePurchase(id) {
    if (!confirm('Apakah Anda yakin ingin menyetujui pembelian ini?')) {
        return;
    }
    
    try {
        showAlert('info', 'Menyetujui pembelian...');
        
        const response = await fetch(`${API_CONFIG.endpoints.approvePurchase}/${id}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Remove row from table
            const row = document.querySelector(`tr[data-id="${id}"]`);
            if (row) {
                row.classList.add('fading');
                setTimeout(() => {
                    row.remove();
                    checkEmptyState();
                }, 300);
            }
            
            showAlert('success', result.message || 'Pembelian berhasil disetujui!');
        } else {
            showAlert('error', result.message || 'Gagal menyetujui pembelian');
        }
    } catch (error) {
        console.error('Error approving purchase:', error);
        showAlert('error', 'Terjadi kesalahan saat menyetujui pembelian');
    }
}

// Fungsi untuk membuka modal penolakan
function openRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectModal').style.display = 'flex';
}

// Fungsi untuk menutup modal penolakan
function closeRejectModal() {
    currentRejectId = null;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectModal').style.display = 'none';
}

// Fungsi untuk submit penolakan
async function submitRejection() {
    if (!currentRejectId) return;
    
    const reason = document.getElementById('rejectReason').value.trim();
    
    try {
        showAlert('info', 'Menolak pembelian...');
        
        const response = await fetch(`${API_CONFIG.endpoints.rejectPurchase}/${currentRejectId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ reason })
        });
        
        const result = await response.json();
        
        if (result.success) {
            // Remove row from table
            const row = document.querySelector(`tr[data-id="${currentRejectId}"]`);
            if (row) {
                row.classList.add('fading');
                setTimeout(() => {
                    row.remove();
                    checkEmptyState();
                }, 300);
            }
            
            showAlert('success', result.message || 'Pembelian berhasil ditolak!');
            closeRejectModal();
        } else {
            showAlert('error', result.message || 'Gagal menolak pembelian');
        }
    } catch (error) {
        console.error('Error rejecting purchase:', error);
        showAlert('error', 'Terjadi kesalahan saat menolak pembelian');
    }
}

// Fungsi untuk cek apakah tabel kosong
function checkEmptyState() {
    const tableRows = document.querySelectorAll('.pending-table tbody tr');
    
    if (tableRows.length === 0) {
        renderEmptyState();
    }
}

// Fungsi untuk format mata uang
function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Fungsi untuk update waktu
function updateDateTime() {
    const now = new Date();
    const options = { 
        weekday: 'long', 
        year: 'numeric', 
        month: 'long', 
        day: 'numeric',
        hour: '2-digit',
        minute: '2-digit',
        second: '2-digit'
    };
    const formattedDateTime = now.toLocaleDateString('id-ID', options);
    document.getElementById('currentDateTime').textContent = formattedDateTime;
}

// Fungsi untuk logout
async function logout() {
   function logout() {
    if (confirm('Apakah Anda yakin ingin logout?')) {
        fetch('/logout', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            }
        }).then(response => {
            if (response.redirected) {
                window.location.href = response.url;
            } else {
                window.location.href = '/login';
            }
        });
        }
    }
}

// Fungsi untuk menampilkan alert
function showAlert(type, message) {
    const container = document.getElementById('alertContainer');
    const alert = document.createElement('div');
    alert.className = `alert alert-${type} show`;
    alert.innerHTML = `
        <i class="fas fa-${type === 'success' ? 'check-circle' : 'exclamation-circle'}"></i>
        <span>${message}</span>
        <button class="alert-close" onclick="this.parentElement.remove()">&times;</button>
    `;
    
    container.appendChild(alert);
    
    setTimeout(() => {
        if (alert.parentNode) {
            alert.remove();
        }
    }, 3000);
}

// Initialize
document.addEventListener('DOMContentLoaded', function() {
    // Mobile menu toggle
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    // Update waktu
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    // Load data
    loadPurchases();
    
    // Auto refresh setiap 30 detik
    setInterval(loadPurchases, 30000);
    
    // Close modal when clicking outside
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target === modal) {
            closeRejectModal();
        }
    });
});

