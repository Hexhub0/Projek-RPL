// Navbar Toggle
const navbarNav = document.querySelector(".navbar-nav");
const hamburgerMenu = document.querySelector("#hamburger-menu");

// Toggle hamburger menu
if (hamburgerMenu) {
  hamburgerMenu.onclick = (e) => {
    navbarNav.classList.toggle("active");
    e.preventDefault();
  };
}

// Search Form Toggle
const searchForm = document.querySelector(".search-form");
const searchBox = document.querySelector("#search-box");
const searchButton = document.querySelector("#search-button");

if (searchButton) {
  searchButton.onclick = (e) => {
    searchForm.classList.toggle("active");
    searchBox.focus();
    e.preventDefault();
  };
}

// Shopping Cart Toggle
const shoppingCart = document.querySelector(".shopping-cart");
const shoppingCartButton = document.querySelector("#shopping-cart-button");

if (shoppingCartButton) {
  shoppingCartButton.onclick = (e) => {
    shoppingCart.classList.toggle("active");
    e.preventDefault();
  };
}

// Close menu/search/cart when clicking outside
document.addEventListener("click", function (e) {
  const isClickInsideNav = navbarNav.contains(e.target);
  const isClickHamburger = hamburgerMenu && hamburgerMenu.contains(e.target);
  const isClickSearchForm = searchForm.contains(e.target);
  const isClickSearchButton = searchButton && searchButton.contains(e.target);
  const isClickCart = shoppingCart.contains(e.target);
  const isClickCartButton =
    shoppingCartButton && shoppingCartButton.contains(e.target);

  if (!isClickInsideNav && !isClickHamburger && navbarNav) {
    navbarNav.classList.remove("active");
  }

  // if (!isClickSearchForm && !isClickSearchButton && searchForm) {
  //   searchForm.classList.remove("active");
  // }

  if (!isClickCart && !isClickCartButton && shoppingCart) {
    shoppingCart.classList.remove("active");
  }
});

// Modal Box Item Detail
const itemDetailModal = document.querySelector("#item-detail-modal");
document.addEventListener("click", function (e) {
  const btn = e.target.closest(".item-detail-button");

  if (btn) {
    e.preventDefault();

    // Get data from button attributes
    const itemId = btn.dataset.id;
    const itemType = btn.dataset.type;
    const itemName = btn.dataset.name;
    const itemDesc = btn.dataset.desc;
    const itemImg = btn.dataset.img;
    const itemPrice = btn.dataset.price;

    console.log("Opening modal for:", itemName, "Image:", itemImg); // Debug

    // Update modal content
    if (itemDetailModal) {
      const modalImg = itemDetailModal.querySelector("img");
      const modalTitle = itemDetailModal.querySelector(".product-content h3");
      const modalDesc = itemDetailModal.querySelector(".product-content p");
      const modalPrice = itemDetailModal.querySelector(".product-price");

      if (modalImg) {
        modalImg.src = itemImg;
        modalImg.alt = itemName;
      }
      if (modalTitle) modalTitle.textContent = itemName;
      if (modalDesc) modalDesc.textContent = itemDesc;
      if (modalPrice) modalPrice.textContent = itemPrice;

      // Update stars based on rating
      updateModalRating(itemId, itemType);

      // Store current item data in modal
      itemDetailModal.dataset.itemId = itemId;
      itemDetailModal.dataset.itemType = itemType;

      // Show modal
      itemDetailModal.style.display = "flex";

      // Replace feather icons
      if (typeof feather !== "undefined") {
        feather.replace();
      }
    }
  }
});

// Close modal
const closeIcon = document.querySelector(".modal .close-icon");
if (closeIcon) {
  closeIcon.onclick = (e) => {
    e.preventDefault();
    if (itemDetailModal) {
      itemDetailModal.style.display = "none";
    }
  };
}

// Close modal when clicking outside
if (itemDetailModal) {
  window.onclick = (e) => {
    if (e.target === itemDetailModal) {
      itemDetailModal.style.display = "none";
    }
  };
}

