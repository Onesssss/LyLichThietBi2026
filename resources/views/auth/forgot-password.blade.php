<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quên mật khẩu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            width: 450px;
            padding: 30px;
        }
        .card-header {
            background: none;
            border: none;
            text-align: center;
            padding-bottom: 20px;
        }
        .card-header h3 {
            font-weight: 600;
            color: #333;
        }
        .card-header p {
            color: #666;
            font-size: 14px;
        }
        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 12px;
            border-radius: 10px;
            border: none;
            width: 100%;
            font-weight: 500;
            transition: all 0.3s;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .btn-back {
            color: #667eea;
            text-decoration: none;
            display: inline-block;
            margin-top: 15px;
        }
        .alert {
            border-radius: 10px;
            margin-bottom: 20px;
        }
        .form-control {
            border-radius: 10px;
            padding: 12px;
        }
    </style>
</head>
<body>
    <div class="card">
        <div class="card-header">
            <i class="fas fa-key fa-3x" style="color: #667eea; margin-bottom: 15px;"></i>
            <h3>Quên mật khẩu?</h3>
            <p>Nhập email của bạn, Admin sẽ liên hệ để cấp lại mật khẩu</p>
        </div>
        
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
            @endif

            @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
            </div>
            @endif

            <form action="{{ route('forgot-password.send') }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label class="form-label">Địa chỉ email</label>
                    <input type="email" name="email" class="form-control" 
                           placeholder="Nhập email của bạn" value="{{ old('email') }}" required>
                </div>
                <button type="submit" class="btn-submit">
                    <i class="fas fa-paper-plane"></i> Gửi yêu cầu
                </button>
            </form>
            
            <div class="text-center mt-3">
                <a href="{{ route('login') }}" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Quay lại đăng nhập
                </a>
            </div>
        </div>
    </div>
</body>
</html>