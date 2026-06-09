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

const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

let currentRejectId = null;

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

function openRejectModal(id) {
    currentRejectId = id;
    document.getElementById('rejectModal').style.display = 'flex';
}

function closeRejectModal() {
    currentRejectId = null;
    document.getElementById('rejectReason').value = '';
    document.getElementById('rejectModal').style.display = 'none';
}

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

function checkEmptyState() {
    const tableRows = document.querySelectorAll('.pending-table tbody tr');
    
    if (tableRows.length === 0) {
        renderEmptyState();
    }
}

function formatCurrency(amount) {
    return amount.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

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

document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.mobile-menu-toggle');
    const sidebar = document.querySelector('.sidebar');
    
    if (menuToggle && sidebar) {
        menuToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    updateDateTime();
    setInterval(updateDateTime, 1000);
    
    loadPurchases();
    
    setInterval(loadPurchases, 30000);
    
    window.addEventListener('click', function(event) {
        const modal = document.getElementById('rejectModal');
        if (event.target === modal) {
            closeRejectModal();
        }
    });
});

