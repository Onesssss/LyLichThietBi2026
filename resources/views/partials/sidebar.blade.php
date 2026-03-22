<!-- Sidebar -->
<aside class="sidebar" id="sidebar">
    <div class="logo-area">
        <a href="{{ url('/trang-chu') }}" style="text-decoration: none; color: inherit;">
            <h2>
                <i class="fas fa-chart-line"></i> 
                <span>TOÀN HỆ THỐNG</span>
            </h2>
        </a>
    </div>
    <div class="nav-menu">
        <div class="nav-item active" data-page="dashboard">
            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
        </div>
        <div class="nav-divider">TÀI KHOẢN</div>
        <div class="nav-item" data-page="branches">
            <a href="{{ route('branches.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-building"></i> <span>Xí nghiệp</span>
            </a>
        </div>
        <div class="nav-item" data-page="department">
            <a href="{{ route('departments.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-building"></i> <span>Cung/Trạm</span>
            </a>
        </div>
        <div class="nav-item" data-page="admin">
            <a href="{{ route('admins.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-building"></i> <span>Người dùng</span>
            </a>
        </div>
        @if(in_array(session('role_id'), [0, 1]))
        <li class="nav-item">
            <a class="nav-link" href="{{ route('password-requests.index') }}">
                <i class="fas fa-key"></i> <span>Yêu cầu đặt lại MK</span>
                @php
                    $pendingCount = \App\Models\PasswordResetRequest::where('status', 0)->count();
                @endphp
                @if($pendingCount > 0)
                    <span class="badge bg-danger" style="float: right;">{{ $pendingCount }}</span>
                @endif
            </a>
        </li>
        @endif
        <div class="nav-item" data-page="notification">
            <i class="fas fa-bell"></i> <span>Thông báo</span>
        </div>
    </div>

    <!-- Admin Card -->
    <div class="admin-card">
        <div class="admin-info">
            <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
            <div class="admin-details">
                @php
                    $roleNames = [0 => 'Nhân viên', 1 => 'Quản lý', 2 => 'Admin', 3 => 'Công nhân'];
                    $roleId = session('role_id');
                    $loginTime = session('login_time') ?? date('H:i:s d/m/Y');
                @endphp
                <span>Xin chào, <strong>{{ session('username') }}</strong> ({{ $roleNames[$roleId] ?? 'Khách' }})</span>
                <p>Đăng nhập lúc: {{ $loginTime }}</p>
            </div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin:0">
            @csrf
            <button class="logout-btn" type="submit">
                <i class="fas fa-sign-out-alt"></i> <span>Đăng xuất</span>
            </button>
        </form>
    </div>
</aside>