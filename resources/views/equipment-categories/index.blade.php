@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-folder"></i> Danh mục thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- NÚT -->
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between;">
        <button type="button" onclick="toggleFilter()"
            style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
            <i class="fas fa-filter"></i> 
            <span id="filterToggleText">Hiện bộ lọc</span>
        </button>
    @if(in_array(session('role_id'), [0,1,2]))
        <a href="{{ route('equipment-categories.create') }}"
           style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                  color: white; padding: 10px 20px; border-radius: 8px;
                  text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm danh mục
        </a>
    @endif
    </div>

    <!-- FORM LỌC -->
<div id="filterForm" style="display: none; background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
    <form method="GET" action="{{ route('equipment-categories.index') }}">
        <div class="row g-3">
            <div class="col-md-4">
                <label style="font-weight: 500; display: block; margin-bottom: 8px;">
                    <i class="fas fa-tags"></i> Tên danh mục
                </label>
                <input type="text" name="name" 
                       style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd;"
                       value="{{ request('name') }}"
                       placeholder="Nhập tên danh mục...">
            </div>

            <div class="col-md-4">
                <label style="font-weight: 500; display: block; margin-bottom: 8px;">
                    <i class="fas fa-list"></i> Danh sách thiết bị
                </label>
                <select name="list_id" 
                        style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd; background: white;">
                    <option value="">-- Tất cả --</option>
                    @foreach($listsForFilter as $list)
                        <option value="{{ $list->id }}" {{ request('list_id') == $list->id ? 'selected' : '' }}>
                            {{ $list->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <label style="font-weight: 500; display: block; margin-bottom: 8px;">
                    <i class="fas fa-map-marker-alt"></i> Thuộc chốt
                </label>
                <select name="point_id" 
                        style="width: 100%; padding: 10px 12px; border-radius: 8px; border: 1px solid #ddd; background: white;">
                    <option value="">-- Tất cả --</option>
                    @foreach($points as $point)
                        <option value="{{ $point->id }}" {{ request('point_id') == $point->id ? 'selected' : '' }}>
                            [{{ $point->department->branch->name ?? '' }} - {{ $point->department->name ?? '' }}] {{ $point->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 d-flex gap-2 mt-3" style="justify-content: flex-end;">
                <a href="{{ route('equipment-categories.index') }}"
                   style="background: #6c757d; padding: 8px 20px; border-radius: 8px; color: white; text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-undo"></i> Xóa lọc
                </a>
                <button type="submit"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border: none; padding: 8px 24px; border-radius: 8px; color: white; display: inline-flex; align-items: center; gap: 8px;">
                    <i class="fas fa-search"></i> Tìm kiếm
                </button>
            </div>
        </div>
    </form>
</div>

    <!-- ALERT -->
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-database"></i>
        <span><strong>Danh mục thiết bị:</strong> Quản lý các danh mục thiết bị theo từng danh sách và chốt.</span>
    </div>

    <!-- TABLE -->
    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Tên danh mục</th>
                    <th style="padding: 12px;">Danh sách</th>
                    <th style="padding: 12px;">Thuộc chốt</th>
                    <th style="padding: 12px;">Trạng thái</th>
                    @if(in_array(session('role_id'), [0,1,2]))
                    <th style="padding: 12px; text-align: center;">Thao tác</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse($categories as $cat)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $loop->iteration }}</td>
                    <td style="padding: 12px;">{{ $cat->name }}</td>

                    <td style="padding: 12px;">
                        <span style="background: #6c757d; color: white; padding: 4px 10px; border-radius: 20px;">
                            <i class="fas fa-list"></i>
                            {{ $cat->equipmentList->name ?? 'N/A' }}
                        </span>
                    </td>

                    <td style="padding: 12px;">
                        <span style="background: #e9ecef; color: #495057; padding: 4px 10px; border-radius: 20px;">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $cat->point->name ?? 'N/A' }}
                            <small>({{ $cat->point->department->name ?? '' }})</small>
                        </span>
                    </td>

                    <td style="padding: 12px;">
                        @if($cat->status == 1)
                            <span style="background: #28a745; color: white; padding: 4px 10px; border-radius: 20px;">
                                Hoạt động
                            </span>
                        @else
                            <span style="background: #dc3545; color: white; padding: 4px 10px; border-radius: 20px;">
                                Vô hiệu
                            </span>
                        @endif
                    </td>
                @if(in_array(session('role_id'), [0,1,2]))
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('equipment-categories.edit', $cat->id) }}"
                           style="background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 5px;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>

                        <form action="{{ route('equipment-categories.destroy', $cat->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xóa?')"
                                style="background: #dc3545; color: white; padding: 5px 12px; border-radius: 5px; border: none; font-size: 13px;">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                @endif
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x" style="color: #adb5bd;"></i><br>
                        Không có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <!-- PAGINATION -->
        <div class="d-flex justify-content-between align-items-center mt-3">
            <div style="font-size: 14px; color: #6c757d;">
                Hiển thị {{ $categories->firstItem() ?? 0 }} đến {{ $categories->lastItem() ?? 0 }} của {{ $categories->total() }} bản ghi
            </div>
            <div>{{ $categories->links() }}</div>
        </div>
    </div>
</main>

<script>
function updateDateTime() {
    const now = new Date();
    const dateStr = now.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
    document.getElementById('dateText').innerHTML = dateStr;
}
updateDateTime();

// Toggle filter
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

// Auto show filter
// @if(count(request()->all()) > 0 && !request()->has('page'))
//     document.getElementById('filterForm').style.display = 'block';
//     document.getElementById('filterToggleText').innerHTML = 'Ẩn bộ lọc';
// @endif
</script>

</body>
</html>