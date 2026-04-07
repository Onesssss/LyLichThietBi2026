@include('partials.header')
@include('partials.sidebar')

<!-- Main Content -->
<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-building"></i> Quản lý phòng ban</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- ========== NÚT LỌC (BẬP/TẮT) ========== -->
    <div style="margin-bottom: 20px; display: flex; gap: 10px; justify-content: space-between;">
        <button type="button" class="btn btn-outline-primary" onclick="toggleFilter()" style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
            <i class="fas fa-filter"></i> 
            <span id="filterToggleText">Hiện bộ lọc</span>
        </button>
        <a href="{{ route('departments.create') }}" class="btn-add" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm phòng ban mới
        </a>
    </div>

    <!-- ========== FORM LỌC CHI TIẾT (ẨN/HIỆN) ========== -->
    <div id="filterForm" style="display: none; background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="GET" action="{{ route('departments.index') }}">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-building" style="color: #667eea;"></i> Tên phòng ban
                    </label>
                    <input type="text" name="name" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                        value="{{ request('name') }}" 
                        placeholder=""
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102,126,234,0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>
                
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-factory" style="color: #667eea;"></i> Xí nghiệp
                    </label>
                    <select name="branch_id" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Chọn xí nghiệp --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                🏭 {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 25px; padding-top: 10px; border-top: 1px solid #f0f0f0;">
                <a href="{{ route('departments.index') }}" 
                style="background: #f8f9fa; color: #6c757d; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;"
                onmouseover="this.style.backgroundColor='#e9ecef'"
                onmouseout="this.style.backgroundColor='#f8f9fa'">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
                <button type="submit" 
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 8px 24px; border-radius: 8px; border: none; font-size: 14px; cursor: pointer; transition: transform 0.2s; display: inline-flex; align-items: center; gap: 8px;"
                        onmouseover="this.style.transform='translateY(-1px)'"
                        onmouseout="this.style.transform='translateY(0)'">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </form>
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
        <span><strong>Danh sách phòng ban:</strong> Quản lý các phòng ban theo từng xí nghiệp.</span>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table class="device-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px; text-align: left; width: 80px;">
                        <a href="?sort_by=id&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}&{{ http_build_query(request()->except('sort_by', 'sort_order')) }}" style="color: #495057; text-decoration: none;">ID</a>
                    </th>
                    <th style="padding: 12px; text-align: left;">
                        <a href="?sort_by=branch_id&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}&{{ http_build_query(request()->except('sort_by', 'sort_order')) }}" style="color: #495057; text-decoration: none;">Xí nghiệp</a>
                    </th>
                    <th style="padding: 12px; text-align: left;">
                        <a href="?sort_by=name&sort_order={{ request('sort_order') == 'asc' ? 'desc' : 'asc' }}&{{ http_build_query(request()->except('sort_by', 'sort_order')) }}" style="color: #495057; text-decoration: none;">Tên phòng ban</a>
                    </th>
                    <th style="padding: 12px; text-align: center; width: 150px;">Thao tác</th>
                 </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $loop->iteration }}</td>
                    <td style="padding: 12px;">
                        <span class="badge" style="background: #e9ecef; color: #495057; padding: 4px 10px; border-radius: 20px;">
                            <i class="fas fa-building"></i> {{ $department->branch->name }}
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        <strong><i class="fas fa-door-open"></i> {{ $department->name }}</strong>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('departments.edit', $department->id) }}" style="background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 5px; display: inline-block;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('departments.destroy', $department->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; padding: 5px 12px; border-radius: 5px; border: none; font-size: 13px; cursor: pointer;" onclick="return confirm('Bạn có chắc muốn xóa phòng ban {{ $department->name }}?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x mb-2 d-block" style="color: #adb5bd;"></i>
                        Chưa có dữ liệu phòng ban
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        
        <!-- ========== PHÂN TRANG ========== -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="font-size: 14px; color: #6c757d;">Hiển thị {{ $departments->firstItem() ?? 0 }} đến {{ $departments->lastItem() ?? 0 }} của {{ $departments->total() }} bản ghi</div>
            <div>{{ $departments->links() }}</div>
        </div>
    </div>
    
    <footer style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef; font-size: 13px; color: #6c757d;">
        <i class="fas fa-chart-simple"></i> Quản lý phòng ban • Tổng số: <strong>{{ $departments->total() }}</strong> phòng ban
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

    function toggleFilter() {
        var filterDiv = document.getElementById('filterForm');
        var toggleText = document.getElementById('filterToggleText');
        if (filterDiv.style.display === 'none') {
            filterDiv.style.display = 'block';
            toggleText.innerHTML = 'Ẩn bộ lọc';
        } else {
            filterDiv.style.display = 'none';
            toggleText.innerHTML = 'Hiện bộ lọc';
        }
    }
    
    // Nếu có tham số lọc, tự động hiện form
    @if(count(request()->all()) > 0 && !request()->has('page'))
        document.getElementById('filterForm').style.display = 'block';
        document.getElementById('filterToggleText').innerHTML = 'Ẩn bộ lọc';
    @endif

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