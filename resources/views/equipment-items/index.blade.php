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

    <!-- NÚT -->
    <div style="margin-bottom: 20px; display: flex; justify-content: space-between;">
        <button type="button" onclick="toggleFilter()"
            style="background: #6c757d; color: white; border: none; padding: 8px 16px; border-radius: 6px;">
            <i class="fas fa-filter"></i> 
            <span id="filterToggleText">Hiện bộ lọc</span>
        </button>
@if(in_array(session('role_id'), [0,1,2]))
        <a href="{{ route('equipment-items.create') }}"
           style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                  color: white; padding: 10px 20px; border-radius: 8px;
                  text-decoration: none; display: inline-flex; align-items: center; gap: 8px;">
            <i class="fas fa-plus-circle"></i> Thêm thiết bị
        </a>
@endif       
    </div>

    <!-- FORM LỌC -->
    <div id="filterForm" style="display: none; background: white; border-radius: 12px; padding: 25px; margin-bottom: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form method="GET" action="{{ route('equipment-items.index') }}">
            <!-- Hàng 1: Thông tin cơ bản -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-microchip" style="color: #667eea;"></i> Tên thiết bị
                    </label>
                    <input type="text" name="name" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; transition: all 0.3s;"
                        value="{{ request('name') }}" 
                        placeholder="VD: Máy tính Dell, Màn hình Samsung..."
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102,126,234,0.1)'"
                        onblur="this.style.borderColor='#e0e0e0'; this.style.boxShadow='none'">
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-tags" style="color: #667eea;"></i> Danh mục
                    </label>
                    <select name="category_id"
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                📂 {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    {{-- <select name="category_id" class="form-select">
                        <option value="">-- Tất cả --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select> --}}
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-map-marker-alt" style="color: #667eea;"></i> Chốt
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

            <!-- Hàng 2: Thời gian -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(240px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-calendar" style="color: #667eea;"></i> Năm SX (từ)
                    </label>
                    <input type="number" name="manufacture_year_from" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                        value="{{ request('manufacture_year_from') }}" 
                        placeholder="VD: 2020" min="1900" max="{{ date('Y') }}">
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-calendar" style="color: #667eea;"></i> Năm SX (đến)
                    </label>
                    <input type="number" name="manufacture_year_to" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                        value="{{ request('manufacture_year_to') }}" 
                        placeholder="VD: 2025" min="1900" max="{{ date('Y') }}">
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-hourglass-half" style="color: #667eea;"></i> Hạn dùng (từ)
                    </label>
                    <input type="date" name="expiry_date_from" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                        value="{{ request('expiry_date_from') }}">
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-hourglass-end" style="color: #667eea;"></i> Hạn dùng (đến)
                    </label>
                    <input type="date" name="expiry_date_to" 
                        style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px;"
                        value="{{ request('expiry_date_to') }}">
                </div>
            </div>

            <!-- Hàng 3: Trạng thái -->
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-bottom: 20px;">
                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-chart-simple" style="color: #667eea;"></i> Tình trạng
                    </label>
                    <select name="condition" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('condition') == '1' ? 'selected' : '' }}>🟢 Tốt</option>
                        <option value="2" {{ request('condition') == '2' ? 'selected' : '' }}>🟡 Trung bình</option>
                        <option value="3" {{ request('condition') == '3' ? 'selected' : '' }}>🔴 Hỏng</option>
                    </select>
                </div>

                <div>
                    <label style="font-weight: 500; display: block; margin-bottom: 8px; color: #333;">
                        <i class="fas fa-power-off" style="color: #667eea;"></i> Trạng thái
                    </label>
                    <select name="status" 
                            style="width: 100%; padding: 10px 12px; border: 1px solid #e0e0e0; border-radius: 8px; font-size: 14px; background: white; cursor: pointer;">
                        <option value="">-- Tất cả --</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>✅ Hoạt động</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>❌ Vô hiệu</option>
                    </select>
                </div>
            </div>

            <!-- Nút bấm -->
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 25px; padding-top: 10px; border-top: 1px solid #f0f0f0;">
                <a href="{{ route('equipment-items.index') }}" 
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
        <button type="button" class="btn btn-success" id="exportExcelBtn">
            <i class="fas fa-file-excel"></i> Xuất Excel
        </button>
    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-database"></i>
        <span><strong>Quản lý thiết bị:</strong> Danh sách tất cả thiết bị trong hệ thống.</span>
    </div>

    <!-- ========== DESKTOP: TABLE VIEW ========== -->
    <div class="desktop-view" style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse; min-width: 1200px;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px;">STT</th>
                    <th style="padding: 12px;">Tên thiết bị</th>
                    <th style="padding: 12px;">Danh mục</th>
                    <th style="padding: 12px;">Chốt</th>
                    <th style="padding: 12px;">Vật liệu</th>
                    <th style="padding: 12px;">Đơn vị</th>
                    <th style="padding: 12px; text-align: center;">Số lượng</th>
                    <th style="padding: 12px; text-align: center;">Năm SX</th>
                    <th style="padding: 12px; text-align: center;">Hạn dùng</th>
                    <th style="padding: 12px; text-align: center;">Tình trạng</th>
                    <th style="padding: 12px; text-align: center;">Trạng thái</th>
                    <th style="padding: 12px; text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($items as $item)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $loop->iteration }}</td>
                    <td style="padding: 12px;"><strong>{{ $item->name }}</strong></td>
                    <td style="padding: 12px;">
                        <span style="background: #6c757d; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; max-width: 250px; white-space: normal; word-break: break-word; font-size: 13px; line-height: 1.4;">
                            {{ $item->category->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td style="padding: 12px;">
                        <span style="background: #17a2b8; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; max-width: 250px; white-space: normal; word-break: break-word; font-size: 13px; line-height: 1.4;">
                            {{ $item->point->name ?? 'N/A' }}
                        </span>
                    </td>
                    <td style="padding: 12px;">{{ $item->material ?? '---' }}</td>
                    <td style="padding: 12px;">{{ $item->unit ?? '---' }}</td>
                    <td style="padding: 12px; text-align: center;">{{ number_format($item->quantity) }}</td>
                    <td style="padding: 12px; text-align: center;">{{ $item->manufacture_year ?? '---' }}</td>
                    <td style="padding: 12px; text-align: center;">{{ $item->expiry_date ? date('d/m/Y', strtotime($item->expiry_date)) : '---' }}</td>
                    <td style="padding: 12px; text-align: center;">
                        @if($item->condition == 1)
                            <span style="background: #28a745; color: white; padding: 4px 10px; border-radius: 20px;">Tốt</span>
                        @elseif($item->condition == 2)
                            <span style="background: #ffc107; color: #212529; padding: 4px 10px; border-radius: 20px;">Trung bình</span>
                        @else
                            <span style="background: #dc3545; color: white; padding: 4px 10px; border-radius: 20px;">Hỏng</span>
                        @endif
                    </td>
                    
                    <td style="padding: 12px; text-align: center;">
                        @if($item->status == 1)
                            <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; font-size: 13px; white-space: nowrap;">
                                ✅ Hoạt động
                            </span>
                        @else
                            <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; display: inline-block; font-size: 13px; white-space: nowrap;">
                                ❌ Vô hiệu
                            </span>
                        @endif
                    </td>
                    
                    <td style="padding: 12px; text-align: center;">
                        <a href="{{ route('equipment-items.edit', $item->id) }}" style="background: #ffc107; color: #212529; padding: 5px 12px; border-radius: 5px; text-decoration: none; font-size: 13px; margin-right: 5px;">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        @if(in_array(session('role_id'), [0,1,2]))
                        <form action="{{ route('equipment-items.destroy', $item->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Xóa?')" style="background: #dc3545; color: white; padding: 5px 12px; border-radius: 5px; border: none; font-size: 13px;">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                         @endif
                    </td>
                   
                </tr>
                @empty
                <tr>
                    <td colspan="12" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x" style="color: #adb5bd;"></i><br>
                        Không có dữ liệu
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- ========== MOBILE: CARD VIEW ========== -->
    <div class="mobile-view" style="display: none;">
        @forelse($items as $item)
        <div style="background: white; border-radius: 12px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 10px;">
                <h3 style="font-size: 16px; font-weight: bold; margin: 0; color: #333;">
                    <i class="fas fa-microchip"></i> {{ $item->name }}
                </h3>
                <div>
                    <a href="{{ route('equipment-items.edit', $item->id) }}" style="background: #ffc107; color: #212529; padding: 4px 10px; border-radius: 5px; text-decoration: none; font-size: 12px; margin-right: 5px;">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('equipment-items.destroy', $item->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Xóa?')" style="background: #dc3545; color: white; padding: 4px 10px; border-radius: 5px; border: none; font-size: 12px;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 8px; font-size: 13px;">
                <div style="color: #6c757d;">Danh mục:</div>
                <div><span style="background: #6c757d; color: white; padding: 2px 8px; border-radius: 12px;">{{ $item->category->name ?? 'N/A' }}</span></div>
                
                <div style="color: #6c757d;">Chốt:</div>
                <div><span style="background: #17a2b8; color: white; padding: 2px 8px; border-radius: 12px;">{{ $item->point->name ?? 'N/A' }}</span></div>
                
                <div style="color: #6c757d;">Vật liệu:</div>
                <div>{{ $item->material ?? '---' }}</div>
                
                <div style="color: #6c757d;">Đơn vị:</div>
                <div>{{ $item->unit ?? '---' }}</div>
                
                <div style="color: #6c757d;">Số lượng:</div>
                <div><strong>{{ number_format($item->quantity) }}</strong></div>
                
                <div style="color: #6c757d;">Năm SX:</div>
                <div>{{ $item->manufacture_year ?? '---' }}</div>
                
                <div style="color: #6c757d;">Hạn dùng:</div>
                <div>{{ $item->expiry_date ? date('d/m/Y', strtotime($item->expiry_date)) : '---' }}</div>
                
                <div style="color: #6c757d;">Tình trạng:</div>
                <div>
                    @if($item->condition == 1)
                        <span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 12px;">Tốt</span>
                    @elseif($item->condition == 2)
                        <span style="background: #ffc107; color: #212529; padding: 2px 8px; border-radius: 12px;">Trung bình</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 12px;">Hỏng</span>
                    @endif
                </div>
                
                <div style="color: #6c757d;">Trạng thái:</div>
                <div>
                    @if($item->status == 1)
                        <span style="background: #28a745; color: white; padding: 2px 8px; border-radius: 12px;">Hoạt động</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 2px 8px; border-radius: 12px;">Vô hiệu</span>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="background: white; border-radius: 12px; padding: 40px; text-align: center; color: #6c757d;">
            <i class="fas fa-database fa-2x" style="color: #adb5bd;"></i><br>
            Không có dữ liệu
        </div>
        @endforelse
    </div>

    <!-- PAGINATION -->
    <div class="d-flex justify-content-between align-items-center mt-3">
        <div style="font-size: 14px; color: #6c757d;">
            Hiển thị {{ $items->firstItem() ?? 0 }} đến {{ $items->lastItem() ?? 0 }} của {{ $items->total() }} bản ghi
        </div>
        <div>{{ $items->links() }}</div>
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

$('#exportExcelBtn').click(function() {
    var params = {
        name: $('input[name="name"]').val(),
        category_id: $('select[name="category_id"]').val(),
        point_id: $('select[name="point_id"]').val(),
        manufacture_year_from: $('input[name="manufacture_year_from"]').val(),
        manufacture_year_to: $('input[name="manufacture_year_to"]').val(),
        expiry_date_from: $('input[name="expiry_date_from"]').val(),
        expiry_date_to: $('input[name="expiry_date_to"]').val(),
        condition: $('select[name="condition"]').val(),
        status: $('select[name="status"]').val()
    };
    window.location.href = '{{ route("equipment-items.export") }}?' + $.param(params);
});

// Auto show filter
// @if(count(request()->all()) > 0 && !request()->has('page'))
//     document.getElementById('filterForm').style.display = 'block';
//     document.getElementById('filterToggleText').innerHTML = 'Ẩn bộ lọc';
// @endif

// Responsive: Switch between table and card view
function handleResponsive() {
    const desktopView = document.querySelector('.desktop-view');
    const mobileView = document.querySelector('.mobile-view');
    if (window.innerWidth <= 768) {
        desktopView.style.display = 'none';
        mobileView.style.display = 'block';
    } else {
        desktopView.style.display = 'block';
        mobileView.style.display = 'none';
    }
}

// Run on load and resize
window.addEventListener('load', handleResponsive);
window.addEventListener('resize', handleResponsive);
</script>

<style>
@media (max-width: 768px) {
    .desktop-view {
        display: none;
    }
    .mobile-view {
        display: block !important;
    }
}
@media (min-width: 769px) {
    .desktop-view {
        display: block;
    }
    .mobile-view {
        display: none !important;
    }
}
</style>

</body>
</html>