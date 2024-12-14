@extends('user.layout.default')

@section('content')
<style>
    .ahi{
        padding-top: 275px;
    }
</style>
<div class="container">
    <h2>Đổi Mật Khẩu</h2>
    
    <form class="ahi" method="POST" action="{{ route('user.update-password') }}">
        @csrf
        <div class="mb-3">
            <label for="current_password" class="form-label">Mật khẩu hiện tại</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Mật khẩu mới</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>
        <div class="mb-3">
            <label for="new_password_confirmation" class="form-label">Xác nhận mật khẩu mới</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Đổi mật khẩu</button>
    </form>
</div>
@endsection
