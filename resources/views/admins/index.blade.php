@include('partials.header')
@include('partials.sidebar')

<!-- Main Content -->
<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-users"></i> Quản lý người dùng</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- Nút thêm mới -->
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('admins.create') }}" class="btn-add" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm người dùng mới
        </a>
    </div>

    <!-- Thông báo -->
    @if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <!-- Bảng danh sách -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-database"></i>
        <span><strong>Danh sách người dùng:</strong> Quản lý tài khoản trong hệ thống.</span>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table class="device-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px; text-align: left; width: 50px;">ID</th>
                    <th style="padding: 12px; text-align: left;">Tên đăng nhập</th>
                    <th style="padding: 12px; text-align: left;">Họ tên</th>
                    <th style="padding: 12px; text-align: left;">Email</th>
                    <th style="padding: 12px; text-align: left;">Vai trò</th>
                    <th style="padding: 12px; text-align: left;">Xí nghiệp</th>
                    <th style="padding: 12px; text-align: left;">Phòng ban</th>
                    <th style="padding: 12px; text-align: center;">Trạng thái</th>
                    <th style="padding: 12px; text-align: center; width: 120px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $roles = [
                        0 => 'Admin',
                        1 => 'Moderator',
                        2 => 'User',
                        3 => 'Guest'
                    ];
                @endphp
                @forelse($admins as $admin)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $admin->id }}</td>
                    <td style="padding: 12px;"><strong>{{ $admin->username }}</strong></td>
                    <td style="padding: 12px;">{{ $admin->full_name }}</td>
                    <td style="padding: 12px;">{{ $admin->email }}</td>
                    <td style="padding: 12px;">
                        <span class="badge" style="background: 
                            @if($admin->role_id == 0) #dc3545 
                            @elseif($admin->role_id == 1) #ffc107 
                            @elseif($admin->role_id == 2) #17a2b8 
                            @else #6c757d 
                            @endif; color: white; padding: 4px 10px; border-radius: 20px;">
                            {{ $roles[$admin->role_id] ?? 'Không xác định' }}
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        @if($admin->branch)
                            <i class="fas fa-building"></i> {{ $admin->branch->name }}
                        @else
                            <span style="color: #999;">Chưa có</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        @if($admin->department)
                            <i class="fas fa-door-open"></i> {{ $admin->department->name }}
                        @else
                            <span style="color: #999;">Chưa có</span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        @if($admin->status == 1)
                            <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-check-circle"></i> Hoạt động
                            </span>
                        @else
                            <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-ban"></i> Vô hiệu
                            </span>
                        @endif
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('admins.edit', $admin->id) }}" style="background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 5px; display: inline-block;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('admins.destroy', $admin->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; padding: 5px 12px; border-radius: 5px; border: none; font-size: 13px; cursor: pointer;" onclick="return confirm('Bạn có chắc muốn xóa người dùng {{ $admin->username }}?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x mb-2 d-block" style="color: #adb5bd;"></i>
                        Chưa có dữ liệu người dùng
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <footer style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef; font-size: 13px; color: #6c757d;">
        <i class="fas fa-users"></i> Quản lý người dùng • Tổng số: <strong>{{ $admins->count() }}</strong> tài khoản
    </footer>
</main>

<script>
    function updateDateTime() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
        document.getElementById('dateText').innerHTML = `${dateStr}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 60000);

          // ==================== RESPONSIVE SIDEBAR ====================
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        }
        
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('active');
        }
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', openSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        
        // Đóng sidebar khi click vào nav-item trên mobile
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
</script>
</body>
</html>