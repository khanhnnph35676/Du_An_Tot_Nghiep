<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="frame">
        <div class="login-container">
            <div class="form-section">

                <h2>Đăng ký</h2>
                <form action="{{ route('user.postRegister') }}" method="POST">
                    @csrf
                    <label for="name">Họ tên</label>
                    <div class="input-container">
                        <input type="text" id="name" name="name" placeholder="Họ tên" required>
                    </div>
                    
                    <div class="input-container">
          

<!-- Hiển thị lỗi cụ thể cho từng trường -->
<div class="form-group">
    <label for="email">Email:</label>
    <input type="email" name="email" class="form-control" value="{{ old('email') }}">
    @error('email')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
                    </div>

                    <label for="password">Mật khẩu</label>
                    <div class="input-container">
                        <input type="password" id="password" name="password" placeholder="********" required>
                    </div>

                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <div class="input-container">
                        <input type="password" id="password_confirmation" name="password_confirmation" placeholder="********" required>
                    </div>
                    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
                    <button type="submit" class="submit-button">Đăng ký</button>
                </form>
                <p class="signup-link">Bạn đã có tài khoản? <a href="{{ route('user.login') }}">Đăng nhập</a></p>
            </div>
            <div class="background-section" style="display: flex; align-items: center; justify-content: center;">
                <div style="text-align: center;">
                    <div class="logo-container">
                        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                    </div>
                    <h3>Đăng ký <br> tài khoản</h3>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
