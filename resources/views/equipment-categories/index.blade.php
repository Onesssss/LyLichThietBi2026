@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-tags"></i> Loại thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('equipment-categories.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm loại thiết bị
        </a>
    </div>

    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px;">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên loại thiết bị</th>
                    <th>Thuộc chốt</th>
                    <th>Thuộc danh sách</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td><strong>{{ $cat->name }}</strong></td>
                    <td>{{ $cat->point->name ?? 'N/A' }}</td>
                    <td><span class="badge bg-info">{{ $cat->equipmentList->name ?? 'N/A' }}</span></td>
                    <td>
                        @if($cat->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Vô hiệu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('equipment-categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('equipment-categories.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="text-center">Chưa có dữ liệu</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</main>

<script>
    document.getElementById('dateText').innerHTML = new Date().toLocaleDateString('vi-VN');
</script>
</body>
</html>