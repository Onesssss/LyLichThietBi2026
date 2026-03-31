@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-edit"></i> Sửa loại thiết bị</h1>
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
        <form action="{{ route('equipment-categories.update', $category->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Thuộc danh sách thiết bị <span style="color:red">*</span></label>
                <select name="list_id" class="form-control" required>
                    <option value="">-- Chọn danh sách --</option>
                    @foreach($lists as $list)
                        <option value="{{ $list->id }}" {{ old('list_id', $category->list_id) == $list->id ? 'selected' : '' }}>
                            {{ $list->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6 mb-3">
                <label>Thuộc chốt <span style="color:red">*</span></label>
                <select name="point_id" class="form-control" required>
                    <option value="">-- Chọn chốt --</option>
                    @foreach($points as $point)
                        <option value="{{ $point->id }}" {{ (old('point_id', $category->point_id) == $point->id) ? 'selected' : '' }}>
                            [{{ $point->department->branch->name ?? '' }} - {{ $point->department->name ?? '' }}] {{ $point->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Tên loại thiết bị <span style="color:red">*</span></label>
                <input type="text" name="name" class="form-control" value="{{ old('name', $category->name) }}" required>
            </div>

            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $category->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status', $category->status) == 0 ? 'selected' : '' }}>Vô hiệu</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('equipment-categories.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</main>

<script>
    document.getElementById('dateText').innerHTML = new Date().toLocaleDateString('vi-VN');
</script>
</body>
</html>