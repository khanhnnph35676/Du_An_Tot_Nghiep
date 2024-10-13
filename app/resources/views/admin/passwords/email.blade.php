<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Reset Password</title>
    <link href="{{ asset('focus-2/focus-2/css/style.css') }}" rel="stylesheet">
</head>
<body>
    <div class="authincation">
        <div class="container-fluid">
            <div class="row justify-content-center align-items-center">
                <div class="col-md-6">
                    <div class="auth-form">
                        <h4 class="text-center">Forgot Your Password?</h4>
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="form-group">
                                <label>Email</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-block">Send Password Reset Link</button>
                            </div>
                            @if (session('status'))
                                <div class="alert alert-success mt-3">{{ session('status') }}</div>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
