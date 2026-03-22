@include('partials.header')
@include('partials.sidebar')

<!-- Main Content -->
<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-plus-circle"></i> Thêm phòng ban mới</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Chọn xí nghiệp và nhập tên phòng ban mới vào hệ thống.</span>
    </div>

    @if($errors->any())
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> Vui lòng kiểm tra lại thông tin
    </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('departments.store') }}" method="POST">
            @csrf
            
            <!-- Chọn xí nghiệp (dropdown) -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Xí nghiệp <span style="color: red;">*</span></label>
                <select name="branch_id" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" required>
                    <option value="">-- Chọn xí nghiệp --</option>
                    @foreach($branches as $branch)
                        <option value="{{ $branch->id }}" {{ old('branch_id') == $branch->id ? 'selected' : '' }}>
                            {{ $branch->name }}
                        </option>
                    @endforeach
                </select>
                @error('branch_id')
                <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Tên phòng ban -->
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: 500; color: #495057;">Tên phòng ban <span style="color: red;">*</span></label>
                <input type="text" name="name" class="form-control" style="width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px;" 
                       value="{{ old('name') }}" placeholder="Nhập tên phòng ban" required>
                @error('name')
                <div style="color: red; font-size: 13px; margin-top: 5px;">{{ $message }}</div>
                @enderror
            </div>
            
            <!-- Buttons -->
            <div style="margin-top: 25px;">
                <button type="submit" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 10px 24px; border-radius: 6px; border: none; cursor: pointer;">
                    <i class="fas fa-save"></i> Lưu phòng ban
                </button>
                <a href="{{ route('departments.index') }}" style="background: #6c757d; color: white; padding: 10px 24px; border-radius: 6px; text-decoration: none; margin-left: 10px; display: inline-block;">
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