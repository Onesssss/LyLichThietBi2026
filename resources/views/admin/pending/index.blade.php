@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-tasks"></i> Quản lý duyệt dữ liệu</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Quản lý các yêu cầu thêm/sửa/xóa dữ liệu từ người dùng. Chỉ admin mới có quyền duyệt.</span>
    </div>

    <!-- ALERT -->
    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <!-- ========== THỐNG KÊ ========== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin-bottom: 30px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 20px; color: white;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 14px; opacity: 0.9;">Danh sách thiết bị</div>
                    <div style="font-size: 32px; font-weight: bold;">{{ $pendingLists->count() }}</div>
                </div>
                <i class="fas fa-list" style="font-size: 40px; opacity: 0.5;"></i>
            </div>
        </div>
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 20px; color: white;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 14px; opacity: 0.9;">Danh mục thiết bị</div>
                    <div style="font-size: 32px; font-weight: bold;">{{ $pendingCategories->count() }}</div>
                </div>
                <i class="fas fa-folder" style="font-size: 40px; opacity: 0.5;"></i>
            </div>
        </div>
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 20px; color: white;">
            <div style="display: flex; align-items: center; justify-content: space-between;">
                <div>
                    <div style="font-size: 14px; opacity: 0.9;">Thiết bị</div>
                    <div style="font-size: 32px; font-weight: bold;">{{ $pendingItems->count() }}</div>
                </div>
                <i class="fas fa-microchip" style="font-size: 40px; opacity: 0.5;"></i>
            </div>
        </div>
    </div>

    <!-- ========== DANH SÁCH CHỜ DUYỆT DẠNG CARD ========== -->
    
    <!-- Equipment Lists -->
    @if($pendingLists->count() > 0)
    <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
            <i class="fas fa-list"></i> Danh sách thiết bị
        </h3>
        <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
            @foreach($pendingLists as $pending)
            <div style="background: #f8f9fa; border-radius: 10px; padding: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="flex: 1;">
                    <div style="font-weight: bold; font-size: 16px;">{{ $pending->name }}</div>
                    {{-- <div style="font-size: 13px; color: #6c757d;">Mã: {{ $pending->code }}</div> --}}
                    <div style="font-size: 12px; color: #999; margin-top: 5px;">
                        <i class="fas fa-user"></i> {{ $pending->requester->username ?? 'N/A' }} | 
                        <i class="far fa-clock"></i> {{ $pending->requested_at->format('H:i d/m/Y') }}
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    @if($pending->action_type == 'create')
                        <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Thêm mới</span>
                    @elseif($pending->action_type == 'update')
                        <span style="background: #ffc107; color: #212529; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Cập nhật</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Xóa</span>
                    @endif
                    <a href="{{ route('admin.pending.show-list', $pending->id) }}" 
                       style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 15px; border-radius: 6px; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-eye"></i> Xem & Duyệt
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Equipment Categories -->
    @if($pendingCategories->count() > 0)
    <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
            <i class="fas fa-tags"></i> Danh mục thiết bị
        </h3>
        <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
            @foreach($pendingCategories as $pending)
            <div style="background: #f8f9fa; border-radius: 10px; padding: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="flex: 1;">
                    <div style="font-weight: bold; font-size: 16px;">{{ $pending->name }}</div>
                    <div style="font-size: 12px; color: #999; margin-top: 5px;">
                        <i class="fas fa-user"></i> {{ $pending->requester->username ?? 'N/A' }} | 
                        <i class="far fa-clock"></i> {{ $pending->requested_at->format('H:i d/m/Y') }}
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    @if($pending->action_type == 'create')
                        <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Thêm mới</span>
                    @elseif($pending->action_type == 'update')
                        <span style="background: #ffc107; color: #212529; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Cập nhật</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Xóa</span>
                    @endif
                    <a href="{{ route('admin.pending.show-category', $pending->id) }}" 
                       style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 15px; border-radius: 6px; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-eye"></i> Xem & Duyệt
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Equipment Items -->
    @if($pendingItems->count() > 0)
    <div style="background: white; border-radius: 12px; padding: 20px; margin-bottom: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
            <i class="fas fa-microchip"></i> Thiết bị
        </h3>
        <div style="display: grid; grid-template-columns: 1fr; gap: 15px;">
            @foreach($pendingItems as $pending)
            <div style="background: #f8f9fa; border-radius: 10px; padding: 15px; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 10px;">
                <div style="flex: 1;">
                    <div style="font-weight: bold; font-size: 16px;">{{ $pending->name }}</div>
                    {{-- <div style="font-size: 13px; color: #6c757d;">Mã: {{ $pending->code }}</div> --}}
                    <div style="font-size: 12px; color: #999; margin-top: 5px;">
                        <i class="fas fa-user"></i> {{ $pending->requester->username ?? 'N/A' }} | 
                        <i class="far fa-clock"></i> {{ $pending->requested_at->format('H:i d/m/Y') }}
                    </div>
                </div>
                <div style="display: flex; align-items: center; gap: 10px;">
                    @if($pending->action_type == 'create')
                        <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Thêm mới</span>
                    @elseif($pending->action_type == 'update')
                        <span style="background: #ffc107; color: #212529; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Cập nhật</span>
                    @else
                        <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">Xóa</span>
                    @endif
                    <a href="{{ route('admin.pending.show-item', $pending->id) }}" 
                       style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 6px 15px; border-radius: 6px; text-decoration: none; font-size: 13px;">
                        <i class="fas fa-eye"></i> Xem & Duyệt
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @if($pendingLists->count() == 0 && $pendingCategories->count() == 0 && $pendingItems->count() == 0)
    <div style="background: white; border-radius: 12px; padding: 60px 20px; text-align: center; color: #6c757d; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <i class="fas fa-check-circle fa-3x" style="color: #28a745; margin-bottom: 15px;"></i><br>
        Không có yêu cầu nào chờ duyệt
    </div>
    @endif
</main>

<script>
function updateDateTime() {
    const now = new Date();
    const dateStr = now.toLocaleDateString('vi-VN', {
        day: '2-digit', month: '2-digit', year: 'numeric'
    });
    document.getElementById('dateText').innerHTML = dateStr;
}
updateDateTime();
</script>

</body>
</html>