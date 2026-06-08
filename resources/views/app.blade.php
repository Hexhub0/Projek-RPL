<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Beranda Coffee</title>

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,300;0,400;0,500;0,600;0,700;1,700&display=swap"
      rel="stylesheet"
    />

    <script src="https://unpkg.com/feather-icons"></script>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
    <style>
      .login-page {
        min-height: 100vh;
        background: linear-gradient(
            135deg,
            rgba(28, 19, 15, 0.85) 0%,
            rgba(42, 30, 23, 0.85) 100%
          ),
          url("https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80")
            center/cover;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        position: relative;
        animation: fadeIn 1s ease-in;
      }

      @keyframes fadeIn {
        from {
          opacity: 0;
        }
        to {
          opacity: 1;
        }
      }

      .login-container {
        background: rgba(255, 255, 255, 0.95);
        border-radius: 20px;
        padding: 3rem;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.4);
        width: 100%;
        max-width: 480px;
        position: relative;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.3);
        animation: slideUp 0.8s ease-out;
      }

      @keyframes slideUp {
        from {
          opacity: 0;
          transform: translateY(30px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .login-container::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), #8b5a2b, #d4a574);
      }

      .login-header {
        text-align: center;
        margin-bottom: 2.5rem;
      }

      .logo-container {
        margin-bottom: 1.5rem;
      }

      .logo-container h1 {
        color: #1c130f;
        font-size: 2.8rem;
        font-weight: 700;
        margin-bottom: 0.5rem;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
      }

      .logo-container h1 span {
        color: var(--primary);
      }

      .logo-container p {
        color: #666;
        font-size: 1.1rem;
        font-weight: 300;
        line-height: 1.5;
      }

      .welcome-text {
        color: var(--primary);
        font-size: 1.4rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
        display: block;
      }

      .login-form {
        display: flex;
        flex-direction: column;
        gap: 1.8rem;
      }

      .form-group {
        position: relative;
      }

      .form-group label {
        display: block;
        margin-bottom: 0.8rem;
        color: #1c130f;
        font-weight: 500;
        font-size: 1.1rem;
      }

      .form-group input,
      .form-group textarea,
      .form-group select {
        width: 100%;
        padding: 1.2rem 1.5rem 1.2rem 3.5rem;
        border: 2px solid #e8e8e8;
        border-radius: 12px;
        font-size: 1rem;
        font-family: "Poppins", sans-serif;
        transition: all 0.3s ease;
        background: #fff;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        color: #333;
      }

      .form-group input:focus,
      .form-group textarea:focus,
      .form-group select:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(182, 137, 91, 0.15);
        transform: translateY(-1px);
      }

      .form-group input::placeholder,
      .form-group textarea::placeholder {
        color: #999;
      }

      .form-group textarea {
        resize: vertical;
        min-height: 90px;
        line-height: 1.5;
        padding-left: 3.5rem !important;
      }

      .form-group select {
        cursor: pointer;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 1rem;
      }

      .input-with-icon {
        position: relative;
      }

      .input-with-icon i {
        position: absolute;
        left: 1.5rem;
        top: 50%;
        transform: translateY(-50%);
        color: #666;
        z-index: 2;
      }

      .input-with-icon.textarea-icon i {
        top: 1.5rem;
        transform: translateY(0);
      }

      .login-btn-submit {
        background: linear-gradient(135deg, var(--primary), #8b5a2b);
        color: white;
        border: none;
        padding: 1.3rem 2rem;
        border-radius: 12px;
        font-size: 1.2rem;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        margin-top: 1rem;
        font-family: "Poppins", sans-serif;
        box-shadow: 0 4px 15px rgba(182, 137, 91, 0.3);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.8rem;
        position: relative;
        overflow: hidden;
      }

      .login-btn-submit::before {
        content: "";
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(
          90deg,
          transparent,
          rgba(255, 255, 255, 0.2),
          transparent
        );
        transition: left 0.5s;
      }

      .login-btn-submit:hover::before {
        left: 100%;
      }

      .login-btn-submit:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 25px rgba(182, 137, 91, 0.4);
      }

      .login-btn-submit:active {
        transform: translateY(-1px);
      }

      .login-btn-submit:disabled {
        background: #ccc;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
      }

      .login-btn-submit:disabled:hover::before {
        left: -100%;
      }

      .login-footer {
        text-align: center;
        margin-top: 2.5rem;
        padding-top: 2rem;
        border-top: 1px solid #e8e8e8;
      }

      .login-footer p {
        color: #666;
        margin-bottom: 1.5rem;
        font-size: 1rem;
        line-height: 1.5;
      }

      .login-link {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        font-size: 1rem;
        transition: all 0.3s ease;
      }

      .login-link:hover {
        color: #8b5a2b;
        text-decoration: underline;
      }

      .back-to-home {
        color: var(--primary);
        text-decoration: none;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        gap: 0.8rem;
        transition: all 0.3s ease;
        padding: 0.8rem 1.5rem;
        border: 2px solid var(--primary);
        border-radius: 25px;
        margin-top: 1rem;
        background: transparent;
      }

      .back-to-home:hover {
        background-color: var(--primary);
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(182, 137, 91, 0.3);
        text-decoration: none;
      }

      .form-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 1rem;
      }

      .remember-me {
        display: flex;
        align-items: center;
        gap: 0.8rem;
        color: #666;
        font-size: 0.95rem;
        cursor: pointer;
      }

      .remember-me input[type="checkbox"] {
        width: 18px;
        height: 18px;
        accent-color: var(--primary);
        cursor: pointer;
      }

      .forgot-password {
        color: var(--primary);
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        transition: color 0.3s ease;
      }

      .forgot-password:hover {
        color: #8b5a2b;
        text-decoration: underline;
      }

      .modal {
        display: none;
        position: fixed;
        z-index: 10000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        backdrop-filter: blur(5px);
      }

      .modal-content {
        background-color: #fefefe;
        margin: 5% auto;
        padding: 0;
        border-radius: 20px;
        width: 90%;
        max-width: 500px;
        position: relative;
        box-shadow: 0 25px 50px rgba(0, 0, 0, 0.5);
        animation: modalSlideIn 0.3s ease-out;
        max-height: 90vh;
        overflow-y: auto;
      }

      @keyframes modalSlideIn {
        from {
          opacity: 0;
          transform: translateY(-50px);
        }
        to {
          opacity: 1;
          transform: translateY(0);
        }
      }

      .close-modal {
        position: absolute;
        right: 1.5rem;
        top: 1.5rem;
        color: #666;
        font-size: 2rem;
        cursor: pointer;
        z-index: 10;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        border: none;
      }

      .close-modal:hover {
        color: #ff4444;
        transform: rotate(90deg);
        background: rgba(255, 255, 255, 1);
      }

      .form-message {
        padding: 0.8rem 1rem;
        border-radius: 8px;
        margin-bottom: 1rem;
        font-size: 0.9rem;
        display: none;
      }

      .form-message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
        display: block;
      }

      .form-message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
        display: block;
      }

      .bg-credit {
        position: absolute;
        bottom: 10px;
        right: 10px;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.8rem;
        text-decoration: none;
        background: rgba(0, 0, 0, 0.3);
        padding: 4px 8px;
        border-radius: 4px;
        transition: all 0.3s ease;
      }

      .bg-credit:hover {
        color: white;
        background: rgba(0, 0, 0, 0.5);
      }

      @media (max-width: 768px) {
        .login-container {
          padding: 2.5rem;
          margin: 1rem;
        }

        .logo-container h1 {
          font-size: 2.3rem;
        }

        .form-options {
          flex-direction: column;
          gap: 1rem;
          align-items: flex-start;
        }

        .modal-content {
          margin: 10% auto;
          width: 95%;
        }

        .bg-credit {
          display: none;
        }
      }

      @media (max-width: 480px) {
        .login-container {
          padding: 2rem 1.5rem;
        }

        .logo-container h1 {
          font-size: 2rem;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
          padding: 1rem 1.2rem 1rem 3rem;
          font-size: 16px;
        }

        .input-with-icon i {
          left: 1.2rem;
        }

        .login-btn-submit {
          padding: 1.1rem 1.5rem;
          font-size: 1.1rem;
        }
      }

      .loading {
        position: relative;
        pointer-events: none;
      }

      .loading::after {
        content: "";
        position: absolute;
        top: 50%;
        left: 50%;
        width: 20px;
        height: 20px;
        margin: -10px 0 0 -10px;
        border: 2px solid transparent;
        border-top: 2px solid #ffffff;
        border-radius: 50%;
        animation: spin 1s linear infinite;
      }

      @keyframes spin {
        0% {
          transform: rotate(0deg);
        }
        100% {
          transform: rotate(360deg);
        }
      }
    </style>
  </head>
  <body>
    <div class="login-page">
      <a
        href="https://unsplash.com/photos/brown-coffee-beans-on-white-ceramic-bowl-1495474472287"
        class="bg-credit"
        target="_blank"
        title="Photo by Unsplash"
      >
      </a>

      <div class="login-container">
        <div class="login-header">
          <div class="logo-container">
            <h1>Beranda<span>Coffee</span></h1>
            <p class="welcome-text">Selamat Datang Kembali</p>
            <p>Masuk ke akun Anda dan nikmati pengalaman kopi terbaik</p>
          </div>
        </div>

        <div class="form-message" id="formMessage"></div>
        <form class="login-form" id="loginForm">
          <div class="form-group">
            <label for="email">Alamat Email</label>
            <div class="input-with-icon">
              <input
                type="email"
                id="email"
                name="email"
                placeholder="nama@email.com"
                required
                autocomplete="email"
              />
            </div>
          </div>
          <div class="form-group">
            <label for="password">Password</label>
            <div class="input-with-icon">
              <input
                type="password"
                id="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
                minlength="6"
              />
            </div>
          </div>
          <div class="form-options">
            <label class="remember-me">
              <input type="checkbox" name="remember" />
              Ingat saya
            </label>
            <a href="#" class="forgot-password" id="forgotPasswordLink">
              Lupa password?
            </a>
          </div>

          <button type="submit" class="login-btn-submit" id="loginSubmit">
            <i data-feather="log-in"></i>
            Masuk ke Akun
          </button>
        </form>
        <div class="login-footer">
          <p>
            Belum punya akun?
            <a href="#" class="login-link" id="registerLink">Daftar di sini</a>
          </p>
        </div>
      </div>
    </div>

    <div id="registerModal" class="modal">
      <div class="modal-content">
        <button class="close-modal" id="closeRegister">&times;</button>
        <div
          class="login-container"
          style="box-shadow: none; background: white; padding: 2.5rem"
        >
          <div class="login-header">
            <div class="logo-container">
              <h1>Daftar<span>Akun</span></h1>
              <p>Buat akun baru untuk pengalaman terbaik</p>
            </div>
          </div>

          <div class="form-message" id="registerMessage"></div>
          <form class="login-form" id="registerForm">
            <div class="form-group">
              <label for="regName">Nama Lengkap</label>
              <div class="input-with-icon">
                <input
                  type="text"
                  id="regName"
                  name="name"
                  placeholder="Masukkan nama lengkap"
                  required
                  autocomplete="name"
                />
              </div>
            </div>
            <div class="form-group">
              <label for="regEmail">Alamat Email</label>
              <div class="input-with-icon">
                <input
                  type="email"
                  id="regEmail"
                  name="email"
                  placeholder="nama@email.com"
                  required
                  autocomplete="email"
                />
              </div>
            </div>
            <div class="form-group">
              <label for="regPassword">Password</label>
              <div class="input-with-icon">
                <input
                  type="password"
                  id="regPassword"
                  name="password"
                  placeholder="Minimal 6 karakter"
                  required
                  autocomplete="new-password"
                  minlength="6"
                />
              </div>
            </div>
            <div class="form-group">
              <label for="regConfirmPassword">Konfirmasi Password</label>
              <div class="input-with-icon">
                <input
                  type="password"
                  id="regConfirmPassword"
                  name="confirmPassword"
                  placeholder="Ulangi password"
                  required
                  autocomplete="new-password"
                  minlength="6"
                />
              </div>
            </div>

            <button type="submit" class="login-btn-submit" id="registerSubmit">
              <i data-feather="user-plus"></i>
              Daftar Sekarang
            </button>
          </form>
        </div>
      </div>
    </div>

    <div id="forgotPasswordModal" class="modal">
      <div class="modal-content">
        <button class="close-modal" id="closeForgotPassword">&times;</button>
        <div
          class="login-container"
          style="box-shadow: none; background: white; padding: 2.5rem"
        >
          <div class="login-header">
            <div class="logo-container">
              <h1>Lupa<span>Password</span></h1>
              <p>Masukkan email untuk reset password</p>
            </div>
          </div>

          <div class="form-message" id="forgotPasswordMessage"></div>
          <form class="login-form" id="forgotPasswordForm">
            <div class="form-group">
              <label for="resetEmail">Alamat Email</label>
              <div class="input-with-icon">
                <input
                  type="email"
                  id="resetEmail"
                  name="email"
                  placeholder="nama@email.com"
                  required
                  autocomplete="email"
                />
              </div>
            </div>

            <button
              type="submit"
              class="login-btn-submit"
              id="forgotPasswordSubmit"
            >
              <i data-feather="send"></i>
              Kirim Link Reset
            </button>
          </form>
          <div class="login-footer">
            <p>
              Ingat password?
              <a href="#" class="login-link" id="backToLogin">
                Kembali ke login
              </a>
            </p>
          </div>
        </div>
      </div>
    </div>

    <script>
      feather.replace();

      const registerModal = document.getElementById("registerModal");
      const forgotPasswordModal = document.getElementById(
        "forgotPasswordModal"
      );
      const registerLink = document.getElementById("registerLink");
      const forgotPasswordLink = document.getElementById("forgotPasswordLink");
      const closeRegister = document.getElementById("closeRegister");
      const closeForgotPassword = document.getElementById(
        "closeForgotPassword"
      );
      const backToLogin = document.getElementById("backToLogin");

      const formMessage = document.getElementById("formMessage");
      const registerMessage = document.getElementById("registerMessage");
      const forgotPasswordMessage = document.getElementById(
        "forgotPasswordMessage"
      );

      function showMessage(element, message, type) {
        element.textContent = message;
        element.className = `form-message ${type}`;
        element.style.display = "block";

        if (type === "success") {
          setTimeout(() => {
            element.style.display = "none";
          }, 5000);
        }
      }

      registerLink.addEventListener("click", function (e) {
        e.preventDefault();
        registerModal.style.display = "block";
        registerMessage.style.display = "none";
      });

      forgotPasswordLink.addEventListener("click", function (e) {
        e.preventDefault();
        forgotPasswordModal.style.display = "block";
        forgotPasswordMessage.style.display = "none";
      });

      closeRegister.addEventListener("click", function () {
        registerModal.style.display = "none";
      });

      closeForgotPassword.addEventListener("click", function () {
        forgotPasswordModal.style.display = "none";
      });

      backToLogin.addEventListener("click", function (e) {
        e.preventDefault();
        forgotPasswordModal.style.display = "none";
      });

      window.addEventListener("click", function (e) {
        if (e.target === registerModal) {
          registerModal.style.display = "none";
        }
        if (e.target === forgotPasswordModal) {
          forgotPasswordModal.style.display = "none";
        }
      });

      function formatPhoneNumber(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
          input.addEventListener("input", function (e) {
            let value = e.target.value.replace(/\D/g, "");
            if (value.startsWith("0")) {
              value = value.substring(1);
            }
            if (value.length > 0) {
              value = "0" + value;
            }
            e.target.value = value;
          });
        }
      }

      formatPhoneNumber("regPhone");

      function setLoading(button, isLoading) {
        if (isLoading) {
          button.classList.add("loading");
          button.disabled = true;
        } else {
          button.classList.remove("loading");
          button.disabled = false;
        }
      }

      document
        .getElementById("loginForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const email = document.getElementById("email").value.trim();
          const password = document.getElementById("password").value;
          const submitBtn = document.getElementById("loginSubmit");

          if (!email || !password) {
            showMessage(formMessage, "Harap lengkapi semua field!", "error");
            return;
          }

          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(email)) {
            showMessage(
              formMessage,
              "Harap masukkan alamat email yang valid!",
              "error"
            );
            return;
          }

          if (password.length < 6) {
            showMessage(
              formMessage,
              "Password harus minimal 6 karakter!",
              "error"
            );
            return;
          }

          setLoading(submitBtn, true);

          setTimeout(() => {
            setLoading(submitBtn, false);
            showMessage(
              formMessage,
              "Login berhasil! Mengalihkan...",
              "success"
            );

            setTimeout(() => {
              window.location.href = "/home";
            }, 2000);
          }, 1500);
        });

      document
        .getElementById("registerForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const name = document.getElementById("regName").value.trim();
          const email = document.getElementById("regEmail").value.trim();
          const phone = document.getElementById("regPhone").value.trim();
          const address = document.getElementById("regAddress").value.trim();
          const password = document.getElementById("regPassword").value;
          const confirmPassword =
            document.getElementById("regConfirmPassword").value;
          const submitBtn = document.getElementById("registerSubmit");

          if (
            !name ||
            !email ||
            !phone ||
            !address ||
            !password ||
            !confirmPassword
          ) {
            showMessage(
              registerMessage,
              "Harap lengkapi semua field!",
              "error"
            );
            return;
          }

          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(email)) {
            showMessage(
              registerMessage,
              "Harap masukkan alamat email yang valid!",
              "error"
            );
            return;
          }

          const phoneRegex = /^08[1-9][0-9]{7,10}$/;
          if (!phoneRegex.test(phone)) {
            showMessage(
              registerMessage,
              "Harap masukkan nomor telepon yang valid!",
              "error"
            );
            return;
          }

          if (password.length < 6) {
            showMessage(
              registerMessage,
              "Password harus minimal 6 karakter!",
              "error"
            );
            return;
          }

          if (password !== confirmPassword) {
            showMessage(
              registerMessage,
              "Konfirmasi password tidak sesuai!",
              "error"
            );
            return;
          }

          setLoading(submitBtn, true);

          setTimeout(() => {
            setLoading(submitBtn, false);
            showMessage(
              registerMessage,
              "Pendaftaran berhasil! Silakan login dengan akun Anda.",
              "success"
            );

            setTimeout(() => {
              registerModal.style.display = "none";
              this.reset();
            }, 3000);
          }, 1500);
        });

      document
        .getElementById("forgotPasswordForm")
        .addEventListener("submit", function (e) {
          e.preventDefault();

          const email = document.getElementById("resetEmail").value.trim();
          const submitBtn = document.getElementById("forgotPasswordSubmit");

          if (!email) {
            showMessage(
              forgotPasswordMessage,
              "Harap masukkan alamat email!",
              "error"
            );
            return;
          }

          const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
          if (!emailRegex.test(email)) {
            showMessage(
              forgotPasswordMessage,
              "Harap masukkan alamat email yang valid!",
              "error"
            );
            return;
          }

          setLoading(submitBtn, true);

          setTimeout(() => {
            setLoading(submitBtn, false);
            showMessage(
              forgotPasswordMessage,
              "Link reset password telah dikirim ke email Anda!",
              "success"
            );

            setTimeout(() => {
              forgotPasswordModal.style.display = "none";
              this.reset();
            }, 3000);
          }, 1500);
        });

      document.querySelectorAll("input").forEach((input) => {
        input.addEventListener("blur", function () {
          if (this.value.trim() === "") {
            this.style.borderColor = "#e8e8e8";
          } else if (this.checkValidity()) {
            this.style.borderColor = "#4CAF50";
          } else {
            this.style.borderColor = "#f44336";
          }
        });
      });

      registerLink.addEventListener("click", function () {
        setTimeout(() => feather.replace(), 100);
      });

      forgotPasswordLink.addEventListener("click", function () {
        setTimeout(() => feather.replace(), 100);
      });
    </script>
  </body>
</html>
