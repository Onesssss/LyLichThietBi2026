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
        <!-- Dashboard -->
        <div class="nav-item active" data-page="dashboard">
            <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
        </div>

        <!-- QUẢN LÝ TÀI KHOẢN -->
        @if(in_array(session('role_id'), [0, 1]))
        <div class="nav-divider">QUẢN LÝ TÀI KHOẢN</div>
        <!-- Xí nghiệp -->
        <div class="nav-item">
            <a href="{{ route('branches.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-building"></i> <span>Xí nghiệp</span>
            </a>
        </div>
        
        <!-- Cung/Trạm -->
        <div class="nav-item">
            <a href="{{ route('departments.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-building"></i> <span>Cung/Trạm</span>
            </a>
        </div>
        
        <!-- Chốt -->
        <div class="nav-item">
            <a href="{{ route('points.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-map-marker-alt"></i> <span>Chốt</span>
            </a>
        </div>
        
        <!-- Người dùng -->
        <div class="nav-item">
            <a href="{{ route('admins.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-user-shield"></i> <span>Người dùng</span>
            </a>
        </div>
        
        <!-- Yêu cầu đặt lại MK -->
        <div class="nav-item">
            <a href="{{ route('password-requests.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px; position: relative;">
                <i class="fas fa-key"></i> <span>Yêu cầu đặt lại MK</span>
                @php
                    $pendingCount = \App\Models\PasswordResetRequest::where('status', 0)->count();
                @endphp
                @if($pendingCount > 0)
                    <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px; margin-left: auto;">{{ $pendingCount }}</span>
                @endif
            </a>
        </div>
        @endif

        <!-- QUẢN LÝ THIẾT BỊ -->
        <div class="nav-divider">QUẢN LÝ THIẾT BỊ</div>
        
        <!-- Danh sách thiết bị -->
        <div class="nav-item">
            <a href="{{ route('equipment-lists.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-list"></i> <span>Danh sách thiết bị</span>
            </a>
        </div>
        
        <!-- Loại thiết bị -->
        <div class="nav-item">
            <a href="{{ route('equipment-categories.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-tags"></i> <span>Loại thiết bị</span>
            </a>
        </div>
        
        <!-- Thiết bị -->
        <div class="nav-item">
            <a href="{{ route('equipment-items.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px;">
                <i class="fas fa-microchip"></i> <span>Thiết bị</span>
            </a>
        </div>


        <div class="nav-divider">TIỆN ÍCH</div>
        <div class="nav-item">
            <a href="{{ route('notifications.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px; position: relative;">
                <i class="fas fa-bell"></i> <span>Thông báo</span>
                @php
                    $unreadCount = App\Http\Controllers\NotificationController::getUnreadCount();
                @endphp
                @if($unreadCount > 0)
                    <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px; margin-left: auto;">{{ $unreadCount }}</span>
                @endif
            </a>
        </div>
    </div>

    @if(in_array(session('role_id'), [0, 1]))
    <div class="nav-item">
        <a href="{{ route('admin.pending.index') }}" style="color: inherit; text-decoration: none; display: flex; align-items: center; gap: 12px; position: relative;">
            <i class="fas fa-tasks"></i> <span>Yêu cầu duyệt</span>
            @php
                $pendingCount = \App\Models\PendingEquipmentList::where('approval_status', 'pending')->count()
                    + \App\Models\PendingEquipmentCategory::where('approval_status', 'pending')->count()
                    + \App\Models\PendingEquipmentItem::where('approval_status', 'pending')->count();
            @endphp
            @if($pendingCount > 0)
                <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px; margin-left: auto;">{{ $pendingCount }}</span>
            @endif
        </a>
    </div>
    @endif

    <div class="admin-card">
        <div class="admin-info">
            <div class="admin-avatar"><i class="fas fa-user-shield"></i></div>
            <div class="admin-details">
                @php
                    $roleNames = [0 => 'Admin', 1 => 'Quản lý Cấp Cao', 2 => 'Quản lý xí nghiệp', 3 => 'Nhân viên'];
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

