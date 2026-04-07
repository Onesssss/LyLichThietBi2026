@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-plus-circle"></i> Thêm thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

   
    <div class="info-note" style="margin-bottom: 20px;">
        <i class="fas fa-info-circle"></i>
        <span>Nhập thông tin thiết bị mới. Các trường có <span style="color:red">*</span> là bắt buộc.</span>
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

    <div style="background: white; border-radius: 12px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
        <form action="{{ route('equipment-items.store') }}" method="POST">
            @csrf

        
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-info-circle"></i> Thông tin cơ bản
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    {{-- <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Mã thiết bị <span style="color:red">*</span></label>
                        <input type="text" name="code" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('code') }}" required>
                        @error('code')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div> --}}
                    
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Tên thiết bị <span style="color:red">*</span></label>
                        <input type="text" name="name" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('name') }}" required>
                        @error('name')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-tags"></i> Phân loại
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 20px;">
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Thuộc danh mục <span style="color:red">*</span></label>
                        <select name="category_id" class="form-control"
                                style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;" required>
                            <option value="">-- Chọn danh mục --</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                    [{{ $cat->equipmentList->name ?? '' }}] {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Thuộc chốt <span style="color:red">*</span></label>
                        <select name="point_id" class="form-control"
                                style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;" required>
                            <option value="">-- Chọn chốt --</option>
                            @foreach($points as $point)
                                <option value="{{ $point->id }}" {{ old('point_id') == $point->id ? 'selected' : '' }}>
                                    [{{ $point->department->branch->name ?? '' }} - {{ $point->department->name ?? '' }}] {{ $point->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('point_id')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

       
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-cogs"></i> Thông số kỹ thuật
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Vật liệu</label>
                        <input type="text" name="material" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('material') }}" placeholder="VD: Thép, Nhôm, ...">
                        @error('material')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Đơn vị</label>
                        <input type="text" name="unit" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('unit') }}" placeholder="VD: Cái, Bộ, Máy, ...">
                        @error('unit')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Số lượng</label>
                        <input type="number" name="quantity" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('quantity', 0) }}" min="0">
                        @error('quantity')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

        
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-calendar-alt"></i> Thời gian
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Năm sản xuất</label>
                        <input type="number" name="manufacture_year" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('manufacture_year') }}" placeholder="VD: 2024" min="1900" max="{{ date('Y') }}">
                        @error('manufacture_year')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Hạn dùng</label>
                        <input type="date" name="expiry_date" class="form-control"
                               style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;"
                               value="{{ old('expiry_date') }}">
                        @error('expiry_date')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-chart-line"></i> Trạng thái
                </h3>
                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Tình trạng</label>
                        <select name="condition" class="form-control"
                                style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;">
                            <option value="1" {{ old('condition') == '1' ? 'selected' : '' }}>🟢 Tốt</option>
                            <option value="2" {{ old('condition') == '2' ? 'selected' : '' }}>🟡 Trung bình</option>
                            <option value="3" {{ old('condition') == '3' ? 'selected' : '' }}>🔴 Hỏng</option>
                        </select>
                        @error('condition')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div>
                        <label style="font-weight: 500; display: block; margin-bottom: 8px;">Trạng thái sử dụng</label>
                        <select name="status" class="form-control"
                                style="padding:10px 12px; border-radius: 8px; border: 1px solid #ddd; width: 100%;">
                            <option value="1" {{ old('status') == '1' ? 'selected' : '' }}>✅ Hoạt động</option>
                            <option value="0" {{ old('status') == '0' ? 'selected' : '' }}>❌ Vô hiệu</option>
                        </select>
                        @error('status')
                        <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

     
            <div style="margin-bottom: 30px;">
                <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 10px; border-bottom: 2px solid #667eea; color: #667eea;">
                    <i class="fas fa-pen"></i> Ghi chú
                </h3>
                <div>
                    <textarea name="note" class="form-control"
                              style="padding:12px; border-radius: 8px; border: 1px solid #ddd; width: 100%; resize: vertical;" 
                              rows="4" placeholder="Nhập ghi chú về thiết bị (nếu có)...">{{ old('note') }}</textarea>
                    @error('note')
                    <div style="color:red; font-size:13px; margin-top: 5px;">{{ $message }}</div>
                    @enderror
                </div>
            </div>

        
            <div style="margin-top: 25px; display: flex; gap: 15px; justify-content: flex-end;">
                <a href="{{ route('equipment-items.index') }}"
                   style="background: #6c757d; color: white; padding: 10px 24px;
                          border-radius: 8px; text-decoration: none;">
                    <i class="fas fa-times"></i> Hủy bỏ
                </a>
                <button type="submit"
                        style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
                               color: white; padding: 10px 24px; border-radius: 8px; border: none;">
                    <i class="fas fa-save"></i> Lưu thiết bị
                </button>
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

<style>
/* Responsive cho mobile */
@media (max-width: 768px) {
    .main-content {
        padding: 15px;
    }
    
    form > div {
        margin-bottom: 20px;
    }
    
    h3 {
        font-size: 16px !important;
    }
}
</style>

</body>
</html>