<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="frame">
        <div class="login-container">
            <div class="form-section">
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                </div>
                <h2>Forgot Password</h2>
                <form action="{{ route('user.postLogin') }}" method="POST">
                    @csrf
                    <label for="email">Email</label>
                    <div class="input-container">
                        <input type="email" id="email" name="email" placeholder="Enter your email" required>
                    </div>
                    <button type="submit" class="Send-button">Send Password Reset Link </button>
                </form>
                <p class="signup-link">Back to <a href="{{ route('user.login') }}">Login</a></p>
            </div>
            <div class="background-section">
                <h3>Forgot Password <br> ? </h3>
            </div>
        </div>
    </div>
</body>
</html>