// Update modal rating display
function updateModalRating(itemId, itemType) {
  if (typeof Alpine === "undefined" || !Alpine.store("ratings")) return;

  const ratingsStore = Alpine.store("ratings");
  const avgRating = ratingsStore.getAverageRating(itemId, itemType);
  const ratingCount = ratingsStore.getRatingCount(itemId, itemType);

  // Update star display
  const stars = itemDetailModal.querySelectorAll(".product-stars i");
  stars.forEach((star, index) => {
    if (index < Math.round(avgRating)) {
      star.classList.add("star-full");
    } else {
      star.classList.remove("star-full");
    }
  });

  // Update rating count
  const ratingInfo = itemDetailModal.querySelector(".rating-info span");
  if (ratingInfo) {
    ratingInfo.textContent = `(${ratingCount} rating)`;
  }

  // Re-initialize feather icons
  if (typeof feather !== "undefined") {
    feather.replace();
  }
}

// Modal Rating Stars Click Handler
document.addEventListener("DOMContentLoaded", function () {
  const modalRateStars = document.querySelectorAll(".modal-rate-star");

  modalRateStars.forEach((star) => {
    star.addEventListener("click", function () {
      if (typeof Alpine === "undefined" || !Alpine.store("ratings")) return;

      const rating = parseInt(this.dataset.rating);
      const itemId = itemDetailModal.dataset.itemId;
      const itemType = itemDetailModal.dataset.itemType;

      if (itemId && itemType) {
        // Add rating
        Alpine.store("ratings").addRating(itemId, itemType, rating);

        // Visual feedback
        modalRateStars.forEach((s, index) => {
          if (index < rating) {
            s.setAttribute("fill", "currentColor");
          } else {
            s.setAttribute("fill", "none");
          }
        });

        // Update modal rating display
        updateModalRating(itemId, itemType);

        // Show success message
        alert(`Terima kasih! Anda memberikan rating ${rating} bintang.`);
      }
    });

    // Hover effect
    star.addEventListener("mouseenter", function () {
      const rating = parseInt(this.dataset.rating);
      modalRateStars.forEach((s, index) => {
        if (index < rating) {
          s.setAttribute("fill", "currentColor");
        } else {
          s.setAttribute("fill", "none");
        }
      });
    });
  });

  // Reset stars on mouse leave
  const rateStarsContainer = document.querySelector(
    ".modal-rating-section .rate-stars"
  );
  if (rateStarsContainer) {
    rateStarsContainer.addEventListener("mouseleave", function () {
      if (typeof Alpine === "undefined" || !Alpine.store("ratings")) return;

      const itemId = itemDetailModal.dataset.itemId;
      const itemType = itemDetailModal.dataset.itemType;

      // Reset rating stars visual
      const rateStars = itemDetailModal.querySelectorAll(".modal-rate-star");
      rateStars.forEach((star) => {
        star.setAttribute("fill", "none");
      });

      if (itemId && itemType) {
        const userRating = Alpine.store("ratings").getUserRating(
          itemId,
          itemType
        );
        modalRateStars.forEach((s, index) => {
          if (index < userRating) {
            s.setAttribute("fill", "currentColor");
          } else {
            s.setAttribute("fill", "none");
          }
        });
      }
    });
  }
});

// Search functionality (optional enhancement)
if (searchBox) {
  searchBox.addEventListener("input", function (e) {
    const searchTerm = e.target.value.toLowerCase();
    console.log("Searching for:", searchTerm);
  });
}

// Add smooth scroll behavior
document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
  anchor.addEventListener("click", function (e) {
    const href = this.getAttribute("href");
    if (href !== "#" && document.querySelector(href)) {
      e.preventDefault();
      document.querySelector(href).scrollIntoView({
        behavior: "smooth",
      });
    }
  });
});

// Replace feather icons on page load
if (typeof feather !== "undefined") {
  feather.replace();
}

