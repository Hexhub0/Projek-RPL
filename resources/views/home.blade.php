<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Beranda Coffee</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <script src="{{ asset('js/app.js') }}" async></script>
  </head>
  <body>
    <!-- Navbar -->
    <nav class="navbar" x-data>
      <a href="/home" class="navbar-logo">Beranda<span>Coffee</span>.</a>

      <div class="navbar-nav">
        <a href="/home">Beranda</a>
        <a href="#about">Tentang Kami</a>
        <a href="/menu">Menu</a>
        <a href="/produk">Produk Kami</a>
        <a href="#contact">Kontak</a>
      </div>

      <div class="navbar-extra">
        <!-- Profile Button -->
        <div class="profile-dropdown">
          <button class="profile-btn" id="profile-button">
            <i data-feather="user"></i>
          </button>
          <div class="profile-dropdown-content" id="profile-dropdown">
            <div class="profile-actions">
              <!-- Hanya logout yang tersisa -->
              <a href="/" class="profile-action-item logout" id="logout-btn">
                <i data-feather="log-out"></i>
                <span>Log Out</span>
              </a>
            </div>
          </div>
        </div>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>
    </nav>
    <!-- Navbar end -->

    <!-- Hero Section start -->
    <section class="hero" id="home">
      <main class="content">
        <h1>Mari Nikmati<span> Secangkir Kopi</span></h1>
        <p>
          Apapun suasana hati Kamu, kopi kami selalu siap menemani hari-hari mu
          dengan rasa yang tak terlupakan, dan cinta rasa di setiap tegukan nya.
        </p>
        <a href="/menu" class="cta-button">
          <span>Lihat Menu</span>
          <i data-feather="arrow-right"></i>
        </a>
      </main>
    </section>
    <!-- Hero Section end -->

    <!-- About Section start -->
    <section id="about" class="about">
      <h2><span>Tentang</span> Kami</h2>

      <div class="row">
        <div class="about-img">
          <img src="{{ asset('img/tentang-kami.jpg') }}" alt="Tentang kami" />
        </div>
        <div class="content">
          <h3>Kenapa Memilih Kopi Kami?</h3>
          <p>
            Harga kaki lima kualitas bintang lima dengan rasa yang bisa
            menggunggah selera, membuat kopi kami menjadi pilihan utama bagi
            para pecinta kopi.
          </p>
          <p>
            Dibuat dengan menggunakan biji kopi pilihan yang diolah dengan
            teknik terbaik, dengan sentuhan cinta dan dedikasi, membuat kopi
            kami memiliki cita rasa yang unik dan memikat. Kami percaya bahwa
            setiap tegukan kopi kami memberikan pengalaman yang tak terlupakan.
          </p>
        </div>
      </div>
    </section>
    <!-- About Section end -->

    <!-- Promo Banner Section start -->
    <section class="promo-banner">
      <div class="promo-container">
        <div class="promo-badge">
          <i data-feather="zap"></i>
          <span>Promo Spesial</span>
        </div>
        <h2>Diskon 20% Untuk Semua Menu Kopi!</h2>
        <p>Berlaku setiap hari Senin - Jumat pukul 10.00 - 14.00</p>
        <a href="/menu" class="promo-btn">
          <span>Pesan Sekarang</span>
          <i data-feather="shopping-cart"></i>
        </a>
      </div>
    </section>
    <!-- Promo Banner Section end -->

    <!-- Featured Menu Section start -->
    <section class="featured-menu">
      <div class="section-header">
        <h2>Menu <span>Terpopuler</span> Kami</h2>
        <p>Pilihan terbaik yang paling disukai oleh pelanggan kami</p>
      </div>

      <div class="featured-grid">
        <!-- Featured Item 1 -->
        <div class="featured-card">
          <div class="featured-image">
            <img src="{{ asset('img/menu/1.jpg') }}" alt="Espresso" />
            <div class="featured-badge">Best Seller</div>
            <div class="featured-overlay">
              <a href="/menu" class="overlay-btn">
                <i data-feather="eye"></i>
                <span>Lihat Detail</span>
              </a>
            </div>
          </div>
          <div class="featured-content">
            <h3>Espresso</h3>
            <div class="featured-rating">
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <span>(4.9)</span>
            </div>
            <p>Kopi murni dengan rasa kuat dan aroma yang khas</p>
            <div class="featured-footer">
              <span class="featured-price">Rp 15.000</span>
              <a href="/menu" class="order-btn">Pesan</a>
            </div>
          </div>
        </div>
        <!-- Featured Item 2 -->
        <div class="featured-card">
          <div class="featured-image">
            <img src="{{ asset('img/menu/2.jpg') }}" alt="Latte" />
            <div class="featured-badge popular">Popular</div>
            <div class="featured-overlay">
              <a href="/menu" class="overlay-btn">
                <i data-feather="eye"></i>
                <span>Lihat Detail</span>
              </a>
            </div>
          </div>
          <div class="featured-content">
            <h3>Latte Coffee</h3>
            <div class="featured-rating">
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <span>(4.8)</span>
            </div>
            <p>Perpaduan sempurna espresso dan susu steamed</p>
            <div class="featured-footer">
              <span class="featured-price">Rp 20.000</span>
              <a href="/menu" class="order-btn">Pesan</a>
            </div>
          </div>
        </div>
        <!-- Featured Item 3 -->
        <div class="featured-card">
          <div class="featured-image">
            <img src="{{ asset('img/menu/3.jpg') }}" alt="Matcha" />
            <div class="featured-badge new">New</div>
            <div class="featured-overlay">
              <a href="/menu" class="overlay-btn">
                <i data-feather="eye"></i>
                <span>Lihat Detail</span>
              </a>
            </div>
          </div>
          <div class="featured-content">
            <h3>Matcha Coffee</h3>
            <div class="featured-rating">
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <i data-feather="star" class="star-filled"></i>
              <span>(4.7)</span>
            </div>
            <p>Kombinasi unik matcha premium dengan kopi</p>
            <div class="featured-footer">
              <span class="featured-price">Rp 25.000</span>
              <a href="/menu" class="order-btn">Pesan</a>
            </div>
          </div>
        </div>
      </div>

      <div class="view-all-container">
        <a href="/menu" class="view-all-btn">
          <span>Lihat Semua Menu</span>
          <i data-feather="arrow-right"></i>
        </a>
      </div>
    </section>
    <!-- Featured Menu Section end -->

    <!-- Categories Showcase start -->
    <section class="categories-showcase">
      <div class="section-header">
        <span class="section-tag">Kategori Menu</span>
        <h2>Jelajahi <span>Kategori</span> Kami</h2>
        <p>Temukan berbagai pilihan menu sesuai selera Anda</p>
      </div>

      <div class="categories-grid">
        <div class="category-card coffee">
          <div class="category-icon">
            <i data-feather="coffee"></i>
          </div>
          <h3>Kopi</h3>
          <p>15+ Varian Kopi</p>
          <span class="category-desc"
            >Dari espresso hingga specialty coffee</span
          >
          <!-- Link dengan parameter category=coffee -->
          <a href="/menu?category=coffee" class="category-card">
            <h3>Kopi</h3>
          </a>
        </div>
        <div class="category-card snack">
          <div class="category-icon">
            <i data-feather="package"></i>
          </div>
          <h3>Snack</h3>
          <p>10+ Pilihan Snack</p>
          <span class="category-desc">Camilan lezat teman ngopi</span>
          <!-- Link dengan parameter category=snack -->
          <a href="/menu?category=snack" class="category-card">
            <h3>Snack</h3>
          </a>
        </div>
        <div class="category-card dessert">
          <div class="category-icon">
            <i data-feather="award"></i>
          </div>
          <h3>Dessert</h3>
          <p>8+ Dessert Premium</p>
          <span class="category-desc">Penutup manis yang sempurna</span>
          <!-- Link dengan parameter category=dessert -->
          <a href="/menu?category=dessert" class="category-card">
            <h3>Dessert</h3>
          </a>
        </div>
      </div>
    </section>
    <!-- Categories Showcase end -->

    <!-- Special Offer Section start -->
    <section class="special-offer">
      <div class="offer-content">
        <div class="offer-left">
          <span class="offer-tag">Penawaran Terbatas</span>
          <h2>Paket Hemat Coffee & Snack</h2>
          <p>Dapatkan 1 kopi pilihan + 1 snack favorit dengan harga spesial!</p>
          <div class="offer-features">
            <div class="feature-item">
              <i data-feather="check-circle"></i>
              <span>Hemat hingga Rp 10.000</span>
            </div>
            <div class="feature-item">
              <i data-feather="check-circle"></i>
              <span>Bisa pilih semua menu</span>
            </div>
            <div class="feature-item">
              <i data-feather="check-circle"></i>
              <span>Berlaku setiap hari</span>
            </div>
          </div>
          <div class="offer-price">
            <span class="old-price">Rp 35.000</span>
            <span class="new-price">Rp 25.000</span>
          </div>
          <a href="/menu" class="offer-cta">
            <span>Ambil Penawaran</span>
            <i data-feather="arrow-right"></i>
          </a>
        </div>
        <div class="offer-right">
          <div class="offer-image">
            <img src="img/menu/4.jpg" alt="Special Offer" />
            <div class="offer-floating-badge">
              <span class="discount">-22%</span>
              <span class="label">OFF</span>
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- Special Offer Section end -->

    <!-- Contact Section start -->
    <section id="contact" class="contact">
      <h2><span>Kontak</span> Kami</h2>
      <p>
        Saran dan kritik dari Anda sangat berarti bagi kami untuk meningkatkan
        layanan dan produk kami. Jangan ragu untuk menghubungi kami melalui form
        di bawah ini.
      </p>

      <div class="row">
        <div class="contact-container">
          <div class="form-container">
            <h3>Kirim Ulasan</h3>
            <form action="" id="ulasanForm">
              <div class="input-group">
                <i data-feather="user"></i>
                <input
                  type="text"
                  placeholder="Nama Lengkap"
                  id="ulasanName"
                  required
                />
                <span class="input-focus"></span>
              </div>
              <div class="input-group">
                <i data-feather="mail"></i>
                <input
                  type="email"
                  placeholder="Email"
                  id="ulasanEmail"
                  required
                />
                <span class="input-focus"></span>
              </div>
              <div class="input-group-3">
                <i data-feather="message-square"></i>
                <textarea
                  placeholder="Kirim Ulasan Anda Di Sini"
                  id="ulasanText"
                  required
                ></textarea>
                <span class="input-focus"></span>
              </div>
              <button type="submit" class="btn" id="btnUlasan">
                <i data-feather="send"></i>
                Kirim Ulasan
              </button>
            </form>
          </div>
          <div class="map-container">
            <iframe
              src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3957.184885024379!2d112.71637438561984!3d-7.333122273329611!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2dd7fb7aa0e99023%3A0xc98468576e20f7fc!2sBeranda%20Kita%20(Kos%20dan%20Kedai%20Kopi)!5e0!3m2!1sid!2sid!4v1763293534996!5m2!1sid!2sid"
              width="100%"
              height="100%"
              style="border: 0"
              allowfullscreen=""
              loading="lazy"
              referrerpolicy="no-referrer-when-downgrade"
              class="map"
            ></iframe>
          </div>
        </div>
      </div>
    </section>
    <!-- Contact Section end -->

    <!-- Footer start -->
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
            <li><a href="#home">Beranda</a></li>
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="/menu">Menu</a></li>
            <li><a href="/products">Produk Kami</a></li>
            <li><a href="#contact">Kontak</a></li>
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
    <!-- Footer end -->

    <script>
      feather.replace();

      // Script sederhana untuk filter otomatis
      document.addEventListener("DOMContentLoaded", function () {
        // Fungsi baca parameter URL
        function getParameterByName(name) {
          const url = window.location.href;
          name = name.replace(/[\[\]]/g, "\\$&");
          const regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)");
          const results = regex.exec(url);
          if (!results) return null;
          if (!results[2]) return "";
          return decodeURIComponent(results[2].replace(/\+/g, " "));
        }

        // Ambil parameter category
        const category = getParameterByName("category");

        if (category && ["coffee", "snack", "dessert"].includes(category)) {
          console.log("Auto-filter category:", category);

          // Klik button kategori yang sesuai
          setTimeout(() => {
            const categoryBtn = document.querySelector(
              `.category-btn[onclick*="selectedCategory = '${category}'"]`
            );
            if (categoryBtn) {
              categoryBtn.click();
              console.log("Category button clicked:", category);
            }

            // Scroll ke section menu
            const menuSection = document.getElementById("menu");
            if (menuSection) {
              setTimeout(() => {
                menuSection.scrollIntoView({ behavior: "smooth" });
              }, 100);
            }
          }, 500);
        }
      });
    </script>

    <!-- My Javascript -->
    <script src="js/script.js"></script>
    <!-- DeepSeek AI Chat Widget -->
    @include('components.chat-widget')
  </body>
</html>
