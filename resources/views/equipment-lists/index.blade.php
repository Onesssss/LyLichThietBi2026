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

    <!-- NÚT -->
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between;">
        <button type="button" onclick="toggleFilter()"
            style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
            <i class="fas fa-filter"></i> 
            <span id="filterToggleText">Hiện bộ lọc</span>
        </button>
        @if(in_array(session('role_id'), [0,1,2]))
        <a href="{{ route('equipment-lists.create') }}"
           style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                  color: white; padding: 10px 20px; border-radius: 8px;
                  text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm danh sách
        </a>
       @endif
    </div>

    <!-- FORM LỌC -->
    <div id="filterForm" style="display: none; background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="GET" action="{{ route('equipment-lists.index') }}">
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px;">
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-list" style="color: #667eea;"></i> Tên danh sách
                    </label>
                    <input type="text" name="name" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                        value="{{ request('name') }}"
                        placeholder="VD: Danh sách thiết bị văn phòng, ..."
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102,126,234,0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> Thuộc chốt
                    </label>
                    <select name="point_id" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        @foreach($points as $point)
                            <option value="{{ $point->id }}" {{ request('point_id') == $point->id ? 'selected' : '' }}>
                                📍 [{{ $point->department->branch->name ?? '' }} - {{ $point->department->name ?? '' }}] {{ $point->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 25px; padding-top: 10px; border-top: 1px solid #f0f0f0;">
                <a href="{{ route('equipment-lists.index') }}" 
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

    <!-- ALERT -->
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-database"></i>
        <span><strong>Danh sách thiết bị:</strong> Quản lý danh sách theo từng chốt.</span>
    </div>

    <!-- TABLE -->
    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px;">ID</th>
                    {{-- <th style="padding: 12px;">Mã</th> --}}
                    <th style="padding: 12px;">Tên danh sách</th>
                    <th style="padding: 12px;">Thuộc chốt</th>
                    <th style="padding: 12px;">Trạng thái</th>
                    @if(in_array(session('role_id'), [0,1,2]))
                    <th style="padding: 12px; text-align: center;">Thao tác</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse($lists as $list)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $loop->iteration }}</td>
                    {{-- <td style="padding: 12px;"><strong>{{ $list->code }}</strong></td> --}}
                    <td style="padding: 12px;">{{ $list->name }}</td>

                    <td style="padding: 12px;">
                        <span style="background: #e9ecef; color: #495057; padding: 4px 10px; border-radius: 20px;">
                            <i class="fas fa-map-marker-alt"></i>
                            {{ $list->point->name ?? 'N/A' }}
                            <small>({{ $list->point->department->name ?? '' }})</small>
                        </span>
                    </td>

                    <td style="padding: 12px;">
                        @if($list->status == 1)
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
                        <a href="{{ route('equipment-lists.edit', $list->id) }}"
                           style="background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 5px;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>

                        <form action="{{ route('equipment-lists.destroy', $list->id) }}" method="POST" style="display:inline;">
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
                    <td colspan="6" style="padding: 40px; text-align: center; color: #6c757d;">
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
                Hiển thị {{ $lists->firstItem() ?? 0 }} đến {{ $lists->lastItem() ?? 0 }} của {{ $lists->total() }} bản ghi
            </div>
            <div>{{ $lists->links() }}</div>
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
@if(count(request()->all()) > 0 && !request()->has('page'))
    document.getElementById('filterForm').style.display = 'block';
    document.getElementById('filterToggleText').innerHTML = 'Ẩn bộ lọc';
@endif
</script>

</body>
</html>