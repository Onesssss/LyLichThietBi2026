@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-plus-circle"></i> Thêm loại thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

   
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Nhập thông tin loại thiết bị mới.</span>
    </div>

  
    @if($errors->any())
    <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 12px 20px; border-radius: 8px; margin-bottom: 20px;">
        <i class="fas fa-exclamation-circle"></i> Vui lòng kiểm tra lại thông tin
        <ul style="margin-top: 10px; margin-bottom: 0;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('equipment-categories.store') }}" method="POST">
            @csrf

            <div class="row">
                <!-- Thuộc danh sách thiết bị -->
                <div class="col-md-6">
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 500;">Thuộc danh sách thiết bị <span style="color:red">*</span></label>
                        <select name="list_id" class="form-control"
                                style="padding:10px; border-radius:6px;" required>
                            <option value="">-- Chọn danh sách --</option>
                            @foreach($lists as $list)
                                <option value="{{ $list->id }}" {{ old('list_id') == $list->id ? 'selected' : '' }}>
                                    {{ $list->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('list_id')
                        <div style="color:red; font-size:13px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

              
                <div class="col-md-6">
                    <div style="margin-bottom: 20px;">
                        <label style="font-weight: 500;">Thuộc chốt <span style="color:red">*</span></label>
                        <select name="point_id" class="form-control"
                                style="padding:10px; border-radius:6px;" required>
                            <option value="">-- Chọn chốt --</option>
                            @foreach($points as $point)
                                <option value="{{ $point->id }}" {{ old('point_id') == $point->id ? 'selected' : '' }}>
                                    [{{ $point->department->branch->name ?? '' }} - {{ $point->department->name ?? '' }}] {{ $point->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('point_id')
                        <div style="color:red; font-size:13px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

          
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 500;">Tên loại thiết bị <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control"
                       style="padding:10px; border-radius:6px;"
                       value="{{ old('name') }}" required>
                @error('name')
                <div style="color:red; font-size:13px;">{{ $message }}</div>
                @enderror
            </div>

          
            <div style="margin-bottom: 20px;">
                <label style="font-weight: 500;">Trạng thái</label>
                <select name="status" class="form-control"
                        style="padding:10px; border-radius:6px;">
                    <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>Vô hiệu</option>
                </select>
            </div>

        
            <div style="margin-top: 25px;">
                <button type="submit"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                               color: white; padding: 10px 24px; border-radius: 6px; border: none;">
                    <i class="fas fa-save"></i> Lưu
                </button>

                <a href="{{ route('equipment-categories.index') }}"
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
        day: '2-digit', month: '2-digit', year: 'numeric'
    });
    document.getElementById('dateText').innerHTML = dateStr;
}
updateDateTime();
</script>

</body>
</html>