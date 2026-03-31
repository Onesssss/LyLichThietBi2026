@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-list"></i> Danh sách thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('equipment-lists.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm danh sách
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
                    <th>Tên danh sách</th>
                    <th>Thuộc chốt</th>
                    <th>Mô tả</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lists as $list)
                <tr>
                    <td>{{ $list->id }}</td>
                    <td><strong>{{ $list->code }}</strong></td>
                    <td>{{ $list->name }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $list->point->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $list->description ?? '---' }}</td>
                    <td>
                        @if($list->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Vô hiệu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('equipment-lists.edit', $list->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('equipment-lists.destroy', $list->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center">Chưa có dữ liệu</td></tr>
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