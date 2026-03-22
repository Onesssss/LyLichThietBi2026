@include('partials.header')
@include('partials.sidebar')

<!-- Main Content -->
<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-building"></i> Quản lý xí nghiệp</h1>
        </div>
        <div class="date-badge" id="currentDate">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- Nút thêm mới -->
    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('branches.create') }}" class="btn-add" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm xí nghiệp mới
        </a>
    </div>

    <!-- Thông báo -->
    @if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <!-- Bảng danh sách xí nghiệp -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-database"></i>
        <span><strong>Danh sách xí nghiệp:</strong> Quản lý các xí nghiệp trong hệ thống.</span>
    </div>

    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table class="device-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px; text-align: left; width: 80px;">ID</th>
                    <th style="padding: 12px; text-align: left;">Tên xí nghiệp</th>
                    <th style="padding: 12px; text-align: center; width: 150px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($branches as $branch)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $loop->iteration }}</td>
                    <td style="padding: 12px;">
                        <strong><i class="fas fa-building"></i> {{ $branch->name }}</strong>
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('branches.edit', $branch->id) }}" style="background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 5px; display: inline-block;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <form action="{{ route('branches.destroy', $branch->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: #dc3545; color: white; padding: 5px 12px; border-radius: 5px; border: none; font-size: 13px; cursor: pointer;" onclick="return confirm('Bạn có chắc muốn xóa xí nghiệp {{ $branch->name }}?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x mb-2 d-block" style="color: #adb5bd;"></i>
                        Chưa có dữ liệu xí nghiệp
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <footer style="margin-top: 30px; padding-top: 20px; border-top: 1px solid #e9ecef; font-size: 13px; color: #6c757d;">
        <i class="fas fa-chart-simple"></i> Quản lý xí nghiệp • Tổng số: <strong>{{ $branches->count() }}</strong> xí nghiệp
    </footer>
</main>

<script>
    // Cập nhật ngày giờ
    function updateDateTime() {
        const now = new Date();
        const dateStr = now.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
        document.getElementById('dateText').innerHTML = `${dateStr}`;
    }
    updateDateTime();
    setInterval(updateDateTime, 60000);
</script>
</body>
</html>