// Refresh feather icons periodically for dynamically added content
setInterval(() => {
  if (typeof feather !== "undefined") {
    feather.replace();
  }
}, 1000);

// Profile Dropdown Toggle
const profileBtn = document.getElementById("profile-button");
const profileDropdown = document.getElementById("profile-dropdown");

if (profileBtn && profileDropdown) {
  profileBtn.addEventListener("click", function (e) {
    e.stopPropagation();
    profileDropdown.classList.toggle("active");
  });

  // Close dropdown when clicking outside
  document.addEventListener("click", function (e) {
    if (!profileBtn.contains(e.target) && !profileDropdown.contains(e.target)) {
      profileDropdown.classList.remove("active");
    }
  });
}

// Fungsi untuk membaca parameter URL
function getUrlParameter(name) {
  name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
  var regex = new RegExp("[\\?&]" + name + "=([^&#]*)");
  var results = regex.exec(location.search);
  return results === null
    ? ""
    : decodeURIComponent(results[1].replace(/\+/g, " "));
}

// User Manager
const UserManager = {
  currentUser: {
    username: "Guest User",
    email: "guest@example.com",
    isLoggedIn: false,
  },

  init() {
    const savedUser = localStorage.getItem("berandaCoffeeUser");
    if (savedUser) {
      this.currentUser = JSON.parse(savedUser);
      this.updateProfileUI();
    }
  },

  login(username, email) {
    this.currentUser = {
      username: username || "User",
      email: email || "user@example.com",
      isLoggedIn: true,
    };
    localStorage.setItem("berandaCoffeeUser", JSON.stringify(this.currentUser));
    this.updateProfileUI();
  },

  logout() {
    this.currentUser = {
      username: "Guest User",
      email: "guest@example.com",
      isLoggedIn: false,
    };
    localStorage.removeItem("berandaCoffeeUser");
    this.updateProfileUI();
    alert("Anda telah logout.");
  },

  updateProfileUI() {
    const usernameEl = document.getElementById("profile-username");
    const emailEl = document.getElementById("profile-email");

    if (usernameEl) usernameEl.textContent = this.currentUser.username;
    if (emailEl) emailEl.textContent = this.currentUser.email;
  },
};

// Inisialisasi saat halaman dimuat
document.addEventListener("DOMContentLoaded", function () {
  UserManager.init();

  // Logout button handler
  const logoutBtn = document.getElementById("logout-btn");
  if (logoutBtn) {
    logoutBtn.addEventListener("click", function (e) {
      e.preventDefault();
      UserManager.logout();
    });
  }
});

// Close modal handler alternative
document.addEventListener("click", function (e) {
  if (
    e.target.classList.contains("close-icon") ||
    e.target.closest(".close-icon")
  ) {
    const modal = document.getElementById("item-detail-modal");
    if (modal) {
      modal.style.display = "none";
    }
  }
});

// Enhanced Search Functionality
// Tambahkan kode ini ke dalam script.js Anda

// Search functionality with navigation
if (searchBox) {
  let searchTimeout;

  searchBox.addEventListener("input", function (e) {
    const searchTerm = e.target.value.toLowerCase().trim();

    // Clear previous timeout
    clearTimeout(searchTimeout);

    // Debounce search (tunggu 500ms setelah user berhenti mengetik)
    searchTimeout = setTimeout(() => {
      if (searchTerm.length > 0) {
        performSearch(searchTerm, false); // false = jangan tutup search form
      }
    }, 500);
  });

  // Search on Enter key
  searchBox.addEventListener("keypress", function (e) {
    if (e.key === "Enter") {
      e.preventDefault();
      const searchTerm = e.target.value.toLowerCase().trim();
      if (searchTerm.length > 0) {
        performSearch(searchTerm, false); // false = jangan tutup search form
      }
    }
  });

  // Prevent search form from closing when typing
  searchBox.addEventListener("focus", function () {
    if (searchForm) {
      searchForm.classList.add("active");
    }
  });
}

