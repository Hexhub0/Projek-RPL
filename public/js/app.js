// Alpine.js Data and Stores

document.addEventListener("alpine:init", () => {
  Alpine.data("products", () => ({
    selectedCategory: "all",

    // Menu Items
    items: [
      {
        id: 1,
        name: "Espresso",
        img: "1.jpg",
        imgPath: "menu",
        price: 15000,
        desc: "Kopi murni dengan rasa kuat dan aroma yang khas, disajikan tanpa tambahan susu atau gula",
        category: "coffee",
        categoryLabel: "Kopi",
      },
      {
        id: 2,
        name: "Latte Coffee",
        img: "2.jpg",
        imgPath: "menu",
        price: 20000,
        desc: "Perpaduan sempurna espresso dan susu steamed",
        category: "coffee",
        categoryLabel: "Kopi",
      },
      {
        id: 3,
        name: "Matcha Coffee",
        img: "3.jpg",
        imgPath: "menu",
        price: 25000,
        desc: "Kombinasi unik matcha premium dengan kopi, memberikan rasa segar dan kaya",
        category: "coffee",
        categoryLabel: "Kopi",
      },
      {
        id: 4,
        name: "Cappuccino",
        img: "4.jpg",
        imgPath: "menu",
        price: 25000,
        desc: "Espresso dengan foam susu yang lembut, memberikan tekstur kaya",
        category: "coffee",
        categoryLabel: "Kopi",
      },
      {
        id: 5,
        name: "Affogato Coffee",
        img: "5.jpg",
        imgPath: "menu",
        price: 24000,
        desc: "kopi latte dingin yang dituangkan di atas es krim vanilla, menciptakan perpaduan hangat dan dingin yang lezat",
        category: "coffee",
        categoryLabel: "Kopi",
      },
      {
        id: 6,
        name: "Beranda Coffee Pastry",
        img: "6.jpg",
        imgPath: "menu",
        price: 27000,
        desc: "Pastry renyah dengan tekstur berlapis, dan hanya tersedia di Beranda Coffee",
        category: "coffee",
        categoryLabel: "Kopi",
      },
      {
        id: 7,
        name: "French Fries",
        img: "7.jpg",
        imgPath: "menu",
        price: 22000,
        desc: "Kentang goreng renyah dengan bumbu spesial",
        category: "snack",
        categoryLabel: "Snack",
      },
      {
        id: 8,
        name: "Sandwich",
        img: "8.jpg",
        imgPath: "menu",
        price: 26000,
        desc: "Sandwich lezat dengan isian segar, pilihan roti, dan saus spesial",
        category: "snack",
        categoryLabel: "Snack",
      },
      {
        id: 9,
        name: "Roti Coklat",
        img: "9.jpg",
        imgPath: "menu",
        price: 20000,
        desc: "Roti lembut dengan isian coklat meleleh",
        category: "snack",
        categoryLabel: "Snack",
      },
      {
        id: 10,
        name: "Roti Keju",
        img: "10.jpg",
        imgPath: "menu",
        price: 20000,
        desc: "Roti keju lembut dengan topping pilihan, disajikan hangat",
        category: "snack",
        categoryLabel: "Snack",
      },
      {
        id: 11,
        name: "Brownies Coklat",
        img: "11.jpg",
        imgPath: "menu",
        price: 19000,
        desc: "Brownies coklat lembut dengan taburan kacang",
        category: "dessert",
        categoryLabel: "Dessert",
      },
      {
        id: 12,
        name: "Manggo Pudding",
        img: "12.jpg",
        imgPath: "menu",
        price: 23000,
        desc: "Puding mangga segar dengan saus vanilla, topping buah segar",
        category: "dessert",
        categoryLabel: "Dessert",
      },
    ],

    // Product Items (Coffee Beans)
    productItems: [
      {
        id: 101,
        name: "Tocal Coffee",
        img: "1.jpg",
        imgPath: "products",
        price: 65000,
        desc: "Biji kopi arabica pilihan dari Gayo",
      },
      {
        id: 102,
        name: "Tocal Matcha",
        img: "2.jpg",
        imgPath: "products",
        price: 85000,
        desc: "Matcha premium dari Jepang dengan rasa autentik",
      },
      {
        id: 103,
        name: "Tocal Cappucino",
        img: "3.jpg",
        imgPath: "products",
        price: 95000,
        desc: "Campuran kopi dan susu berkualitas tinggi untuk cappucino sempurna",
      },
      {
        id: 104,
        name: "Tocal Espresso",
        img: "4.jpg",
        imgPath: "products",
        price: 70000,
        desc: "Biji kopi robusta pilihan dengan cita rasa kuat dan aroma khas",
      },
    ],

    // Filtered Menu Items (dengan sorting berdasarkan favorit)
    get filteredMenuItems() {
      const favs = Alpine.store("favorites").items;
      let filtered = [];

      if (this.selectedCategory === "all") {
        filtered = this.items;
      } else {
        filtered = this.items.filter(
          (item) => item.category === this.selectedCategory
        );
      }

      // Sort: favorit di atas
      return [...filtered].sort((a, b) => {
        const aFav = favs.find((f) => f.id === a.id && f.type === "menu");
        const bFav = favs.find((f) => f.id === b.id && f.type === "menu");

        if (aFav && !bFav) return -1;
        if (!aFav && bFav) return 1;
        return 0;
      });
    },

    get sortedMenuItems() {
      return this.filteredMenuItems;
    },

    // Sorted Product Items
    get sortedItems() {
      const favs = Alpine.store("favorites").items;

      return [...this.productItems].sort((a, b) => {
        const aFav = favs.find((f) => f.id === a.id && f.type === "product");
        const bFav = favs.find((f) => f.id === b.id && f.type === "product");

        // Favorit selalu di atas
        if (aFav && !bFav) return -1;
        if (!aFav && bFav) return 1;

        return a.price - b.price;
      });
    },
  }));

  // Cart Store
  Alpine.store("cart", {
    items: [],
    quantity: 0,
    total: 0,

    // Add item to cart
    add(newItem) {
      // Check if item already exists
      const cartItem = this.items.find((item) => item.id === newItem.id);

      if (!cartItem) {
        // Add new item
        this.items.push({
          ...newItem,
          quantity: 1,
          total: newItem.price,
        });
        this.quantity++;
        this.total += newItem.price;
      } else {
        // Update existing item
        this.items = this.items.map((item) => {
          if (item.id !== newItem.id) {
            return item;
          } else {
            item.quantity++;
            item.total = item.price * item.quantity;
            this.quantity++;
            this.total += item.price;
            return item;
          }
        });
      }

      // Save to localStorage
      this.saveToStorage();
    },

    // Remove item from cart
    remove(id) {
      const cartItem = this.items.find((item) => item.id === id);

      if (cartItem.quantity > 1) {
        // Decrease quantity
        this.items = this.items.map((item) => {
          if (item.id !== id) {
            return item;
          } else {
            item.quantity--;
            item.total = item.price * item.quantity;
            this.quantity--;
            this.total -= item.price;
            return item;
          }
        });
      } else {
        // Remove item completely
        this.items = this.items.filter((item) => item.id !== id);
        this.quantity--;
        this.total -= cartItem.price;
      }

      // Save to localStorage
      this.saveToStorage();
    },

    // Format price to Rupiah
    rupiah(number) {
      return new Intl.NumberFormat("id-ID", {
        style: "currency",
        currency: "IDR",
        minimumFractionDigits: 0,
      }).format(number);
    },

    // Save cart to localStorage
    saveToStorage() {
      localStorage.setItem(
        "cart",
        JSON.stringify({
          items: this.items,
          quantity: this.quantity,
          total: this.total,
        })
      );
    },

    // Load cart from localStorage
    loadFromStorage() {
      const savedCart = localStorage.getItem("cart");
      if (savedCart) {
        const cart = JSON.parse(savedCart);
        this.items = cart.items || [];
        this.quantity = cart.quantity || 0;
        this.total = cart.total || 0;
      }
    },

    // Clear cart
    clear() {
      this.items = [];
      this.quantity = 0;
      this.total = 0;
      this.saveToStorage();
    },
  });

  // Favorites Store
  Alpine.store("favorites", {
    items: [],

    // Initialize from localStorage
    init() {
      const saved = localStorage.getItem("favorites");
      if (saved) {
        this.items = JSON.parse(saved);
      }
    },

    // Toggle favorite
    toggle(item, type) {
      const key = `${type}-${item.id}`;
      const index = this.items.findIndex((fav) => fav.key === key);

      if (index === -1) {
        // Add to favorites
        this.items.push({
          key: key,
          ...item,
          type: type,
        });
      } else {
        // Remove from favorites
        this.items.splice(index, 1);
      }

      // Save to localStorage
      localStorage.setItem("favorites", JSON.stringify(this.items));
    },

    // Check if item is favorited
    isFavorited(item, type) {
      const key = `${type}-${item.id}`;
      return this.items.some((fav) => fav.key === key);
    },
  });

  // Ratings Store
  Alpine.store("ratings", {
    ratings: {},

    // Initialize from localStorage
    init() {
      const saved = localStorage.getItem("ratings");
      if (saved) {
        this.ratings = JSON.parse(saved);
      }
    },

    // Add rating
    addRating(itemId, itemType, rating) {
      const key = `${itemType}-${itemId}`;

      if (!this.ratings[key]) {
        this.ratings[key] = {
          total: 0,
          count: 0,
          userRating: 0,
        };
      }

      // Remove old user rating if exists
      if (this.ratings[key].userRating > 0) {
        this.ratings[key].total -= this.ratings[key].userRating;
        this.ratings[key].count--;
      }

      // Add new rating
      this.ratings[key].total += rating;
      this.ratings[key].count++;
      this.ratings[key].userRating = rating;

      // Save to localStorage
      localStorage.setItem("ratings", JSON.stringify(this.ratings));
    },

    // Get average rating
    getAverageRating(itemId, itemType) {
      const key = `${itemType}-${itemId}`;
      if (!this.ratings[key] || this.ratings[key].count === 0) {
        return 0;
      }
      return this.ratings[key].total / this.ratings[key].count;
    },

    // Get rating count
    getRatingCount(itemId, itemType) {
      const key = `${itemType}-${itemId}`;
      return this.ratings[key] ? this.ratings[key].count : 0;
    },

    // Get user's rating
    getUserRating(itemId, itemType) {
      const key = `${itemType}-${itemId}`;
      return this.ratings[key] ? this.ratings[key].userRating : 0;
    },
  });

  // Load cart from storage on init
  Alpine.store("cart").loadFromStorage();

  // Initialize favorites
  Alpine.store("favorites").init();

  // Initialize ratings
  Alpine.store("ratings").init();
});
