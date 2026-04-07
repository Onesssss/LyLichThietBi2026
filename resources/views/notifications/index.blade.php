@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-bell"></i> Thông báo</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>


    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Thông báo về các yêu cầu duyệt dữ liệu và kết quả xử lý từ Admin.</span>
    </div>


    @if(session('success'))
    <div style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        @forelse($notifications as $notification)
        <div style="border-bottom: 1px solid #e9ecef; padding: 20px 15px; transition: all 0.3s; {{ !$notification->is_read ? 'background: linear-gradient(135deg, #f0f8ff 0%, #e8f4fd 100%); border-left: 4px solid #667eea;' : 'background: white;' }}"
             onmouseover="this.style.backgroundColor='#f8f9fa'"
             onmouseout="this.style.backgroundColor='{{ !$notification->is_read ? '#e8f4fd' : 'white' }}'">
            
            <div style="display: flex; justify-content: space-between; align-items: start; gap: 15px;">
                <div style="flex: 1;">
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 8px; flex-wrap: wrap;">
                        @if($notification->type == 'approved')
                            <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-check-circle"></i> Đã duyệt
                            </span>
                        @elseif($notification->type == 'rejected')
                            <span style="background: #dc3545; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-times-circle"></i> Từ chối
                            </span>
                        @elseif($notification->type == 'pending')
                            <span style="background: #ffc107; color: #212529; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-clock"></i> Chờ duyệt
                            </span>
                        @elseif($notification->type == 'info')
                            <span style="background: #17a2b8; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-info-circle"></i> Thông báo
                            </span>
                        @else
                            <span style="background: #6c757d; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-bell"></i> Thông báo
                            </span>
                        @endif
                        
                        @if(!$notification->is_read)
                            <span style="background: #667eea; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px;">
                                <i class="fas fa-circle" style="font-size: 8px;"></i> Chưa đọc
                            </span>
                        @endif
                    </div>
                    
                    <h4 style="margin: 0 0 8px 0; font-size: 16px; font-weight: 600; color: #333;">
                        {{ $notification->title }}
                    </h4>
                    
                    <p style="margin: 0 0 10px 0; color: #666; line-height: 1.5;">
                        {{ $notification->message }}
                    </p>
                    
                    <div style="display: flex; align-items: center; gap: 15px; font-size: 12px; color: #999;">
                        <span>
                            <i class="far fa-clock"></i> {{ $notification->created_at->format('H:i:s - d/m/Y') }}
                        </span>
                        @if($notification->data_id && $notification->type == 'pending')
                        <span>
                            <i class="fas fa-link"></i> 
                            <a href="{{ route('admin.pending.show-' . $notification->data_type, $notification->data_id) }}" 
                               style="color: #667eea; text-decoration: none;">
                                Xem chi tiết
                            </a>
                        </span>
                        @endif
                    </div>
                </div>
                
                <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST">
                    @csrf 
                    @method('DELETE')
                    <button type="submit" class="btn" 
                            style="background: #dc3545; color: white; padding: 6px 12px; border-radius: 6px; border: none; font-size: 13px; cursor: pointer;"
                            onclick="return confirm('Xóa thông báo này?')">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
            </div>
        </div>
        @empty
        <div style="padding: 60px 20px; text-align: center; color: #6c757d;">
            <i class="fas fa-bell-slash fa-3x" style="color: #adb5bd; margin-bottom: 15px;"></i><br>
            Chưa có thông báo nào
        </div>
        @endforelse
        
    
        @if($notifications->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-3" style="padding-top: 15px;">
            <div style="font-size: 14px; color: #6c757d;">
                Hiển thị {{ $notifications->firstItem() ?? 0 }} đến {{ $notifications->lastItem() ?? 0 }} của {{ $notifications->total() }} thông báo
            </div>
            <div>{{ $notifications->links() }}</div>
        </div>
        @endif
    </div>
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

<style>
/* Responsive cho mobile */
@media (max-width: 768px) {
    .notification-item > div {
        flex-direction: column;
    }
    
    .notification-item form {
        align-self: flex-end;
        margin-top: 10px;
    }
}
</style>

</body>
</html>