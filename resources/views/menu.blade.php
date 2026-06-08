<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Menu - Beranda Coffee</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <svg xmlns="http://www.w3.org/2000/svg" style="display: none">
      <symbol id="heart" viewBox="0 0 24 24">
        <path
          d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"
        ></path>
      </symbol>
    </svg>

    <!-- My Style -->
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />

    <!-- Alpine JS -->
    <script
      defer
      src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"
    ></script>

    <!-- App -->
    <script src="js/app.js" async></script>
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
        <a href="#" id="search-button"><i data-feather="search"></i></a>
        <a href="#" id="shopping-cart-button"
          ><i data-feather="shopping-cart"></i
          ><span
            class="quantity-badge"
            x-show="$store.cart.quantity"
            x-text="$store.cart.quantity"
          ></span
        ></a>
        <!-- Profile Button -->
        <div class="profile-dropdown">
          <button class="profile-btn" id="profile-button">
            <i data-feather="user"></i>
          </button>
          <div class="profile-dropdown-content" id="profile-dropdown">
            <div class="profile-actions">
              <a href="#" class="profile-action-item logout" id="logout-btn">
                <i data-feather="log-out"></i>
                <span>Log Out</span>
              </a>
            </div>
          </div>
        </div>
        <a href="#" id="hamburger-menu"><i data-feather="menu"></i></a>
      </div>

      <!-- Search Form start -->
      <div class="search-form">
        <input type="search" id="search-box" placeholder="Cari menu..." />
        <label for="search-box"><i data-feather="search"></i></label>
      </div>
      <!-- Search Form end -->

      <!-- Shopping Cart start -->
      <div class="shopping-cart">
        <template x-for="(item, index) in $store.cart.items" x-keys="index">
          <div class="cart-item">
            <img
              :src="`img/${item.imgPath || 'products'}/${item.img}`"
              :alt="item.name"
            />
            <div class="item-detail">
              <h3 x-text="item.name"></h3>
              <div class="item-price">
                <span x-text="$store.cart.rupiah(item.price)"></span> &times;
                <button id="remove" @click="$store.cart.remove(item.id)">
                  &minus;
                </button>
                <span x-text="item.quantity"></span>
                <button id="add" @click="$store.cart.add(item)">&plus;</button>
                &equals;
                <span x-text="$store.cart.rupiah(item.total)"></span>
              </div>
            </div>
          </div>
        </template>

        <h4 x-show="!$store.cart.items.length" style="margin-top: 1rem">
          Keranjang Kosong
        </h4>
        <h4 x-show="$store.cart.items.length">
          Total : <span x-text="$store.cart.rupiah($store.cart.total)"></span>
        </h4>
        <div
          class="checkout-link-container"
          x-show="$store.cart.items.length"
          style="
            padding: 1rem;
            text-align: center;
            border-top: 1px dashed #666;
            margin-top: 1rem;
          "
        >
          <a
            href="/checkout"
            class="checkout-button-link"
            style="
              display: inline-block;
              width: 100%;
              padding: 1rem;
              background: linear-gradient(
                135deg,
                var(--primary) 0%,
                #a67a50 100%
              );
              color: white;
              text-decoration: none;
              border-radius: 25px;
              font-weight: 700;
              transition: all 0.3s ease;
              box-shadow: 0 4px 15px rgba(182, 137, 91, 0.3);
              font-size: 1.1rem;
            "
          >
            <i
              data-feather="arrow-right"
              style="
                width: 18px;
                height: 18px;
                vertical-align: middle;
                margin-right: 8px;
              "
            ></i>
            Lanjut ke Checkout
          </a>
        </div>
      </div>
      <!-- Shopping Cart end -->
    </nav>
    <!-- Navbar end -->

    <!-- Menu Section start -->
    <section id="menu" class="menu menu-page" x-data="products">
      <div class="menu-header">
        <h2><span>Menu</span> Kami</h2>
        <p>
          Semoga menu kopi andalan kami dapat menemani hari-hari mu dan
          memberikan kenikmatan yang tak terlupakan.
        </p>
      </div>

      <!-- Kategori Menu -->
      <div class="category-filter">
        <button
          class="category-btn"
          :class="{ 'active': selectedCategory === 'all' }"
          @click="selectedCategory = 'all'"
        >
          <i data-feather="grid"></i>
          <span>Semua</span>
        </button>
        <button
          class="category-btn"
          :class="{ 'active': selectedCategory === 'coffee' }"
          @click="selectedCategory = 'coffee'"
        >
          <i data-feather="coffee"></i>
          <span>Kopi</span>
        </button>
        <button
          class="category-btn"
          :class="{ 'active': selectedCategory === 'snack' }"
          @click="selectedCategory = 'snack'"
        >
          <i data-feather="package"></i>
          <span>Snack</span>
        </button>
        <button
          class="category-btn"
          :class="{ 'active': selectedCategory === 'dessert' }"
          @click="selectedCategory = 'dessert'"
        >
          <i data-feather="award"></i>
          <span>Dessert</span>
        </button>
      </div>

      <div class="row">
        <template x-for="item in sortedMenuItems" :key="item.id">
          <div class="menu-card" x-show="item" x-transition>
            <div class="menu-card-header">
              <img
                :src="`img/menu/${item.img}`"
                :alt="item.name"
                class="menu-card-img"
              />

              <!-- Category Badge -->
              <div class="category-badge" x-text="item.categoryLabel"></div>
              <div class="menu-card-actions">
                <!-- FAVORITE -->
                <a
                  href="#"
                  @click.prevent="$store.favorites.toggle(item, 'menu')"
                  class="menu-action-btn favorite-btn"
                  :class="{ 'favorited': $store.favorites.isFavorited(item, 'menu') }"
                  :title="$store.favorites.isFavorited(item, 'menu')
                    ? 'Hapus dari Favorit'
                    : 'Tambah ke Favorit'"
                >
                  <svg
                    width="16"
                    height="16"
                    :fill="$store.favorites.isFavorited(item, 'menu')
                      ? 'currentColor'
                      : 'none'"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <use href="img/feather-sprite.svg#heart" />
                  </svg>
                </a>
                <!-- DETAIL -->
                <a
                  href="#"
                  class="menu-action-btn item-detail-button"
                  :data-id="item.id"
                  :data-type="'menu'"
                  :data-name="item.name"
                  :data-desc="item.desc"
                  :data-img="`img/menu/${item.img}`"
                  :data-price="$store.cart.rupiah(item.price)"
                  title="Lihat Detail"
                >
                  <svg
                    width="16"
                    height="16"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <use href="img/feather-sprite.svg#eye" />
                  </svg>
                </a>
              </div>
            </div>
            <div class="menu-card-content">
              <h3 class="menu-card-title" x-text="item.name"></h3>
              <p class="menu-card-desc" x-text="item.desc"></p>
              <!-- RATING DISPLAY -->
              <div class="menu-rating-section">
                <div class="rating-stars">
                  <template x-for="i in 5" :key="i">
                    <svg
                      width="14"
                      height="14"
                      :fill="i <= Math.round(
                      $store.ratings.getAverageRating(item.id, 'menu')
                      ) ? 'currentColor' : 'none'"
                      stroke="currentColor"
                      stroke-width="2"
                    >
                      <use href="img/feather-sprite.svg#star" />
                    </svg>
                  </template>

                  <span
                    class="rating-text"
                    x-text="'(' + $store.ratings.getRatingCount(item.id, 'menu') + ')'"
                  ></span>
                </div>
              </div>
              <div class="menu-card-footer">
                <p
                  class="menu-item-price"
                  x-text="$store.cart.rupiah(item.price)"
                ></p>
                <!-- CART BUTTON -->
                <button
                  class="add-to-cart-btn"
                  @click="$store.cart.add(item)"
                  title="Tambah ke Keranjang"
                >
                  <svg
                    width="18"
                    height="18"
                    fill="none"
                    stroke="currentColor"
                    stroke-width="2"
                  >
                    <use href="img/feather-sprite.svg#shopping-cart" />
                  </svg>
                  <span>Tambah</span>
                </button>
              </div>
            </div>
          </div>
        </template>
      </div>
    </section>
    <!-- Menu end -->

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
            <li><a href="/home">Beranda</a></li>
            <li><a href="/home#about">Tentang Kami</a></li>
            <li><a href="/menu">Menu</a></li>
            <li><a href="/produk">Produk Kami</a></li>
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
    <!-- Footer end -->

    <!-- Modal Box Item Detail start -->
    <div class="modal" id="item-detail-modal">
      <div class="modal-container">
        <a href="#" class="close-icon"><i data-feather="x"></i></a>
        <div class="modal-content">
          <img src="img/menu/1.jpg" alt="Product 1" />
          <div class="product-content">
            <h3>Product 1</h3>
            <p>
              Lorem ipsum dolor sit, amet consectetur adipisicing elit. Saepe,
              sint quam! Debitis aliquam totam fuga officiis optio voluptas
              ipsum earum beatae, sunt ut, soluta sed!
            </p>
            <div class="product-stars">
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
              <i data-feather="star" class="star-full"></i>
            </div>
            <div class="rating-info">
              <span>(0 rating)</span>
            </div>

            <!-- Rating Section di Modal -->
            <div class="modal-rating-section">
              <span
                style="
                  font-size: 1rem;
                  color: #666;
                  display: block;
                  margin-bottom: 0.5rem;
                "
                >Beri Rating Anda:</span
              >
              <div class="rate-stars" style="justify-content: flex-start">
                <svg
                  width="20"
                  height="20"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  class="rate-star modal-rate-star"
                  data-rating="1"
                >
                  <use href="img/feather-sprite.svg#star" />
                </svg>
                <svg
                  width="20"
                  height="20"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  class="rate-star modal-rate-star"
                  data-rating="2"
                >
                  <use href="img/feather-sprite.svg#star" />
                </svg>
                <svg
                  width="20"
                  height="20"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  class="rate-star modal-rate-star"
                  data-rating="3"
                >
                  <use href="img/feather-sprite.svg#star" />
                </svg>
                <svg
                  width="20"
                  height="20"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  class="rate-star modal-rate-star"
                  data-rating="4"
                >
                  <use href="img/feather-sprite.svg#star" />
                </svg>
                <svg
                  width="20"
                  height="20"
                  fill="none"
                  stroke="currentColor"
                  stroke-width="2"
                  class="rate-star modal-rate-star"
                  data-rating="5"
                >
                  <use href="img/feather-sprite.svg#star" />
                </svg>
              </div>
            </div>
            <div class="product-price">IDR 30K</div>
          </div>
        </div>
      </div>
    </div>
    <!-- Modal Box Item Detail end -->

    <script>
      feather.replace();
      // Tangani parameter URL untuk filter otomatis
      document.addEventListener("DOMContentLoaded", function () {
        const urlParams = new URLSearchParams(window.location.search);
        const category = urlParams.get("category");

        if (category) {
          // Tunggu Alpine.js siap
          setTimeout(() => {
            if (typeof Alpine !== "undefined") {
              const productsElement = document.querySelector(
                '[x-data="products"]'
              );
              if (productsElement) {
                const productsData = Alpine.$data(productsElement);

                if (
                  productsData &&
                  ["all", "coffee", "snack", "dessert"].includes(category)
                ) {
                  productsData.selectedCategory = category;

                  // Scroll ke menu section
                  setTimeout(() => {
                    const menuSection = document.getElementById("menu");
                    if (menuSection) {
                      menuSection.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                      });
                    }
                  }, 300);
                }
              }
            }
          }, 200);
        }
      });
    </script>

    <!-- My Javascript -->
    <script src="js/script.js"></script>
  </body>
</html>
