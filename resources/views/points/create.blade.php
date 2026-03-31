@include('partials.header')
@include('partials.sidebar')

<main class="main-content">
    <div class="top-bar">
        <div class="page-title">
            <h1><i class="fas fa-plus"></i> Thêm chốt</h1>
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
        <form action="{{ route('points.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label>Mã chốt <span style="color:red">*</span></label>
                    <input type="text" name="code" class="form-control" value="{{ old('code') }}" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label>Tên chốt <span style="color:red">*</span></label>
                    <input type="text" name="name" class="form-control" value="{{ old('name') }}" required>
                </div>
            </div>

            <div class="col-md-6 mb-3">
                <label>Thuộc cung <span style="color:red">*</span></label>
                <select name="department_id" class="form-control" required>
                    <option value="">-- Chọn cung --</option>
                    @foreach($departments as $dept)
                        <option value="{{ $dept->id }}" {{ old('department_id') == $dept->id ? 'selected' : '' }}>
                            [{{ $dept->branch->name ?? '' }}] {{ $dept->name }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="mb-3">
                <label>Trạng thái</label>
                <select name="status" class="form-control">
                    <option value="1">Hoạt động</option>
                    <option value="0">Vô hiệu</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Lưu</button>
            <a href="{{ route('points.index') }}" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</main>

<script>
    document.getElementById('dateText').innerHTML = new Date().toLocaleDateString('vi-VN');
</script>
</body>
</html>