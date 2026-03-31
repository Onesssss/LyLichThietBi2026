@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-microchip"></i> Thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div style="margin-bottom: 20px; text-align: right;">
        <a href="{{ route('equipment-items.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Thêm thiết bị
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
                    <th>Tên thiết bị</th>
                    <th>Danh sách</th>
                    <th>Thuộc chốt</th>
                    <th>Danh mục</th>
                    <th>Vật liệu</th>
                    <th>Đơn vị</th>
                    <th>Số lượng</th>
                    <th>Năm SX</th>
                    <th>Hạn dùng</th>
                    <th>Tình trạng</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr>
                    <td>{{ $item->id }}</td>
                    <td><strong>{{ $item->code }}</strong></td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <span class="badge bg-secondary">
                            {{ $item->category->equipmentList->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td class="text-center">
                        <span class="badge bg-secondary">
                            {{ $item->point->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>
                        <span class="badge bg-info">
                            {{ $item->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td>{{ $item->material ?? '---' }}</td>
                    <td>{{ $item->unit ?? '---' }}</td>
                    <td class="text-center">{{ number_format($item->quantity) }}</td>
                    <td class="text-center">{{ $item->manufacture_year ?? '---' }}</td>
                    <td class="text-center">{{ $item->expiry_date ? date('d/m/Y', strtotime($item->expiry_date)) : '---' }}</td>
                    <td class="text-center">
                        @if($item->condition == 1)
                            <span class="badge bg-success">Tốt</span>
                        @elseif($item->condition == 2)
                            <span class="badge bg-warning">Trung bình</span>
                        @else
                            <span class="badge bg-danger">Hỏng</span>
                        @endif
                    </td>
                    <td class="text-center">
                        @if($item->status == 1)
                            <span class="badge bg-success">Hoạt động</span>
                        @else
                            <span class="badge bg-danger">Vô hiệu</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('equipment-items.edit', $item->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('equipment-items.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="13" class="text-center">Chưa có dữ liệu</td></tr>
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