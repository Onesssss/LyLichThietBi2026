@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-user-plus"></i> Thêm người dùng mới</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Nhập thông tin người dùng mới vào hệ thống.</span>
    </div>

    <!-- ERROR -->
    @if($errors->any())
    <div style="background: #f8d7da; color: #721c24; padding: 12px 20px;
                border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> Vui lòng kiểm tra lại thông tin
    </div>
    @endif

    <!-- FORM -->
    <div style="background: white; border-radius: 12px; padding: 25px;
                box-shadow: 0 2px 8px rgba(0,0,0,0.05);">

        <form action="{{ route('admins.store') }}" method="POST">
            @csrf

            <!-- USERNAME + PASSWORD -->
            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Tên đăng nhập <span style="color:red">*</span>
                    </label>
                    <input type="text" name="username"
                        value="{{ old('username') }}"
                        placeholder="Nhập tên đăng nhập"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                    @error('username')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Mật khẩu <span style="color:red">*</span>
                    </label>
                    <input type="password" name="password"
                        placeholder="Ít nhất 6 ký tự"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                    @error('password')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- FULLNAME + EMAIL -->
            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Họ và tên <span style="color:red">*</span>
                    </label>
                    <input type="text" name="full_name"
                        value="{{ old('full_name') }}"
                        placeholder="Nhập họ tên"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                    @error('full_name')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Email <span style="color:red">*</span>
                    </label>
                    <input type="email" name="email"
                        value="{{ old('email') }}"
                        placeholder="name@example.com"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                    @error('email')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Vai trò <span style="color:red">*</span>
                    </label>
                    <select name="role_id"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                        <option value="">-- Chọn vai trò --</option>
                        <option value="1" {{ old('role_id') == '1' ? 'selected' : '' }}>Quản Lý Công Ty</option>
                        <option value="2" {{ old('role_id') == '2' ? 'selected' : '' }}>Quản Lý Xí Nghiệp</option>
                        <option value="3" {{ old('role_id') == '3' ? 'selected' : '' }}>Tổ trưởng Tổ Sản Xuất</option>
                    </select>
                    @error('role_id')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Trạng thái <span style="color:red">*</span>
                    </label>
                    <select name="status"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                        <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                        <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Vô hiệu</option>
                    </select>
                </div>
            </div>

     
            <div style="display:flex; gap:20px; flex-wrap:wrap; margin-bottom:20px;">
                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Xí nghiệp
                    </label>
                    <select name="branch_id"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;">
                        <option value="">-- Chọn xí nghiệp --</option>
                        @foreach($branches as $branch)
                            <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                                {{ $branch->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div style="flex:1; min-width:250px;">
                    <label style="display:block; margin-bottom:8px; font-weight:500;">
                        Phòng ban
                    </label>
                    <select name="dept_id"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;">
                        <option value="">-- Chọn phòng ban --</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->id }}" {{ old('dept_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- BUTTON -->
            <div style="margin-top: 25px;">
                <button type="submit"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                           color: white; padding: 10px 24px; border-radius: 6px; border: none;">
                    <i class="fas fa-save"></i> Lưu người dùng
                </button>

                <a href="{{ route('admins.index') }}"
                    style="background: #6c757d; color: white; padding: 10px 24px;
                           border-radius: 6px; text-decoration: none; margin-left: 10px;">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
    </div>
</main>

<script>
function updateDateTime() {
    const now = new Date();
    document.getElementById('dateText').innerHTML =
        now.toLocaleDateString('vi-VN');
}
updateDateTime();
</script>

</body>
</html>