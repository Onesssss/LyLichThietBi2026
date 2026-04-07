@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-key"></i> Yêu cầu cấp lại mật khẩu</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Quản lý yêu cầu cấp lại mật khẩu. Các yêu cầu đã xử lý sẽ tự động xóa sau 2 phút.</span>
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

    @if(session('warning'))
    <div style="background: #fff3cd; color: #856404; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-warning"></i> {{ session('warning') }}
    </div>
    @endif

    <!-- TABLE -->
    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Họ tên</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Thời gian yêu cầu</th>
                    <th style="padding: 12px;">Trạng thái</th>
                    <th style="padding: 12px;">Xử lý bởi</th>
                    <th style="padding: 12px;">Thời gian xử lý</th>
                    <th style="padding: 12px; text-align: center;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $req->id }}</td>
                    <td style="padding: 12px;"><strong>{{ $req->full_name }}</strong></td>
                    <td style="padding: 12px;">{{ $req->email }}</td>
                    <td style="padding: 12px;">{{ date('d/m/Y H:i', strtotime($req->requested_at)) }}</td>
                    <td style="padding: 12px;">
                        @if($req->status == 0)
                            <span style="background: #ffc107; color: #212529; padding: 4px 10px; border-radius: 20px;">
                                <i class="fas fa-clock"></i> Chờ xử lý
                            </span>
                        @else
                            <span style="background: #28a745; color: white; padding: 4px 10px; border-radius: 20px;">
                                <i class="fas fa-check-circle"></i> Đã xử lý
                            </span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        @if($req->processed_by)
                            {{ $req->processor->full_name ?? 'N/A' }}
                        @else
                            <span style="color: #6c757d;">---</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        {{ $req->processed_at ? date('d/m/Y H:i', strtotime($req->processed_at)) : '---' }}
                    </td>
                    <td style="padding: 12px; text-align: center;">
                        @if($req->status == 0)
                            <a href="{{ route('password-requests.reset', $req->id) }}"
                               style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                                      color: white; padding: 5px 12px; border-radius: 5px;
                                      text-decoration: none; font-size: 13px; margin-right: 5px;">
                                <i class="fas fa-key"></i> Cấp lại
                            </a>
                        @endif
                        
                        <form action="{{ route('password-requests.destroy', $req->id) }}" 
                              method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Xóa yêu cầu này?')"
                                style="background: #dc3545; color: white; padding: 5px 12px;
                                       border-radius: 5px; border: none; font-size: 13px;">
                                <i class="fas fa-trash"></i> Xóa
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-inbox fa-2x" style="color: #adb5bd;"></i><br>
                        Không có yêu cầu nào
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
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
setInterval(updateDateTime, 1000);

// Tự động reload trang mỗi 30 giây để cập nhật danh sách
setTimeout(function() {
    location.reload();
}, 30000);
</script>

</body>
</html>