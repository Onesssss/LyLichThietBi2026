@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-plus"></i> Thêm thiết bị</h1>
        </div>
        <div class="date-badge">
            <i class="far fa-calendar-alt"></i> <span id="dateText"></span>
        </div>
    </div>

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 25px;">
        <form action="{{ route('equipment-items.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Mã thiết bị <span style="color:red">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tên thiết bị <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Thuộc danh mục <span style="color:red">*</span></label>
                    <select name="category_id" class="form-control" required>
                        <option value="">-- Chọn danh mục --</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                                [{{ $cat->equipmentList->name ?? '' }}] {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6 mb-3">
                    <label>Thuộc chốt <span style="color:red">*</span></label>
                    <select name="point_id" class="form-control" required>
                        <option value="">-- Chọn chốt --</option>
                        @foreach($points as $point)
                            <option value="{{ $point->id }}" {{ old('point_id') == $point->id ? 'selected' : '' }}>
                                [{{ $point->department->branch->name ?? '' }} - {{ $point->department->name ?? '' }}] {{ $point->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-6 mb-3">
                    <label>Vật liệu</label>
                    <input type="text" name="material" class="form-control" value="{{ old('material') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-3 mb-3">
                    <label>Đơn vị</label>
                    <input type="text" name="unit" class="form-control" value="{{ old('unit') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Số lượng</label>
                    <input type="number" name="quantity" class="form-control" value="{{ old('quantity', 0) }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Năm sản xuất</label>
                    <input type="number" name="manufacture_year" class="form-control" value="{{ old('manufacture_year') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label>Hạn dùng</label>
                    <input type="date" name="expiry_date" class="form-control" value="{{ old('expiry_date') }}">
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Tình trạng</label>
                    <select name="condition" class="form-control">
                        <option value="1">Tốt</option>
                        <option value="2">Trung bình</option>
                        <option value="3">Hỏng</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Trạng thái</label>
                    <select name="status" class="form-control">
                        <option value="1">Hoạt động</option>
                        <option value="0">Vô hiệu</option>
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Ghi chú</label>
                <textarea name="note" class="form-control" rows="3">{{ old('note') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('equipment-items.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</main>

<script>
    document.getElementById('dateText').innerHTML = new Date().toLocaleDateString('vi-VN');
</script>
</body>
</html>