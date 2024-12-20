<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Focus - Bootstrap Admin Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('focus-2/focus-2/images/favicon.png') }}">
    <link href="{{ asset('focus-2/focus-2/css/style.css') }}" rel="stylesheet">
</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container-fluid h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Đăng nhập tài khoản của bạn</h4>
                                    <form action="{{ route('postLogin') }}" method="POST">
                                        @csrf
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Mật khẩu</strong></label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="form-row d-flex justify-content-between mt-4 mb-2">
                                            <div class="form-group">
                                                <div class="form-check ml-2">
                                                    <input class="form-check-input" type="checkbox" id="basic_checkbox_1" name="remember">
                                                    <label class="form-check-label" for="basic_checkbox_1">Lưu tài khoản</label>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                              <a href="{{ route('password.request') }}">Quên mật khẩu</a>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Đăng nhập ngay</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Bạn chưa có tài khoản? <a class="text-primary" href="{{ route('registerAdmin') }}">Đăng ký</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--**********************************
        Scripts
    ***********************************-->
    <script src="{{ asset('focus-2/focus-2/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('focus-2/focus-2/js/quixnav-init.js') }}"></script>
    <script src="{{ asset('focus-2/focus-2/js/custom.min.js') }}"></script>
</body>

</html>
