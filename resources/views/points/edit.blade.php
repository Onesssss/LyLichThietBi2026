@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-edit"></i> Sửa chốt</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    <!-- INFO -->
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Cập nhật thông tin chốt.</span>
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

        <form action="{{ route('points.update', $point->id) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- MÃ + TÊN -->
            <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 20px;">
                <div style="flex: 1; min-width: 250px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: 500;">
                        Mã chốt <span style="color:red">*</span>
                    </label>
                    <input type="text" name="code"
                        value="{{ old('code', $point->code) }}"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                    @error('code')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>

                <div style="flex: 1; min-width: 250px;">
                    <label style="display:block; margin-bottom: 8px; font-weight: 500;">
                        Tên chốt <span style="color:red">*</span>
                    </label>
                    <input type="text" name="name"
                        value="{{ old('name', $point->name) }}"
                        style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                        required>
                    @error('name')
                        <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- CUNG -->
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 8px; font-weight: 500;">
                    Thuộc cung <span style="color:red">*</span>
                </label>
                <select name="department_id"
                    style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;"
                    required>
                    <option value="">-- Chọn cung --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}"
                            {{ old('department_id', $point->department_id) == $dept->id ? 'selected' : '' }}>
                            [{{ $dept->branch->name ?? '' }}] {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div style="color:red; font-size:13px; margin-top:5px;">{{ $message }}</div>
                @enderror
            </div>

            <!-- TRẠNG THÁI -->
            <div style="margin-bottom: 20px;">
                <label style="display:block; margin-bottom: 8px; font-weight: 500;">
                    Trạng thái
                </label>
                <select name="status"
                    style="width:100%; padding:10px 12px; border:1px solid #ddd; border-radius:6px;">
                    <option value="1" {{ old('status', $point->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status', $point->status) == 0 ? 'selected' : '' }}>Vô hiệu</option>
                </select>
            </div>

            <!-- BUTTON -->
            <div style="margin-top: 25px;">
                <button type="submit"
                    style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                           color: white; padding: 10px 24px; border-radius: 6px; border: none;">
                    <i class="fas fa-save"></i> Cập nhật
                </button>

                <a href="{{ route('points.index') }}"
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
        const dateStr = now.toLocaleDateString('vi-VN', {
            day: '2-digit',
            month: '2-digit',
            year: 'numeric'
        });
        document.getElementById('dateText').innerHTML = dateStr;
    }
    updateDateTime();
</script>

</body>
</html>