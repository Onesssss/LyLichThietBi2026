@include('partials.header')
@include('partials.sidebar')

<!-- Main Content -->
<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-user-edit"></i> Sửa người dùng</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Cập nhật thông tin người dùng.</span>
    </div>

    @if($errors->any())
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> Vui lòng kiểm tra lại thông tin
    </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('admins.update', $admin->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
            
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Tên đăng nhập <span style="color: red;">*</span></label>
                        <input type="text" name="username" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" 
                               value="{{ old('username', $admin->username) }}" placeholder="Nhập tên đăng nhập" required>
                        @error('username')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
              
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Mật khẩu mới</label>
                        <input type="password" name="password" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" 
                               placeholder="Để trống nếu không đổi">
                        @error('password')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                        <small style="color: #6c757d;">Chỉ nhập nếu muốn thay đổi mật khẩu</small>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Họ tên -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Họ và tên <span style="color: red;">*</span></label>
                        <input type="text" name="full_name" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" 
                               value="{{ old('full_name', $admin->full_name) }}" placeholder="Nhập họ tên" required>
                        @error('full_name')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <!-- Email -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Email <span style="color: red;">*</span></label>
                        <input type="email" name="email" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" 
                               value="{{ old('email', $admin->email) }}" placeholder="name@example.com" required>
                        @error('email')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Vai trò -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Vai trò <span style="color: red;">*</span></label>
                        <select name="role_id" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" required>
                            <option value="">-- Chọn vai trò --</option>
                            <option value="1" {{ old('role_id', $admin->role_id) == '1' ? 'selected' : '' }}>Quản Lý Công Ty</option>
                            <option value="2" {{ old('role_id', $admin->role_id) == '2' ? 'selected' : '' }}>Quản Lý Xí Nghiệp</option>
                            <option value="3" {{ old('role_id', $admin->role_id) == '3' ? 'selected' : '' }}>Tổ Trưởng tổ Sản Xuất</option>
                        </select>
                        @error('role_id')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <!-- Trạng thái -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Trạng thái <span style="color: red;">*</span></label>
                        <select name="status" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" required>
                            <option value="1" {{ old('status', $admin->status) == '1' ? 'selected' : '' }}>Hoạt động</option>
                            <option value="0" {{ old('status', $admin->status) == '0' ? 'selected' : '' }}>Vô hiệu</option>
                        </select>
                        @error('status')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <!-- Xí nghiệp -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Xí nghiệp</label>
                        <select name="branch_id" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">-- Chọn xí nghiệp --</option>
                            @foreach($branches as $branch)
                                <option value="{{ $branch->id }}" {{ old('branch_id', $admin->branch_id) == $branch->id ? 'selected' : '' }}>
                                    {{ $branch->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('branch_id')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                
                <div class="col-md-6">
                    <!-- Phòng ban -->
                    <div style="margin-bottom: 20px;">
                        <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Phòng ban</label>
                        <select name="dept_id" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;">
                            <option value="">-- Chọn phòng ban --</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('dept_id', $admin->dept_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('dept_id')
                        <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
            
            <!-- Buttons -->
            <div style="margin-top: 25px;">
                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 24px; border-radius: 6px; border: none; cursor: pointer;">
                    <i class="fas fa-save"></i> Cập nhật
                </button>
                <a href="{{ route('admins.index') }}" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; text-decoration: none; margin-left: 10px; display: inline-block;">
                    <i class="fas fa-arrow-left"></i> Quay lại
                </a>
            </div>
        </form>
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