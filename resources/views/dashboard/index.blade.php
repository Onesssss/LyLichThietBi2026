@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-chart-line"></i> Dashboard</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Tổng quan hệ thống quản lý thiết bị. Thống kê số lượng xí nghiệp, chốt, thiết bị và tình trạng hoạt động.</span>
    </div>

    <!-- ========== 6 THẺ THỐNG KÊ NHANH ========== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 15px; margin-bottom: 25px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 12px; padding: 15px; color: white; text-align: center;">
            <div style="font-size: 28px; font-weight: bold;">{{ number_format($totalBranches) }}</div>
            <div style="font-size: 12px; opacity: 0.9;"><i class="fas fa-building"></i> Xí nghiệp</div>
        </div>
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 12px; padding: 15px; color: white; text-align: center;">
            <div style="font-size: 28px; font-weight: bold;">{{ number_format($totalDepartments) }}</div>
            <div style="font-size: 12px; opacity: 0.9;"><i class="fas fa-map-marker-alt"></i> Cung</div>
        </div>
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 12px; padding: 15px; color: white; text-align: center;">
            <div style="font-size: 28px; font-weight: bold;">{{ number_format($totalPoints) }}</div>
            <div style="font-size: 12px; opacity: 0.9;"><i class="fas fa-location-dot"></i> Chốt</div>
        </div>
        <div style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); border-radius: 12px; padding: 15px; color: white; text-align: center;">
            <div style="font-size: 28px; font-weight: bold;">{{ number_format($totalEquipment) }}</div>
            <div style="font-size: 12px; opacity: 0.9;"><i class="fas fa-microchip"></i> Tổng TB</div>
        </div>
        {{-- <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); border-radius: 12px; padding: 15px; color: white; text-align: center;">
            <div style="font-size: 28px; font-weight: bold;">{{ number_format($activeEquipment) }}</div>
            <div style="font-size: 12px; opacity: 0.9;"><i class="fas fa-check-circle"></i> Đang dùng</div>
        </div>
        <div style="background: linear-gradient(135deg, #f83600 0%, #f9d423 100%); border-radius: 12px; padding: 15px; color: white; text-align: center;">
            <div style="font-size: 28px; font-weight: bold;">{{ number_format($inactiveEquipment) }}</div>
            <div style="font-size: 12px; opacity: 0.9;"><i class="fas fa-ban"></i> Ngừng dùng</div>
        </div> --}}
    </div>

{{-- <!-- ========== HÀNG NGANG: BIỂU ĐỒ NHỎ ========== -->
<div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px;">
    <!-- Biểu đồ cột nhỏ -->
    <div style="background: white; border-radius: 12px; padding: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <div style="font-size: 13px; font-weight: 600; color: #333; margin-bottom: 8px;">
            <i class="fas fa-chart-bar" style="color: #dc3545;"></i> Thiết bị hỏng theo tháng
        </div>
        <canvas id="monthlyChart" height="120" style="height: 120px !important;"></canvas>
    </div>

</div> --}}