// Function to perform search
function performSearch(searchTerm, closeSearch = false) {
  console.log("Searching for:", searchTerm);

  // Get all items from Alpine.js store
  if (typeof Alpine === "undefined") {
    console.error("Alpine.js not loaded");
    return;
  }

  // Wait for Alpine to be ready
  setTimeout(() => {
    const productsData = Alpine.store("cart");

    // Search in menu items
    const menuItems = [
      { id: 1, name: "Espresso", category: "coffee", page: "menu" },
      { id: 2, name: "Latte Coffee", category: "coffee", page: "menu" },
      { id: 3, name: "Matcha Coffee", category: "coffee", page: "menu" },
      { id: 4, name: "Cappuccino", category: "coffee", page: "menu" },
      { id: 5, name: "Americano", category: "coffee", page: "menu" },
      {
        id: 6,
        name: "Beranda Coffee Pastry",
        category: "coffee",
        page: "menu",
      },
      { id: 7, name: "French Fries", category: "snack", page: "menu" },
      { id: 8, name: "Sandwich", category: "snack", page: "menu" },
      { id: 9, name: "Roti Coklat", category: "snack", page: "menu" },
      { id: 10, name: "Roti Keju", category: "snack", page: "menu" },
      { id: 11, name: "Brownies Coklat", category: "dessert", page: "menu" },
      { id: 12, name: "Manggo Pudding", category: "dessert", page: "menu" },
    ];

    const productItems = [
      { id: 101, name: "Arabica Gayo", page: "products" },
      { id: 102, name: "Robusta Lampung", page: "products" },
      { id: 103, name: "Arabica Toraja", page: "products" },
      { id: 104, name: "Kopi Luwak", page: "products" },
    ];

    // Search in menu items
    const menuResults = menuItems.filter((item) =>
      item.name.toLowerCase().includes(searchTerm)
    );

    // Search in product items
    const productResults = productItems.filter((item) =>
      item.name.toLowerCase().includes(searchTerm)
    );

    console.log("Menu results:", menuResults);
    console.log("Product results:", productResults);

    // Navigate to the appropriate page
    if (menuResults.length > 0) {
      // Found in menu - navigate to menu.html
      const firstResult = menuResults[0];
      showSearchNotification("Ditemukan: " + firstResult.name, "success");
      setTimeout(() => {
        navigateToResult("menu", firstResult.category, firstResult.id);
      }, 500);
    } else if (productResults.length > 0) {
      // Found in products - navigate to products.html
      const firstResult = productResults[0];
      showSearchNotification("Ditemukan: " + firstResult.name, "success");
      setTimeout(() => {
        navigateToResult("products", null, firstResult.id);
      }, 500);
    } else {
      // No results found
      showSearchNotification(
        "Tidak ditemukan hasil untuk '" + searchTerm + "'",
        "error"
      );
    }

    // Jangan tutup search form otomatis
    // Biarkan user menutup manual dengan click di luar atau tombol close
  }, 100);
}

// Function to navigate to search result
function navigateToResult(page, category, itemId) {
  const currentPage = window.location.pathname.split("/").pop();

  if (page === "menu") {
    if (currentPage === "menu.html") {
      // Already on menu page - just filter and scroll
      filterAndScrollToItem(category, itemId);
    } else {
      // Navigate to menu page with category filter
      window.location.href = `menu.html?category=${category}`;
    }
  } else if (page === "products") {
    if (currentPage === "products.html") {
      // Already on products page - just scroll to item
      scrollToProductItem(itemId);
    } else {
      // Navigate to products page
      window.location.href = "products.html";
    }
  }
}

