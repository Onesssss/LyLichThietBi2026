<!doctype html>
<html lang="vi">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  
  <title>Đăng nhập — Quản Lý Thiết Bị</title>

  
  <!-- 🔥 SỬA ĐƯỜNG DẪN CSS -->
  <link rel="stylesheet" href="{{ asset('css/style_login.css') }}">
  
  <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>🚄</text></svg>">
</head>
<body>

  <!-- 🔥 GIỮ NGUYÊN PHẦN HTML & CSS -->
  <div class="scene" aria-hidden="true">
    <svg class="road" viewBox="0 0 1600 520" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg">
      <defs>
        <linearGradient id="g1" x1="0" x2="1">
          <stop offset="0" stop-color="#a8d7ff"/>
          <stop offset="1" stop-color="#7fc2ff"/>
        </linearGradient>
      </defs>
      <rect width="1600" height="520" fill="url(#g1)" />
      <path d="M200 40 C 420 160, 1180 160, 1400 40 L 1500 520 L 100 520 Z" fill="#7bbaf0" opacity="0.6"/>
      <g stroke="#ffffff" stroke-width="8" stroke-linecap="round" stroke-dasharray="40 30" opacity="0.9">
        <path d="M360 92 C 620 170, 980 170, 1240 92" fill="none"/>
        <path d="M400 130 C 640 200, 960 200, 1200 130" fill="none" opacity="0.55"/>
      </g>
    </svg>
  </div>

  <main class="card" role="main" aria-labelledby="title">
    <div class="brand">
      <div class="logo">ĐS</div>
      <div>
        <h1 id="title">Đăng nhập hệ thống</h1>

      </div>
    </div>

    <!-- 🔥 HIỂN THỊ LỖI -->
    @if(!empty($error))
    <div class="error-message">
      {{ $error }}
    </div>
    @endif

    <!-- 🔥 SỬA FORM ACTION -->
    <form id="loginForm" method="POST" action="{{ route('login.submit') }}" autocomplete="on">
      @csrf <!-- 🔥 QUAN TRỌNG: Laravel CSRF protection -->
      
      <div>
        <label for="email">Email</label>
        <div class="input">
          <input id="email" name="email" type="email" placeholder="name@domain.com" 
                 value="{{ old('email', $email ?? '') }}" required />
        </div>
      </div>

      <div>
        <label for="password">Mật khẩu</label>
        <div class="input">
          <input id="password" name="password" type="password" placeholder="Nhập mật khẩu" required />
          <span id="togglePassword" class="toggle-eye">👁️</span>
        </div>
      </div>

      <div class="meta">
        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:var(--muted)">
          <input type="checkbox" name="remember"/> Ghi nhớ
        </label>

          <!-- 🔥 NÚT QUÊN MẬT KHẨU -->
      <div class="text-center mt-3">
          <a href="{{ route('forgot-password.form') }}" style="color: #667eea; text-decoration: none;">
              <i class="fas fa-key"></i> Quên mật khẩu?
          </a>
      </div>
      </div>

      <div style="margin-top:8px;display:flex;gap:10px">
        <button class="btn" type="submit">Đăng nhập</button>
      </div>
                <P>Tài khoản Admin quản lý toàn hệ thống, mỗi cung, trạm có một tài khoản riêng</P>
    </form>
  </main>

  <!-- 🔥 GIỮ NGUYÊN JAVASCRIPT -->
  <script>
    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
      const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
      passwordInput.setAttribute('type', type);
      togglePassword.textContent = type === 'password' ? '👁️' : '🙈';
    });

    if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
  </script>

</body>
</html>