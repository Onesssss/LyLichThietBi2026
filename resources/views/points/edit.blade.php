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

    @if($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
    </div>
    @endif

    <div style="background: white; border-radius: 12px; padding: 25px;">
        <form action="{{ route('points.update', $point->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Mã chốt <span style="color:red">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code', $point->code) }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tên chốt <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name', $point->name) }}" required>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Thuộc cung <span style="color:red">*</span></label>
                    <select name="department_id" class="form-control" required>
                        <option value="">-- Chọn cung --</option>
                        @foreach($departments as $dept)
                            <option value="{{ $dept->id }}" {{ old('department_id', $point->department_id) == $dept->id ? 'selected' : '' }}>
                                [{{ $dept->branch->name ?? '' }}] {{ $dept->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1" {{ old('status', $point->status) == 1 ? 'selected' : '' }}>Hoạt động</option>
                    <option value="0" {{ old('status', $point->status) == 0 ? 'selected' : '' }}>Vô hiệu</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Cập nhật</button>
            <a href="{{ route('points.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</main>

<script>
    document.getElementById('dateText').innerHTML = new Date().toLocaleDateString('vi-VN');
</script>
</body>
</html>