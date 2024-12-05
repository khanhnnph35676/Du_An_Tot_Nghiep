<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Đăng ký</title>
    <link href="{{ asset('focus-2/focus-2/css/style.css') }}" rel="stylesheet">
</head>

<body>
    <div class="authincation">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="auth-form">
                        <h4 class="text-center">Đăng ký tài khoản</h4>
                        <form action="{{ route('postRegister') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Họ tên: </label>
                                <input type="text" name="name" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Mật khẩu</label>
                                <input type="password" name="password" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label>Nhập lại mật khẩu</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                            </div>
                        </form>
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif


                        <div class="new-account mt-3">
                            <p>Bạn đã có tài khoản? <a href="{{ route('loginAdmin') }}" class="text-primary">Đăng
                                    nhập</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
