@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-users"></i> Quản lý người dùng</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>


    <div style="margin-bottom: 20px; display: flex; gap: 10px; justify-content: space-between;">
        <button type="button" onclick="toggleFilter()"
            style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
            <i class="fas fa-filter"></i>
            <span id="filterToggleText">Hiện bộ lọc</span>
        </button>

        <a href="{{ route('admins.create') }}"
            style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                   color: white; padding: 10px 20px; border-radius: 8px;
                   text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm người dùng
        </a>
    </div>


    <div id="filterForm" style="display: none; background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="GET" action="{{ route('admins.index') }}">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-search" style="color: #667eea;"></i> Tìm kiếm
                    </label>
                    <input type="text" name="search" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                        value="{{ request('search') }}"
                        placeholder="Tìm theo tên đăng nhập hoặc email..."
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102,126,234,0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-user-tag" style="color: #667eea;"></i> Vai trò
                    </label>
                    <select name="role_id" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('role_id') == '1' ? 'selected' : '' }}>🛡️ Quản Lý Công Ty</option>
                        <option value="2" {{ request('role_id') == '2' ? 'selected' : '' }}>👤 Quản Lý Xí Nghiệp</option>
                        <option value="3" {{ request('role_id') == '3' ? 'selected' : '' }}>👋 Tổ Trưởng tổ SX</option>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-factory" style="color: #667eea;"></i> Xí nghiệp
                    </label>
                    <select name="branch_id" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ request('branch_id') == $branch->id ? 'selected' : '' }}>
                                🏭 {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-chart-line" style="color: #667eea;"></i> Trạng thái
                    </label>
                    <select name="status" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>✅ Hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>❌ Vô hiệu</option>
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 25px; padding-top: 10px; border-top: 1px solid #f0f0f0;">
                <a href="{{ route('admins.index') }}" 
                style="background: #f8f9fa; color: #6c757d; padding: 8px 20px; border-radius: 8px; text-decoration: none; font-size: 14px; transition: all 0.3s; display: inline-flex; align-items: center; gap: 8px;"
                onmouseover="this.style.backgroundColor='#e9ecef'"
                onmouseout="this.style.backgroundColor='#f8f9fa'">
                    <i class="fas fa-times"></i> Xóa lọc
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

    
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px 20px;
                border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <!-- NOTE -->
    <div style="margin-bottom: 20px;">
        <i class="fas fa-database"></i>
        <span><strong>Danh sách người dùng:</strong> Quản lý tài khoản hệ thống.</span>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 12px;
                padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Tên đăng nhập</th>
                    <th style="padding: 12px;">Mật khẩu</th>
                    <th style="padding: 12px;">Họ tên</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Vai trò</th>
                    <th style="padding: 12px;">Xí nghiệp</th>
                    <th style="padding: 12px; text-align:center;">Trạng thái</th>
                    <th style="padding: 12px; text-align:center;">Thao tác</th>
                </tr>
            </thead>

            <tbody>
                @php
                    $roles = [0 => 'Admin', 1 => 'Quản Lý Công Ty', 2 => 'Quản Lý Xí Nghiệp', 3 => 'Tổ Trưởng tổ Sản Xuất'];
                @endphp

                @forelse($admins as $admin)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $loop->iteration }}</td>

                    <td style="padding: 12px;">
                        {{ $admin->username }}
                    </td>
                    <td style="padding: 12px;">{{ $admin->password }}</td> 

                    <td style="padding: 12px;">{{ $admin->full_name }}</td>

                    <td style="padding: 12px;">{{ $admin->email }}</td>

                    <td style="padding: 12px;">
                        <span style="background:
                            @if($admin->role_id == 0) #dc3545
                            @elseif($admin->role_id == 1) #ffc107
                            @elseif($admin->role_id == 2) #17a2b8
                            @else #6c757d
                            @endif;
                            color: white; padding: 4px 10px; border-radius: 20px;">
                            {{ $roles[$admin->role_id] ?? 'Khác' }}
                        </span>
                    </td>

                    <td style="padding: 12px;">
                        <span style="background: #e9ecef; padding: 4px 10px; border-radius: 20px;">
                            {{ $admin->branch->name ?? '---' }}
                        </span>
                    </td>

                    <td style="padding: 12px; text-align:center;">
                        @if($admin->status == 1)
                            <span style="background:#28a745; color:white; padding:4px 10px; border-radius:20px;">
                                Hoạt động
                            </span>
                        @else
                            <span style="background:#dc3545; color:white; padding:4px 10px; border-radius:20px;">
                                Vô hiệu
                            </span>
                        @endif
                    </td>

                    <td style="padding: 12px; text-align:center;">
                        <a href="{{ route('admins.edit', $admin->id) }}"
                            style="background:#ffc107; color:#212529; padding:5px 12px;
                                   border-radius:5px; text-decoration:none; font-size:13px; margin-right:5px;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>

                        <form action="{{ route('admins.destroy', $admin->id) }}"
                            method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button
                                style="background:#dc3545; color:white; padding:5px 12px;
                                       border-radius:5px; border:none; font-size:13px;"
                                onclick="return confirm('Xóa?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>

                @empty
                <tr>
                    <td colspan="8"
                        style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x d-block mb-2"></i>
                        Không có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="font-size:14px; color:#6c757d;">
                Hiển thị {{ $admins->firstItem() ?? 0 }}
                đến {{ $admins->lastItem() ?? 0 }}
                của {{ $admins->total() }} bản ghi
            </div>
            <div>{{ $admins->links() }}</div>
        </div>
    </div>
</main>

<script>
function updateDateTime() {
    const now = new Date();
    document.getElementById('dateText').innerHTML =
        now.toLocaleDateString('vi-VN');
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

@if(count(request()->all()) > 0 && !request()->has('page'))
    document.getElementById('filterForm').style.display = 'block';
    document.getElementById('filterToggleText').innerHTML = 'Ẩn bộ lọc';
@endif
</script>

</body>
</html>