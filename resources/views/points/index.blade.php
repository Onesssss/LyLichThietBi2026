@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-map-marker-alt"></i> Quản lý chốt</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('points.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm chốt
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
                    <th>Mã</th>
                    <th>Tên chốt</th>
                    <th>Xí nghiệp</th>
                    <th>Cung</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($points as $point)
                <tr>
                    <td>{{ $point->id }}</td>
                    <td><strong>{{ $point->code }}</strong></td>
                    <td>{{ $point->name }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $point->department->branch->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $point->department->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="text-center">
                        @if($point->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Vô hiệu</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <a href="{{ route('points.edit', $point->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('points.destroy', $point->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center">Chưa có dữ liệu</td></tr>
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