<style>

.sidebar .nav-item {
    margin: 4px 0;
    border-radius: 10px;
    transition: all 0.3s;
}

.sidebar .nav-item:hover {
    background: rgba(102, 126, 234, 0.15);
    transform: translateX(5px);
}

.sidebar .nav-item.active {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    box-shadow: 0 4px 12px rgba(102, 126, 234, 0.3);
}

.sidebar .nav-item a, 
.sidebar .nav-item > div {
    padding: 10px 15px;
    border-radius: 10px;
}

.sidebar .nav-divider {
    font-size: 11px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin: 15px 0 8px 0;
    color: #64748b;
}

.sidebar .nav-item i {
    width: 24px;
    font-size: 18px;
}

/* Badge cho yêu cầu */
.sidebar .nav-item .badge-count {
    background: #ef4444;
    color: white;
    padding: 2px 8px;
    border-radius: 20px;
    font-size: 11px;
    margin-left: auto;
    font-weight: normal;
}

/* Responsive cho mobile */
@media (max-width: 768px) {
    .sidebar {
        transform: translateX(-100%);
        transition: transform 0.3s ease;
        position: fixed;
        z-index: 1050;
        width: 280px;
        height: 100vh;
        overflow-y: auto;
    }
    
    .sidebar.open {
        transform: translateX(0);
    }
    
    .main-content {
        margin-left: 0 !important;
        width: 100% !important;
    }
    
    /* Overlay khi mở sidebar trên mobile */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        z-index: 1040;
        display: none;
    }
    
    .sidebar-overlay.active {
        display: block;
    }
}

/* Hover effect cho admin card */
.sidebar .admin-card {
    transition: all 0.3s;
}

.sidebar .admin-card:hover {
    background: rgba(0,0,0,0.4);
}

/* Animation cho logout button */
.sidebar .logout-btn {
    transition: all 0.3s;
}

.sidebar .logout-btn:hover {
    background: #dc2626;
    transform: scale(1.02);
}
</style>

<script>

function addOverlay() {
    if (!document.querySelector('.sidebar-overlay')) {
        const overlay = document.createElement('div');
        overlay.className = 'sidebar-overlay';
        overlay.onclick = () => {
            document.getElementById('sidebar').classList.remove('open');
            overlay.classList.remove('active');
        };
        document.body.appendChild(overlay);
    }
}
addOverlay();


function toggleSidebar() {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.querySelector('.sidebar-overlay');
    sidebar.classList.toggle('open');
    if (overlay) {
        overlay.classList.toggle('active');
    }
}


const existingToggle = document.querySelector('.sidebar-toggle, [data-toggle="sidebar"]');
if (existingToggle) {
    existingToggle.addEventListener('click', toggleSidebar);
} else {
    // Nếu chưa có, tạo nút toggle mới
    const toggleBtn = document.createElement('button');
    toggleBtn.innerHTML = '<i class="fas fa-bars"></i>';
    toggleBtn.style.cssText = `
        position: fixed;
        top: 15px;
        left: 15px;
        z-index: 1060;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border: none;
        border-radius: 8px;
        padding: 10px 14px;
        cursor: pointer;
        display: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
    `;
    toggleBtn.onclick = toggleSidebar;
    document.body.appendChild(toggleBtn);
    

    if (window.innerWidth <= 768) {
        toggleBtn.style.display = 'block';
    }
    window.addEventListener('resize', () => {
        toggleBtn.style.display = window.innerWidth <= 768 ? 'block' : 'none';
    });
}


document.querySelectorAll('.nav-item a, .nav-item > div').forEach(link => {
    link.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            setTimeout(() => {
                document.getElementById('sidebar').classList.remove('open');
                document.querySelector('.sidebar-overlay')?.classList.remove('active');
            }, 150);
        }
    });
});


const currentPath = window.location.pathname;
document.querySelectorAll('.nav-item a').forEach(link => {
    const href = link.getAttribute('href');
    if (href && currentPath === href) {
        link.closest('.nav-item').classList.add('active');
    }
});
</script>