<!-- ========== 2 BẢNG TOP 5 ========== -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(350px, 1fr)); gap: 20px; margin-bottom: 25px;">
        <!-- Top 5 thiết bị sắp hết hạn dùng -->
        <div style="background: white; border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div style="font-size: 14px; font-weight: 600; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid #ffc107; color: #ffc107;">
                <i class="fas fa-clock"></i> Top 5 thiết bị sắp hết hạn dùng
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                            <th style="padding: 8px; text-align: center; width: 50px; font-size: 13px;">#</th>
                            <th style="padding: 8px; text-align: left; font-size: 13px;">Tên thiết bị</th>
                            <th style="padding: 8px; text-align: left; font-size: 13px;">Chốt</th>
                            <th style="padding: 8px; text-align: center; width: 100px; font-size: 13px;">Hạn dùng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topExpiringEquipment as $index => $item)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 8px; text-align: center;">
                                <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 12px; font-weight: bold;">{{ $index + 1 }}</span>
                            </td>
                            <td style="padding: 8px; font-size: 13px;">
                                <i class="fas fa-microchip" style="color: #667eea; margin-right: 6px;"></i>
                                {{ $item->name }}
                            </td>
                            <td style="padding: 8px; font-size: 13px;">
                                <i class="fas fa-map-marker-alt" style="color: #17a2b8; margin-right: 6px;"></i>
                                {{ $item->point_name ?? 'N/A' }}
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                <span style="background: #ffc107; color: #856404; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                    {{ \Carbon\Carbon::parse($item->expiry_date)->format('d/m/Y') }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: #6c757d;">
                                <i class="fas fa-database"></i> Không có thiết bị sắp hết hạn
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Top 5 thiết bị hư hỏng nhiều nhất -->
        <div style="background: white; border-radius: 12px; padding: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
            <div style="font-size: 14px; font-weight: 600; margin-bottom: 12px; padding-bottom: 8px; border-bottom: 2px solid #667eea; color: #667eea;">
                <i class="fas fa-microchip"></i> Top 5 thiết bị hư hỏng nhiều nhất
            </div>
            <div style="overflow-x: auto;">
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                            <th style="padding: 8px; text-align: center; width: 50px; font-size: 13px;">#</th>
                            <th style="padding: 8px; text-align: left; font-size: 13px;">Tên thiết bị</th>
                            <th style="padding: 8px; text-align: left; font-size: 13px;">Chốt</th>
                            <th style="padding: 8px; text-align: center; width: 100px; font-size: 13px;">Số lượng hỏng</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topBrokenEquipment as $index => $item)
                        <tr style="border-bottom: 1px solid #e9ecef;">
                            <td style="padding: 8px; text-align: center;">
                                <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; width: 24px; height: 24px; display: inline-flex; align-items: center; justify-content: center; border-radius: 50%; font-size: 12px; font-weight: bold;">{{ $index + 1 }}</span>
                            </td>
                            <td style="padding: 8px; font-size: 13px;">
                                <i class="fas fa-microchip" style="color: #667eea; margin-right: 6px;"></i>
                                {{ $item->name }}
                            </td>
                            <td style="padding: 8px; font-size: 13px;">
                                <i class="fas fa-map-marker-alt" style="color: #17a2b8; margin-right: 6px;"></i>
                                {{ $item->point_name ?? 'N/A' }}
                            </td>
                            <td style="padding: 8px; text-align: center;">
                                <span style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 2px 10px; border-radius: 20px; font-size: 12px; font-weight: bold;">
                                    {{ number_format($item->broken_count) }}
                                </span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" style="padding: 30px; text-align: center; color: #6c757d;">
                                <i class="fas fa-database"></i> Không có dữ liệu
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- ========== BẢNG THIẾT BỊ HỎNG GẦN ĐÂY ========== -->
    <div style="background: white; border-radius: 12px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <h3 style="font-size: 16px; font-weight: 600; margin-bottom: 15px; padding-bottom: 8px; border-bottom: 2px solid #dc3545; color: #dc3545;">
            <i class="fas fa-tools"></i> Thiết bị hư hỏng gần đây
        </h3>
        <div style="overflow-x: auto;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #f8f9fa; border-bottom: 2px solid #e9ecef;">
                        <th style="padding: 10px; text-align: left; font-size: 13px;">Tên thiết bị</th>
                        <th style="padding: 10px; text-align: left; font-size: 13px;">Danh mục</th>
                        <th style="padding: 10px; text-align: left; font-size: 13px;">Chốt</th>
                        <th style="padding: 10px; text-align: center; font-size: 13px;">Tình trạng</th>
                        <th style="padding: 10px; text-align: center; font-size: 13px;">Ngày cập nhật</th>
                    </tr>
                </thead>
                <tbody id="brokenEquipmentTable">
                    <tr>
                        <td colspan="5" style="padding: 30px; text-align: center; color: #6c757d;">
                            <i class="fas fa-spinner fa-spin"></i> Đang tải...
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</main>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
function updateDateTime() {
    const now = new Date();
    const dateStr = now.toLocaleDateString('vi-VN', {
        day: '2-digit', month: '2-digit', year: 'numeric'
    });
    document.getElementById('dateText').innerHTML = dateStr;
}
updateDateTime();

