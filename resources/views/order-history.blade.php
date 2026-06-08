<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Riwayat Pesanan - Beranda Coffee</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <!-- My Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Alpine JS -->
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    <!-- App -->
    <script src="js/app.js" async></script>

    <style>
      .history-page {
        padding-top: 10rem;
        min-height: 100vh;
        background: linear-gradient(135deg, #f8f4f0 0%, #ede5dd 100%);
        padding-bottom: 4rem;
      }

      .history-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 0 7%;
      }

      .history-header {
        text-align: center;
        margin-bottom: 3rem;
      }

      .history-header h1 {
        font-size: 3rem;
        color: #2c1810;
        margin-bottom: 1rem;
      }

      .history-header p {
        font-size: 1.2rem;
        color: #666;
      }

      .filter-tabs {
        display: flex;
        gap: 1rem;
        justify-content: center;
        margin-bottom: 3rem;
        flex-wrap: wrap;
      }

      .filter-tab {
        padding: 0.8rem 2rem;
        background: white;
        border: 2px solid #e0e0e0;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-weight: 600;
        color: #666;
      }

      .filter-tab:hover {
        border-color: var(--primary);
        color: var(--primary);
      }

      .filter-tab.active {
        background: linear-gradient(135deg, var(--primary) 0%, #a67a50 100%);
        color: white;
        border-color: var(--primary);
      }

      .order-list {
        display: grid;
        gap: 2rem;
      }

      .order-card {
        background: white;
        border-radius: 20px;
        padding: 2rem;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.3s ease;
      }

      .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 35px rgba(0, 0, 0, 0.15);
      }

      .order-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #f0f0f0;
        margin-bottom: 1.5rem;
      }

      .order-number {
        font-size: 1.5rem;
        font-weight: 800;
        color: var(--primary);
      }

      .order-status {
        padding: 0.5rem 1.5rem;
        border-radius: 20px;
        font-weight: 700;
        font-size: 0.9rem;
      }

      .status-pending {
        background: #fff3cd;
        color: #856404;
      }

      .status-completed {
        background: #d1e7dd;
        color: #0f5132;
      }

      .status-cancelled {
        background: #f8d7da;
        color: #842029;
      }

      .order-info {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
        margin-bottom: 1.5rem;
      }

      .info-item {
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .info-item i {
        width: 18px;
        height: 18px;
        color: var(--primary);
      }

      .info-label {
        color: #666;
        font-size: 0.9rem;
      }

      .info-value {
        color: #2c1810;
        font-weight: 600;
        margin-left: 0.3rem;
      }

      .order-items {
        background: #f9f9f9;
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 1.5rem;
      }

      .order-items h4 {
        font-size: 1.2rem;
        color: #2c1810;
        margin-bottom: 1rem;
      }

      .item-row {
        display: flex;
        justify-content: space-between;
        padding: 0.5rem 0;
        border-bottom: 1px dashed #e0e0e0;
      }

      .item-row:last-child {
        border-bottom: none;
      }

      .item-name {
        font-weight: 600;
        color: #2c1810;
      }

      .item-qty {
        color: #666;
        margin: 0 1rem;
      }

      .item-price {
        color: var(--primary);
        font-weight: 700;
      }

      .order-total {
        display: flex;
        justify-content: space-between;
        padding: 1rem;
        background: rgba(182, 137, 91, 0.1);
        border-radius: 10px;
        margin-bottom: 1.5rem;
      }

      .total-label {
        font-size: 1.2rem;
        font-weight: 700;
        color: #2c1810;
      }

      .total-value {
        font-size: 1.4rem;
        font-weight: 800;
        color: var(--primary);
      }

      .order-actions {
        display: flex;
        gap: 1rem;
        justify-content: flex-end;
      }

      .action-btn {
        padding: 0.7rem 1.5rem;
        border: none;
        border-radius: 25px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
      }

      .btn-view {
        background: linear-gradient(135deg, var(--primary) 0%, #a67a50 100%);
        color: white;
      }

      .btn-view:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(182, 137, 91, 0.4);
      }

      .btn-delete {
        background: #e74c3c;
        color: white;
      }

      .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(231, 76, 60, 0.4);
      }

      .empty-state {
        text-align: center;
        padding: 4rem 2rem;
      }

      .empty-state i {
        width: 80px;
        height: 80px;
        color: #ccc;
        margin-bottom: 1rem;
      }

      .empty-state h3 {
        font-size: 2rem;
        color: #2c1810;
        margin-bottom: 1rem;
      }

      .empty-state p {
        font-size: 1.2rem;
        color: #666;
        margin-bottom: 2rem;
      }

      .empty-state a {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 1rem 2rem;
        background: var(--primary);
        color: white;
        border-radius: 30px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
      }

      .empty-state a:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(182, 137, 91, 0.4);
      }

      .clear-history-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.8rem 2rem;
        background: #e74c3c;
        color: white;
        border: none;
        border-radius: 30px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
        margin-bottom: 2rem;
      }

      .clear-history-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(231, 76, 60, 0.4);
      }

      @media (max-width: 768px) {
        .history-page {
          padding-top: 8rem;
        }

        .history-header h1 {
          font-size: 2.2rem;
        }

        .order-info {
          grid-template-columns: 1fr;
        }

        .order-actions {
          flex-direction: column;
        }

        .action-btn {
          width: 100%;
          justify-content: center;
        }
      }
    </style>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar" x-data>
      <a href="/home" class="navbar-logo">Beranda<span>Coffee</span>.</a>

      <div class="navbar-nav">
        <a href="/home">Beranda</a>
        <a href="/menu">Menu</a>
        <a href="/produk">Produk Kami</a>
        <a href="/order">Riwayat Pesanan</a>
      </div>

      <div class="navbar-extra">
        <a href="/checkout" id="shopping-cart-button">
          <i data-feather="shopping-cart"></i>
          <span
            class="quantity-badge"
            x-show="$store.cart.quantity"
            x-text="$store.cart.quantity"
          ></span>
        </a>
        <!-- Profile Button -->
        <div class="profile-dropdown">
          <button class="profile-btn" id="profile-button">
            <i data-feather="user"></i>
          </button>
          <div class="profile-dropdown-content" id="profile-dropdown">
            <div class="profile-actions">
              <a href="/" class="profile-action-item logout" id="logout-btn">
                <i data-feather="log-out"></i>
                <span>Log Out</span>
              </a>
            </div>
          </div>
        </div>
        <a href="/" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>

    <!-- History Page -->
    <section class="history-page" x-data="orderHistoryData()">
      <div class="history-container">
        <div class="history-header">
          <h1>Riwayat Pesanan</h1>
          <p>Lihat semua pesanan yang telah Anda pesan</p>
        </div>

        <!-- Filter Tabs -->
        <div class="filter-tabs">
          <button
            class="filter-tab"
            :class="{ 'active': filterStatus === 'all' }"
            @click="filterStatus = 'all'"
          >
            Semua Pesanan
          </button>
          <button
            class="filter-tab"
            :class="{ 'active': filterStatus === 'Pending' }"
            @click="filterStatus = 'Pending'"
          >
            Pending
          </button>
          <button
            class="filter-tab"
            :class="{ 'active': filterStatus === 'Completed' }"
            @click="filterStatus = 'Completed'"
          >
            Selesai
          </button>
        </div>
        <!-- Clear History Button -->
        <div style="text-align: center" x-show="orders.length > 0">
          <button class="clear-history-btn" @click="clearAllHistory()">
            <i data-feather="trash-2"></i>
            <span>Hapus Semua Riwayat</span>
          </button>
        </div>
        <!-- Order List -->
        <div class="order-list" x-show="filteredOrders.length > 0">
          <template x-for="order in filteredOrders" :key="order.orderNumber">
            <div class="order-card">
              <div class="order-header">
                <div class="order-number" x-text="order.orderNumber"></div>
                <div
                  class="order-status"
                  :class="`status-${order.status.toLowerCase()}`"
                  x-text="order.status"
                ></div>
              </div>

              <div class="order-info">
                <div class="info-item">
                  <i data-feather="calendar"></i>
                  <span class="info-label">Tanggal:</span>
                  <span class="info-value" x-text="order.date"></span>
                </div>
                <div class="info-item">
                  <i data-feather="clock"></i>
                  <span class="info-label">Waktu:</span>
                  <span class="info-value" x-text="order.time"></span>
                </div>
                <div class="info-item">
                  <i data-feather="user"></i>
                  <span class="info-label">Nama:</span>
                  <span class="info-value" x-text="order.customerName"></span>
                </div>
                <div class="info-item">
                  <i data-feather="hash"></i>
                  <span class="info-label">Meja:</span>
                  <span class="info-value" x-text="order.tableNumber"></span>
                </div>
                <div class="info-item">
                  <i data-feather="credit-card"></i>
                  <span class="info-label">Pembayaran:</span>
                  <span class="info-value" x-text="order.paymentMethod"></span>
                </div>
              </div>

              <div class="order-items">
                <h4>Item Pesanan</h4>
                <template x-for="item in order.items" :key="item.name">
                  <div class="item-row">
                    <span class="item-name" x-text="item.name"></span>
                    <span class="item-qty" x-text="item.qty"></span>
                    <span class="item-price" x-text="item.price"></span>
                  </div>
                </template>
              </div>

              <div class="order-total">
                <span class="total-label">Total Pembayaran:</span>
                <span class="total-value" x-text="order.total"></span>
              </div>

              <div class="order-actions">
                <button
                  class="action-btn btn-view"
                  @click="viewOrderDetail(order)"
                >
                  <i data-feather="eye"></i>
                  <span>Lihat Detail</span>
                </button>
                <button
                  class="action-btn btn-delete"
                  @click="deleteOrder(order.orderNumber)"
                >
                  <i data-feather="trash-2"></i>
                  <span>Hapus</span>
                </button>
              </div>
            </div>
          </template>
        </div>
        <!-- Empty State -->
        <div class="empty-state" x-show="filteredOrders.length === 0">
          <i data-feather="inbox"></i>
          <h3>Belum Ada Riwayat</h3>
          <p>Anda belum memiliki riwayat pesanan</p>
          <a href="/menu">
            <i data-feather="coffee"></i>
            <span>Mulai Pesan</span>
          </a>
        </div>
      </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
      <div class="footer-container">
        <div class="footer-col">
          <h3>Tentang Kami</h3>
          <p>
            Kami adalah penyedia kopi premium dengan cita rasa terbaik. Nikmati
            pengalaman kopi mu yang berbeda di setiap harinya.
          </p>
        </div>
        <div class="footer-col">
          <h3>Link</h3>
          <ul>
            <li><a href="/home">Beranda</a></li>
            <li><a href="/home#about">Tentang Kami</a></li>
            <li><a href="/menu">Menu</a></li>
            <li><a href="/produk">Produk Kami</a></li>
            <li><a href="/order">Riwayat Pesanan</a></li>
            <li><a href="/home#contact">Kontak</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h3>Coffee Blogs</h3>
          <ul>
            <li><a href="https://coffeeland.co.id/">Coffee Land</a></li>
            <li>
              <a
                href="https://ottencoffee.co.id/brands/otten-coffee?categoryIds=%5B382%5D&page=1&msclkid=3ec953538edf1f658bef3a1a20752ed1"
                >Otten Coffee</a
              >
            </li>
            <li><a href="https://www.baristahustle.com/">Barista Hustle</a></li>
            <li><a href="https://sprudge.com/">Sprudge</a></li>
          </ul>
        </div>
        <div class="footer-col">
          <h3>Hubungi Kami</h3>
          <p>Email: Berandacoffee@gmail.com</p>
          <p>Phone: +62 812-3456-7890</p>
          <div class="footer-social">
            <a href="#"><i data-feather="instagram"></i></a>
            <a href="#"><i data-feather="facebook"></i></a>
            <a href="#"><i data-feather="twitter"></i></a>
          </div>
        </div>
      </div>
      <div class="footer-bottom">
        <p>© 2025 BerandaCoffee. All Rights Reserved.</p>
      </div>
    </footer>

    <script>
      function orderHistoryData() {
        return {
          orders: [],
          filterStatus: "all",

          init() {
            this.loadOrderHistory();
          },

          loadOrderHistory() {
            const history = localStorage.getItem("berandaCoffeeOrderHistory");
            this.orders = history ? JSON.parse(history) : [];
          },

          get filteredOrders() {
            if (this.filterStatus === "all") {
              return this.orders;
            }
            return this.orders.filter(
              (order) => order.status === this.filterStatus
            );
          },

          viewOrderDetail(order) {
            alert(
              `Detail Pesanan ${order.orderNumber}\n\nTotal: ${order.total}\nStatus: ${order.status}`
            );
            // Bisa ditambahkan modal untuk menampilkan detail lengkap
          },

          deleteOrder(orderNumber) {
            if (confirm("Apakah Anda yakin ingin menghapus pesanan ini?")) {
              this.orders = this.orders.filter(
                (order) => order.orderNumber !== orderNumber
              );
              localStorage.setItem(
                "berandaCoffeeOrderHistory",
                JSON.stringify(this.orders)
              );
            }
          },

          clearAllHistory() {
            if (
              confirm(
                "Apakah Anda yakin ingin menghapus semua riwayat pesanan?"
              )
            ) {
              this.orders = [];
              localStorage.removeItem("berandaCoffeeOrderHistory");
            }
          },
        };
      }

      // Initialize feather icons
      document.addEventListener("DOMContentLoaded", function () {
        if (typeof feather !== "undefined") {
          feather.replace();
        }
      });
    </script>

    <script src="js/script.js"></script>
  </body>
</html>
