@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-key"></i> Yêu cầu đặt lại mật khẩu</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    @if(session('success'))
    <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    <div style="overflow-x: auto; background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <table class="device-table" style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                    <th style="padding: 12px;">ID</th>
                    <th style="padding: 12px;">Họ tên</th>
                    <th style="padding: 12px;">Email</th>
                    <th style="padding: 12px;">Thời gian yêu cầu</th>
                    <th style="padding: 12px;">Trạng thái</th>
                    <th style="padding: 12px;">Người xử lý</th>
                    <th style="padding: 12px;">Thao tác</th>
                </tr>
            </thead>
            <tbody>
                @forelse($requests as $req)
                <tr style="border-bottom: 1px solid #e9ecef;">
                    <td style="padding: 12px;">{{ $req->id }}</td>
                    <td style="padding: 12px;"><strong>{{ $req->full_name }}</strong></td>
                    <td style="padding: 12px;">{{ $req->email }}</td>
                    <td style="padding: 12px;">{{ $req->requested_at->format('H:i d/m/Y') }}</td>
                    <td style="padding: 12px;">
                        @if($req->status == 0)
                            <span style="background: #ffc107; color: #212529; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-clock"></i> Chờ xử lý
                            </span>
                        @else
                            <span style="background: #28a745; color: white; padding: 4px 12px; border-radius: 20px; font-size: 12px;">
                                <i class="fas fa-check"></i> Đã xử lý
                            </span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        @if($req->processed_by)
                            {{ $req->processor->full_name ?? 'Đã xóa' }}
                            <br><small>{{ $req->processed_at ? $req->processed_at->format('H:i d/m/Y') : '' }}</small>
                        @else
                            <span style="color: #999;">Chưa xử lý</span>
                        @endif
                    </td>
                    <td style="padding: 12px;">
                        @if($req->status == 0)
                            <a href="{{ route('password-requests.reset', $req->id) }}" 
                               style="background: #667eea; color: white; padding: 6px 12px; border-radius: 5px; text-decoration: none; font-size: 13px;">
                                <i class="fas fa-edit"></i> Xử lý
                            </a>
                        @else
                            <span style="color: #6c757d;">Đã xử lý</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="padding: 40px; text-align: center; color: #6c757d;">
                        <i class="fas fa-database fa-2x mb-2 d-block"></i>
                        Chưa có yêu cầu nào
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
        const dateStr = now.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
        document.getElementById('dateText').innerHTML = `${dateStr}`;
    }
    updateDateTime();
</script>
</body>
</html>