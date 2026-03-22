@include('partials.header')
@include('partials.sidebar')

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <div class="page-title">
                    <h1>Dashboard tài sản TTHH</h1>
                </div>
                <div class="date-badge" id="currentDate">
                    <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
                </div>
            </div>

            <!-- Phạm vi dữ liệu -->
            <div class="info-note">
                <i class="fas fa-database"></i>
                <span><strong>Phạm vi dữ liệu:</strong> Toàn hệ thống. Dashboard lấy dữ liệu từ bộ nhớ FE hiện tại nên khi thêm tài sản ở danh sách, số liệu sẽ cập nhật theo.</span>
            </div>

            <!-- 4 thẻ chính -->
            <div class="stats-grid" id="statsGrid">
                <div class="stat-card">
                    <div class="stat-title"><i class="fas fa-list-ul"></i> Bảng ghi tài sản</div>
                    <div class="stat-number" id="totalRowsCount">0</div>
                    <div class="stat-sub">Số dòng tài sản chi tiết đang có dữ liệu</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title"><i class="fas fa-boxes"></i> Tổng số lượng</div>
                    <div class="stat-number" id="totalQuantitySum">0</div>
                    <div class="stat-sub">Tổng thiết bị theo trường Số lượng</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title"><i class="fas fa-tools"></i> Thiết bị hư hỏng</div>
                    <div class="stat-number" id="brokenDeviceCount">0</div>
                    <div class="stat-sub" id="brokenSubMsg">Chưa có thiết bị hư hỏng</div>
                </div>
                <div class="stat-card">
                    <div class="stat-title"><i class="fas fa-exclamation-triangle"></i> Ưu tiên</div>
                    <div class="stat-sub" style="margin-top: 8px;">Danh sách cần ưu tiên kiểm tra, sửa chữa.</div>
                    <div class="badge-warning" style="margin-top: 12px;"><i class="fas fa-clock"></i> Kiểm tra ngay</div>
                </div>
            </div>

            <!-- Bảng thiết bị hư hỏng -->
            <div class="damage-section">
                <div class="section-header">
                    <h3><i class="fas fa-wrench"></i> Thiết bị hư hỏng - Danh sách ưu tiên</h3>
                    <span class="priority-badge"><i class="fas fa-flag-checkered"></i> Cần sửa chữa gấp</span>
                </div>
                <div style="overflow-x: auto;">
                    <table class="device-table">
                        <thead>
                            <tr>
                                <th>Tên thiết bị</th>
                                <th>Mã số</th>
                                <th>Số lượng hỏng</th>
                                <th>Tình trạng</th>
                                <th>Ưu tiên</th>
                            </tr>
                        </thead>
                        <tbody id="brokenTableBody">
                            <tr>
                                <td colspan="5" style="text-align: center;">Đang tải dữ liệu...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Các chỉ số mở rộng -->
            <div class="metrics-cluster">
                <div class="metrics-grid" id="extendedMetrics">
                    <div class="metric-item"><div class="metric-label">CUNG</div><div class="metric-value" id="metricCung">0</div></div>
                    <div class="metric-item"><div class="metric-label">GA</div><div class="metric-value" id="metricGa">0</div></div>
                    <div class="metric-item"><div class="metric-label">TỔNG SL</div><div class="metric-value" id="metricTotalSL">0</div></div>
                    <div class="metric-item"><div class="metric-label">HỒNG</div><div class="metric-value" id="metricHong">0</div></div>
                    <div class="metric-item"><div class="metric-label">TÓT</div><div class="metric-value" id="metricTot">0</div></div>
                    <div class="metric-item"><div class="metric-label">BÌNH THƯỜNG</div><div class="metric-value" id="metricBinhThuong">0</div></div>
                    <div class="metric-item"><div class="metric-label">QUÁ HẠN</div><div class="metric-value" id="metricQuaHan">0</div></div>
                    <div class="metric-item"><div class="metric-label">TUỔI DÙNG TB</div><div class="metric-value" id="metricTuoiTB">0<span class="small-note"> năm</span></div></div>
                    <div class="metric-item"><div class="metric-label">NĂM SX CŨ NHẤT</div><div class="metric-value" id="metricNamSXCuNhat">-</div></div>
                </div>
            </div>
            
            <footer>
                <i class="fas fa-chart-simple"></i> Dashboard tài sản TTHH • Dữ liệu được cập nhật theo thời gian thực
            </footer>
        </main>
    </div>

    <script>
        // ==================== CẤU HÌNH DỮ LIỆU ====================
        // Đây là các biến và hàm để bạn đổ dữ liệu từ API/DB vào
        // Bạn chỉ cần gọi hàm updateDashboard(data) với dữ liệu của bạn
        
        /**
         * Cấu trúc dữ liệu mong đợi:
         * {
         *   totalRows: number,              // Số dòng tài sản chi tiết
         *   totalQuantity: number,          // Tổng số lượng thiết bị
         *   brokenDevices: [                 // Danh sách thiết bị hư hỏng
         *     {
         *       name: string,
         *       code: string,
         *       quantity: number,
         *       status: string
         *     }
         *   ],
         *   metrics: {
         *     cung: number,                 // Tổng số lượng ở vị trí CUNG
         *     ga: number,                   // Tổng số lượng ở vị trí GA
         *     hong: number,                 // Tổng số lượng thiết bị hỏng
         *     tot: number,                  // Tổng số lượng thiết bị tốt
         *     binhThuong: number,           // Tổng số lượng bình thường
         *     quaHan: number,               // Tổng số lượng quá hạn
         *     avgAge: number,               // Tuổi thọ trung bình (năm)
         *     oldestYear: number | null     // Năm sản xuất cũ nhất
         *   }
         * }
         */
        
        // Hàm cập nhật toàn bộ dashboard - GỌI HÀM NÀY KHI CÓ DỮ LIỆU TỪ API
        function updateDashboard(data) {
            // Cập nhật 4 thẻ chính
            if (data.totalRows !== undefined) {
                document.getElementById('totalRowsCount').innerText = formatNumber(data.totalRows);
            }
            
            if (data.totalQuantity !== undefined) {
                document.getElementById('totalQuantitySum').innerText = formatNumber(data.totalQuantity);
            }
            
            if (data.brokenDevices !== undefined) {
                const totalBroken = data.brokenDevices.reduce((sum, d) => sum + (d.quantity || 0), 0);
                document.getElementById('brokenDeviceCount').innerText = formatNumber(totalBroken);
                const brokenSubMsg = document.getElementById('brokenSubMsg');
                if (totalBroken === 0) {
                    brokenSubMsg.innerHTML = 'Chưa có thiết bị hư hỏng';
                } else {
                    brokenSubMsg.innerHTML = `Có ${formatNumber(totalBroken)} thiết bị hư hỏng cần xử lý`;
                }
                
                // Cập nhật bảng thiết bị hư hỏng
                updateBrokenTable(data.brokenDevices);
            }
            
            // Cập nhật các chỉ số mở rộng
            if (data.metrics) {
                const m = data.metrics;
                document.getElementById('metricCung').innerText = formatNumber(m.cung || 0);
                document.getElementById('metricGa').innerText = formatNumber(m.ga || 0);
                document.getElementById('metricTotalSL').innerText = formatNumber(data.totalQuantity || 0);
                document.getElementById('metricHong').innerText = formatNumber(m.hong || 0);
                document.getElementById('metricTot').innerText = formatNumber(m.tot || 0);
                document.getElementById('metricBinhThuong').innerText = formatNumber(m.binhThuong || 0);
                document.getElementById('metricQuaHan').innerText = formatNumber(m.quaHan || 0);
                document.getElementById('metricTuoiTB').innerHTML = `${formatNumber(m.avgAge || 0, 1)}<span class="small-note"> năm</span>`;
                document.getElementById('metricNamSXCuNhat').innerText = m.oldestYear ? m.oldestYear : '-';
            }
        }
        
        // Cập nhật bảng thiết bị hư hỏng
        function updateBrokenTable(brokenDevices) {
            const tbody = document.getElementById('brokenTableBody');
            
            if (!brokenDevices || brokenDevices.length === 0) {
                tbody.innerHTML = '<tr><td colspan="5" style="text-align: center;">✅ Không có thiết bị hư hỏng</td></tr>';
                return;
            }
            
            let html = '';
            brokenDevices.forEach(device => {
                html += `
                    <tr>
                        <td><strong>${escapeHtml(device.name)}</strong></td>
                        <td>${escapeHtml(device.code)}</td>
                        <td>${formatNumber(device.quantity)}</td>
                        <td><span class="status-broken"><i class="fas fa-exclamation-circle"></i> ${escapeHtml(device.status || 'Hỏng')}</span></td>
                        <td><i class="fas fa-bolt"></i> Ưu tiên cao</td>
                    </tr>
                `;
            });
            tbody.innerHTML = html;
        }
        
        // ==================== HÀM TIỆN ÍCH ====================
        function formatNumber(num, decimals = 0) {
            if (num === undefined || num === null) return '0';
            const n = typeof num === 'number' ? num : parseFloat(num);
            if (isNaN(n)) return '0';
            return n.toLocaleString('vi-VN', { maximumFractionDigits: decimals, minimumFractionDigits: decimals });
        }
        
        function escapeHtml(str) {
            if (!str) return '';
            return str.replace(/[&<>]/g, function(m) {
                if (m === '&') return '&amp;';
                if (m === '<') return '&lt;';
                if (m === '>') return '&gt;';
                return m;
            });
        }
        
        // Cập nhật ngày giờ hiện tại
        function updateDateTime() {
            const now = new Date();
            const dateStr = now.toLocaleDateString('vi-VN', { day: '2-digit', month: '2-digit', year: 'numeric' });
            const timeStr = now.toLocaleTimeString('vi-VN', { hour: '2-digit', minute: '2-digit', second: '2-digit' });
            document.getElementById('dateText').innerHTML = `${dateStr}`;
            
            // Cập nhật thời gian đăng nhập trong admin card nếu chưa có
            const loginTimeSpan = document.getElementById('loginTime');
            if (loginTimeSpan.innerText.includes('--')) {
                loginTimeSpan.innerText = `Đăng nhập lúc: ${timeStr} ${dateStr}`;
            }
        }
        
        // Cập nhật thông tin admin (gọi khi có dữ liệu user)
        function updateAdminInfo(username, loginTimeStr) {
            if (username) {
                document.getElementById('adminName').innerText = username;
            }
            if (loginTimeStr) {
                document.getElementById('loginTime').innerText = `Đăng nhập lúc: ${loginTimeStr}`;
            }
        }
        
        // ==================== RESPONSIVE SIDEBAR ====================
        const sidebar = document.getElementById('sidebar');
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarOverlay = document.getElementById('sidebarOverlay');
        
        function closeSidebar() {
            sidebar.classList.remove('open');
            sidebarOverlay.classList.remove('active');
        }
        
        function openSidebar() {
            sidebar.classList.add('open');
            sidebarOverlay.classList.add('active');
        }
        
        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', openSidebar);
        }
        
        if (sidebarOverlay) {
            sidebarOverlay.addEventListener('click', closeSidebar);
        }
        
        // Đóng sidebar khi click vào nav-item trên mobile
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', () => {
                if (window.innerWidth <= 768) {
                    closeSidebar();
                }
            });
        });
        
        // Xử lý đăng xuất
        document.getElementById('logoutBtn')?.addEventListener('click', () => {
            // Gọi hàm logout của bạn ở đây
            console.log('Đăng xuất');
            alert('Chức năng đăng xuất - Bạn có thể tích hợp logic logout tại đây');
        });
        
        // Xử lý chuyển trang (demo)
        document.querySelectorAll('.nav-item').forEach(item => {
            item.addEventListener('click', function() {
                const page = this.getAttribute('data-page');
                if (page === 'dashboard') {
                    // Đang ở dashboard
                    console.log('Dashboard');
                } else if (page === 'insurance') {
                    alert('Chức năng Tài khoản Bảo hiểm - Tích hợp theo nhu cầu');
                } else if (page === 'notification') {
                    alert('Chức năng Thông báo - Tích hợp theo nhu cầu');
                }
                
                // Active style
                document.querySelectorAll('.nav-item').forEach(nav => nav.classList.remove('active'));
                this.classList.add('active');
            });
        });
        
        // Khởi tạo
        updateDateTime();
        setInterval(updateDateTime, 60000); // Cập nhật mỗi phút
        
        // ==================== VÍ DỤ DỮ LIỆU MẪU (XÓA HOẶC COMMENT KHI DÙNG THỰC TẾ) ====================
        // Bạn có thể xóa phần này và gọi updateDashboard với dữ liệu thực từ API
        // Hiển thị trạng thái trống để bạn biết cấu trúc
        const emptyData = {
            totalRows: 0,
            totalQuantity: 0,
            brokenDevices: [],
            metrics: {
                cung: 0,
                ga: 0,
                hong: 0,
                tot: 0,
                binhThuong: 0,
                quaHan: 0,
                avgAge: 0,
                oldestYear: null
            }
        };
        updateDashboard(emptyData);
        
        // Hàm để bạn gọi khi có dữ liệu từ API
        window.refreshDashboard = updateDashboard;
        window.updateAdmin = updateAdminInfo;
        
        console.log('Dashboard đã sẵn sàng. Gọi updateDashboard(yourData) để đổ dữ liệu.');
    </script>
</body>
</html>