// Khai báo dữ liệu từ PHP (cách tối ưu nhất)
const monthlyLabels = @json($monthlyData->pluck('month')->toArray());
const monthlyCounts = @json($monthlyData->pluck('count')->toArray());
const pieLabels = @json(collect($pieData)->pluck('name')->toArray());
const pieValues = @json(collect($pieData)->pluck('value')->toArray());
const pieColors = @json(collect($pieData)->pluck('color')->toArray());

// // Biểu đồ cột nhỏ
// new Chart(document.getElementById('monthlyChart'), {
//     type: 'bar',
//     data: {
//         labels: @json($monthlyData->pluck('month')->toArray()),
//         datasets: [{
//             label: 'Số lượng',
//             data: @json($monthlyData->pluck('count')->toArray()),
//             backgroundColor: 'rgba(220, 53, 69, 0.7)',
//             borderRadius: 4,
//             barPercentage: 0.7,
//             categoryPercentage: 0.8
//         }]
//     },
//     options: {
//         responsive: true,
//         maintainAspectRatio: true,
//         plugins: {
//             legend: { display: false }
//         },
//         scales: {
//             y: { beginAtZero: true, ticks: { stepSize: 1, font: { size: 9 } }, grid: { lineWidth: 0.5 } },
//             x: { ticks: { font: { size: 9 } }, grid: { display: false } }
//         }
//     }
// });



// Tải danh sách thiết bị hỏng
$.ajax({
    url: '{{ route("dashboard.broken") }}',
    type: 'GET',
    success: function(response) {
        var html = '';
        if (response.length === 0) {
            html = '<tr><td colspan="5" style="padding: 30px; text-align: center;"><i class="fas fa-check-circle" style="color: #28a745;"></i> Không có thiết bị hư hỏng</td></tr>';
        } else {
            $.each(response, function(index, item) {
                html += '<tr style="border-bottom: 1px solid #e9ecef;">';
                html += '<td style="padding: 10px;"><strong>' + item.name + '</strong></td>';
                html += '<td style="padding: 10px;"><span style="background: #6c757d; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px;">' + (item.category ? item.category.name : 'N/A') + '</span></td>';
                html += '<td style="padding: 10px;"><span style="background: #17a2b8; color: white; padding: 2px 8px; border-radius: 20px; font-size: 11px;">' + (item.point ? item.point.name : 'N/A') + '</span></td>';
                html += '<td style="padding: 10px; text-align: center;"><span style="background: #dc3545; color: white; padding: 2px 10px; border-radius: 20px; font-size: 11px;"><i class="fas fa-times-circle"></i> Hỏng</span></td>';
                html += '<td style="padding: 10px; text-align: center;">' + (item.updated_at ? new Date(item.updated_at).toLocaleDateString('vi-VN') : '---') + '</td>';
                html += '</tr>';
            });
        }
        $('#brokenEquipmentTable').html(html);
    },
    error: function() {
        $('#brokenEquipmentTable').html('<tr><td colspan="5" style="padding: 30px; text-align: center; color: #dc3545;"><i class="fas fa-exclamation-circle"></i> Lỗi tải dữ liệu</td></tr>');
    }
});
</script>

<style>
@media (max-width: 768px) {
    .main-content > div[style*="grid-template-columns"] {
        grid-template-columns: 1fr !important;
    }
}
</style>

</body>
</html>