// Function to filter and scroll to menu item
function filterAndScrollToItem(category, itemId) {
  if (typeof Alpine === "undefined") return;

  // Wait for Alpine to be ready
  setTimeout(() => {
    const productsElement = document.querySelector('[x-data="products"]');
    if (productsElement) {
      const productsData = Alpine.$data(productsElement);

      if (productsData) {
        // Set category filter
        productsData.selectedCategory = category;

        // Wait for Alpine to re-render
        setTimeout(() => {
          // Scroll to the item
          const menuSection = document.getElementById("menu");
          if (menuSection) {
            menuSection.scrollIntoView({
              behavior: "smooth",
              block: "start",
            });
          }

          // Highlight the found item
          highlightSearchResult(itemId);
        }, 300);
      }
    }
  }, 200);
}

// Function to scroll to product item
function scrollToProductItem(itemId) {
  setTimeout(() => {
    const productsSection = document.getElementById("products");
    if (productsSection) {
      productsSection.scrollIntoView({
        behavior: "smooth",
        block: "start",
      });

      // Highlight the found item
      highlightSearchResult(itemId);
    }
  }, 300);
}

// Function to highlight search result
function highlightSearchResult(itemId) {
  setTimeout(() => {
    // Find all cards
    const cards = document.querySelectorAll(".menu-card, .product-card-new");

    cards.forEach((card) => {
      // Check if this card has the matching item ID
      const detailButton = card.querySelector(".item-detail-button");
      if (detailButton && detailButton.dataset.id == itemId) {
        // Add highlight effect
        card.style.transition = "all 0.3s ease";
        card.style.transform = "scale(1.05)";
        card.style.boxShadow = "0 8px 30px rgba(182, 137, 91, 0.5)";
        card.style.border = "2px solid var(--primary)";

        // Remove highlight after 2 seconds
        setTimeout(() => {
          card.style.transform = "scale(1)";
          card.style.boxShadow = "";
          card.style.border = "";
        }, 2000);
      }
    });
  }, 500);
}

// Function to show search notification
function showSearchNotification(message, type = "info") {
  // Remove existing notification if any
  const existingNotification = document.querySelector(".search-notification");
  if (existingNotification) {
    document.body.removeChild(existingNotification);
  }

  // Create notification element
  const notification = document.createElement("div");
  notification.className = "search-notification";
  notification.textContent = message;

  // Set color based on type
  let bgColor = "#333";
  if (type === "success") {
    bgColor = "#4CAF50"; // Green for success
  } else if (type === "error") {
    bgColor = "#f44336"; // Red for error
  }

  notification.style.cssText = `
    position: fixed;
    top: 80px;
    left: 50%;
    transform: translateX(-50%);
    background: ${bgColor};
    color: white;
    padding: 1rem 2rem;
    border-radius: 8px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.3);
    z-index: 9999;
    animation: slideDown 0.3s ease;
    font-weight: 500;
  `;

  document.body.appendChild(notification);

  // Remove notification after 2 seconds (lebih cepat untuk success)
  const duration = type === "success" ? 2000 : 3000;
  setTimeout(() => {
    notification.style.animation = "slideUp 0.3s ease";
    setTimeout(() => {
      if (document.body.contains(notification)) {
        document.body.removeChild(notification);
      }
    }, 300);
  }, duration);
}

// Add CSS animations for notification
const style = document.createElement("style");
style.textContent = `
  @keyframes slideDown {
    from {
      opacity: 0;
      transform: translateX(-50%) translateY(-20px);
    }
    to {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
  }
  
  @keyframes slideUp {
    from {
      opacity: 1;
      transform: translateX(-50%) translateY(0);
    }
    to {
      opacity: 0;
      transform: translateX(-50%) translateY(-20px);
    }
  }
`;
document.head.appendChild(style);

// Update close search form handler agar tidak close saat click di dalam search box
document.addEventListener("click", function (e) {
  const isClickSearchForm = searchForm && searchForm.contains(e.target);
  const isClickSearchButton = searchButton && searchButton.contains(e.target);

  // Jangan tutup search form jika click di dalam search form atau search button
  if (!isClickSearchForm && !isClickSearchButton && searchForm) {
    searchForm.classList.remove("active");
  }
});
