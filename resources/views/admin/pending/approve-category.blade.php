@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-check-circle"></i> Duyệt yêu cầu - Danh mục thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Xem chi tiết yêu cầu và thực hiện duyệt hoặc từ chối.</span>
    </div>

    <!-- ALERT -->
    @if(session('error'))
    <div style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <div style="display: grid; grid-template-columns: 1fr 380px; gap: 25px;">
        <!-- Cột trái: Thông tin chi tiết -->
        <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <!-- THÔNG TIN YÊU CẦU -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-info-circle"></i> Thông tin yêu cầu
                </h3>
                <div style="display: grid; grid-template-columns: 140px 1fr; gap: 12px;">
                    <div style="font-weight: 500; color: #6c757d;">Hành động:</div>
                    <div>
                        @if($pending->action_type == 'create')
                            <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px;">➕ Thêm mới</span>
                        @elseif($pending->action_type == 'update')
                            <span style="background: #ffc107; color: #212529; padding: 4px 12px; border-radius: 20px; font-size: 13px;">✏️ Cập nhật</span>
                        @else
                            <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px;">🗑️ Xóa</span>
                        @endif
                    </div>

                    <div style="font-weight: 500; color: #6c757d;">Người yêu cầu:</div>
                    <div><strong>{{ $pending->requester->username ?? 'N/A' }}</strong></div>

                    <div style="font-weight: 500; color: #6c757d;">Thời gian yêu cầu:</div>
                    <div>{{ $pending->requested_at->format('H:i:s - d/m/Y') }}</div>
                </div>
            </div>

            <!-- DỮ LIỆU CHI TIẾT -->
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-database"></i> Dữ liệu chi tiết
                </h3>
                <div style="display: grid; grid-template-columns: 160px 1fr; gap: 12px;">
                    <div style="font-weight: 500; color: #6c757d;">Tên danh mục:</div>
                    <div><strong>{{ $pending->name }}</strong></div>

                    <div style="font-weight: 500; color: #6c757d;">Danh sách ID:</div>
                    <div>{{ $pending->list_id }}</div>

                    <div style="font-weight: 500; color: #6c757d;">Chốt ID:</div>
                    <div>{{ $pending->point_id }}</div>

                    <div style="font-weight: 500; color: #6c757d;">Trạng thái:</div>
                    <div>
                        @if($pending->status == 1)
                            <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px;">✅ Hoạt động</span>
                        @else
                            <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 13px;">❌ Vô hiệu</span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- HIỂN THỊ DỮ LIỆU CŨ (NẾU LÀ UPDATE) -->
            @if($pending->action_type == 'update' && isset($pending->original_data))
            <div>
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #ffc107; color: #ffc107;">
                    <i class="fas fa-history"></i> Dữ liệu cũ
                </h3>
                <div style="background: #f8f9fa; border-radius: 8px; padding: 15px;">
                    <div style="display: grid; grid-template-columns: 160px 1fr; gap: 12px;">
                        <div style="font-weight: 500; color: #6c757d;">Tên danh mục:</div>
                        <div>{{ json_decode($pending->original_data, true)['name'] ?? 'N/A' }}</div>

                        <div style="font-weight: 500; color: #6c757d;">Danh sách ID:</div>
                        <div>{{ json_decode($pending->original_data, true)['list_id'] ?? 'N/A' }}</div>

                        <div style="font-weight: 500; color: #6c757d;">Chốt ID:</div>
                        <div>{{ json_decode($pending->original_data, true)['point_id'] ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Cột phải: Hành động duyệt -->
        <div style="display: flex; flex-direction: column; gap: 20px;">
            <!-- DUYỆT YÊU CẦU -->
            <div style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; padding: 20px; color: white;">
                <h4 style="margin-bottom: 15px; font-size: 18px;">
                    <i class="fas fa-check-circle"></i> Duyệt yêu cầu
                </h4>
                <p style="font-size: 13px; opacity: 0.9; margin-bottom: 15px;">
                    Dữ liệu sẽ được lưu vào hệ thống sau khi duyệt.
                </p>
                <form action="{{ route('admin.pending.approve-category', $pending->id) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn" 
                            style="width: 100%; background: white; color: #28a745; padding: 10px; border: none; border-radius: 8px; font-weight: 600;"
                            onclick="return confirm('Xác nhận DUYỆT yêu cầu này? Dữ liệu sẽ được lưu vào hệ thống.')">
                        <i class="fas fa-check"></i> Xác nhận duyệt
                    </button>
                </form>
            </div>

            <!-- TỪ CHỐI YÊU CẦU -->
            <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                <h4 style="margin-bottom: 15px; font-size: 18px; color: #dc3545;">
                    <i class="fas fa-times-circle"></i> Từ chối yêu cầu
                </h4>
                <form action="{{ route('admin.pending.reject-category', $pending->id) }}" method="POST">
                    @csrf
                    <div style="margin-bottom: 15px;">
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Lý do từ chối <span style="color:red">*</span></label>
                        <textarea name="rejection_reason" class="form-control" 
                                  style="padding: 10px; border-radius: 8px; border: 1px solid #ddd; width: 100%; resize: vertical;" 
                                  rows="4" required placeholder="Nhập lý do từ chối..."></textarea>
                    </div>
                    <button type="submit" class="btn" 
                            style="width: 100%; background: #dc3545; color: white; padding: 10px; border: none; border-radius: 8px;"
                            onclick="return confirm('Xác nhận TỪ CHỐI yêu cầu này?')">
                        <i class="fas fa-times"></i> Xác nhận từ chối
                    </button>
                </form>
            </div>

            <!-- NÚT QUAY LẠI -->
            <a href="{{ route('admin.pending.index') }}" 
               style="background: #6c757d; color: white; padding: 12px; border-radius: 8px; text-decoration: none; text-align: center;">
                <i class="fas fa-arrow-left"></i> Quay lại danh sách
            </a>
        </div>
    </div>
</main>

<script>
function updateDateTime() {
    const now = new Date();
    const dateStr = now.toLocaleDateString('vi-VN', {
        day: '2-digit', month: '2-digit', year: 'numeric',
        hour: '2-digit', minute: '2-digit'
    });
    document.getElementById('dateText').innerHTML = dateStr;
}
updateDateTime();
</script>

<style>
/* Responsive cho mobile */
@media (max-width: 768px) {
    .main-content > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

</body>
</html>