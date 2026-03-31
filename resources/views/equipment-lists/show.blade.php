@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-info-circle"></i> Chi tiết danh sách thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div style="background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px;">
        <div class="row">
            <div class="col-md-6">
                <p><strong>Mã danh sách:</strong> {{ $list->code }}</p>
                <p><strong>Tên danh sách:</strong> {{ $list->name }}</p>
                <p><strong>Thuộc chốt:</strong> {{ $list->point->name ?? 'N/A' }}</p>
                <p><strong>Thuộc cung:</strong> {{ $list->point->department->name ?? 'N/A' }}</p>
                <p><strong>Thuộc xí nghiệp:</strong> {{ $list->point->department->branch->name ?? 'N/A' }}</p>
            </div>
            <div class="col-md-6">
                <p><strong>Mô tả:</strong> {{ $list->description ?? '---' }}</p>
                <p><strong>Trạng thái:</strong> 
                    @if($list->status == 1)
                        <span class="badge bg-success">Hoạt động</span>
                    @else
                        <span class="badge bg-danger">Vô hiệu</span>
                    @endif
                </p>
                <p><strong>Ngày tạo:</strong> {{ $list->created_at ? date('d/m/Y H:i', strtotime($list->created_at)) : '---' }}</p>
                <p><strong>Cập nhật:</strong> {{ $list->updated_at ? date('d/m/Y H:i', strtotime($list->updated_at)) : '---' }}</p>
            </div>
        </div>
        
        <div class="mt-3">
            <a href="{{ route('equipment-lists.edit', $list->id) }}" class="btn btn-warning">Sửa</a>
            <a href="{{ route('equipment-lists.index') }}" class="btn btn-secondary">Quay lại</a>
        </div>
    </div>
    
    @if($list->categories->count() > 0)
    <div style="background: white; border-radius: 12px; padding: 25px;">
        <h4>Danh mục thiết bị trong danh sách</h4>
        <table class="table table-bordered">
            <thead>
                <tr><th>ID</th><th>Mã</th><th>Tên danh mục</th><th>Trạng thái</th><th>Thao tác</th></tr>
            </thead>
            <tbody>
                @foreach($list->categories as $cat)
                <tr>
                    <td>{{ $cat->id }}</td>
                    <td>{{ $cat->code }}</td>
                    <td>{{ $cat->name }}</td>
                    <td>@if($cat->status == 1) Hoạt động @else Vô hiệu @endif</td>
                    <td><a href="{{ route('equipment-categories.edit', $cat->id) }}" class="btn btn-sm btn-warning">Sửa</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</main>

<script>
    document.getElementById('dateText').innerHTML = new Date().toLocaleDateString('vi-VN');
</script>
</body>
</html>