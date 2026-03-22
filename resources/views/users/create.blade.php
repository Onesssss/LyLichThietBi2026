{{-- <!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thêm người dùng - Quản lý thiết bị</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    
    <style>
        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 1rem;
            margin-bottom: 30px;
        }
        .navbar-brand {
            color: white !important;
            font-weight: bold;
        }
        .form-container {
            max-width: 700px;
            margin: 0 auto;
        }
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 30px;
            border: none;
        }
        .form-header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 20px;
        }
        .form-header h3 {
            color: #333;
            font-weight: 600;
            font-size: 24px;
        }
        .form-header p {
            color: #666;
            font-size: 14px;
        }
        .form-label {
            font-weight: 500;
            color: #444;
            margin-bottom: 8px;
            font-size: 14px;
        }
        .required-star {
            color: #dc3545;
            margin-left: 3px;
        }
        .form-control, .form-select {
            border-radius: 12px;
            border: 1.5px solid #e0e0e0;
            padding: 12px 15px;
            font-size: 14px;
            transition: all 0.3s;
        }
        .form-control:focus, .form-select:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.15);
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 14px 30px;
            border-radius: 12px;
            border: none;
            font-weight: 600;
            width: 100%;
            font-size: 16px;
            transition: all 0.3s;
            margin-top: 20px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-back {
            padding: 12px 25px;
            border-radius: 12px;
            border: 1.5px solid #e0e0e0;
            background: white;
            color: #666;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-back:hover {
            background: #f8f9fa;
            border-color: #667eea;
            color: #667eea;
        }
        .alert {
            border-radius: 12px;
            margin-bottom: 25px;
            padding: 15px 20px;
        }
        .form-row {
            margin-bottom: 20px;
        }
        .status-group {
            display: flex;
            gap: 20px;
            padding: 10px 0;
        }
        .status-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .status-option input[type="radio"] {
            width: 18px;
            height: 18px;
        }
        .status-option label {
            margin: 0;
            font-size: 14px;
        }
        .badge-role {
            font-size: 12px;
            padding: 5px 10px;
            border-radius: 20px;
        }
    </style>
</head>
<body>
    <!-- Navbar đơn giản -->
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <i class="fas fa-train me-2"></i>Quản lý thiết bị đường sắt
            </a>
            <div class="text-white">
                <i class="fas fa-user-circle me-1"></i>
                <span>{{ session('username') }}</span>
            </div>
        </div>
    </nav>

    <!-- Form thêm người dùng -->
    <div class="container form-container">
        <!-- Nút quay lại -->
        <div class="mb-3">
            <a href="{{ route('home') }}" class="btn-back">
                <i class="fas fa-arrow-left me-2"></i>Quay lại trang chủ
            </a>
        </div>

        <!-- Thông báo -->
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        @endif

        <!-- Form -->
        <div class="form-card">
            <div class="form-header">
                <h3><i class="fas fa-user-plus me-2 text-primary"></i>Thêm người dùng mới</h3>
                <p class="mb-0">Nhập thông tin chi tiết để tạo tài khoản</p>
            </div>

            <form method="POST" action="{{ route('users.store') }}">
                @csrf

                <!-- Username & Fullname -->
                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="form-label">Tên đăng nhập <span class="required-star">*</span></label>
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" 
                               value="{{ old('username') }}" placeholder="Nhập tên đăng nhập" required>
                        @error('username')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="form-label">Họ và tên <span class="required-star">*</span></label>
                        <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                               value="{{ old('full_name') }}" placeholder="Nhập họ tên" required>
                        @error('fullname')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Email & Password -->
                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="form-label">Email <span class="required-star">*</span></label>
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                               value="{{ old('email') }}" placeholder="name@domain.com" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="form-label">Mật khẩu <span class="required-star">*</span></label>
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" 
                               placeholder="Ít nhất 6 ký tự" required>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Role & Branch -->
                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="form-label">Vai trò <span class="required-star">*</span></label>
                        <select name="role_id" class="form-select @error('role_id') is-invalid @enderror" required>
                            <option value="">-- Chọn vai trò --</option>
                            @foreach($roles as $value => $name)
                                <option value="{{ $value }}" {{ old('role_id') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('role_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="form-label">Xí nghiệp <span class="required-star">*</span></label>
                        <select name="branch_id" class="form-select @error('branch_id') is-invalid @enderror" required>
                            <option value="">-- Chọn xí nghiệp --</option>
                            @foreach($branches as $value => $name)
                                <option value="{{ $value }}" {{ old('branch_id') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Department & Status -->
                <div class="row">
                    <div class="col-md-6 form-row">
                        <label class="form-label">Phòng ban <span class="required-star">*</span></label>
                        <select name="dept_id" class="form-select @error('dept_id') is-invalid @enderror" required>
                            <option value="">-- Chọn phòng ban --</option>
                            @foreach($departments as $value => $name)
                                <option value="{{ $value }}" {{ old('dept_id') == $value ? 'selected' : '' }}>
                                    {{ $name }}
                                </option>
                            @endforeach
                        </select>
                        @error('dept_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-row">
                        <label class="form-label">Trạng thái <span class="required-star">*</span></label>
                        <div class="status-group">
                            <div class="status-option">
                                <input type="radio" name="status" value="1" id="status_active" 
                                       {{ old('status') == '1' ? 'checked' : '' }} checked>
                                <label for="status_active" class="text-success">
                                    <i class="fas fa-check-circle me-1"></i>Hoạt động
                                </label>
                            </div>
                            <div class="status-option">
                                <input type="radio" name="status" value="0" id="status_inactive"
                                       {{ old('status') == '0' ? 'checked' : '' }}>
                                <label for="status_inactive" class="text-danger">
                                    <i class="fas fa-ban me-1"></i>Vô hiệu
                                </label>
                            </div>
                        </div>
                        @error('status')
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn-submit">
                    <i class="fas fa-save me-2"></i>Tạo người dùng mới
                </button>
            </form>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Auto-hide alerts -->
    <script>
        setTimeout(function() {
            document.querySelectorAll('.alert').forEach(function(alert) {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(function() {
                    alert.style.display = 'none';
                }, 500);
            });
        }, 3000);
    </script>
</body>
</html> --}}