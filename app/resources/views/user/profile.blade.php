@extends('user.layout.default')
@push('styleStore')
<style>
    body {
        background-color: #f8f9fa;
    }
    .content {
        padding: 40px;
    }
    .profile-header {
        display: flex;
        align-items: center;
        margin-bottom: 30px;
        background: #ffffff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .profile-header img {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        margin-right: 20px;
    }
    .info-card {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }
    .btn-edit {
        margin-top: 20px;
        width: 100%;
    }
</style>
@endpush

@section('content')
    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-dark display-6">User Profile</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-dark">Profile</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <div class="content">
        <div class="container">
            <div class="profile-header">
                <img src="https://via.placeholder.com/100" alt="User Avatar">
                <div>
                    <h2>John Doe</h2>
                    <p class="text-muted">Email: john.doe@example.com</p>
                    <p class="text-muted">Phone: (123) 456-7890</p>
                </div>
            </div>

            <div class="info-card">
                <h5>Personal Information</h5>
                <p><strong>Address:</strong> 123 Main St, Apt 4B</p>
                <p><strong>City:</strong> Springfield</p>
                <p><strong>Country:</strong> USA</p>
            </div>
            <button class="btn btn-primary btn-edit" data-bs-toggle="modal" data-bs-target="#editProfileModal">Edit Profile</button>
        </div>
    </div>

    <!-- Modal Chỉnh Sửa Hồ Sơ -->
    <div class="modal fade" id="editProfileModal" tabindex="-1" aria-labelledby="editProfileModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editProfileModalLabel">Edit Profile</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" value="John">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" value="Doe">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="john.doe@example.com">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" value="(123) 456-7890">
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <input type="text" class="form-control" id="address" value="123 Main St, Apt 4B">
                        </div>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" value="Springfield">
                        </div>
                        <div class="mb-3">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" value="USA">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save Changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scriptStore')
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.min.js"></script>
@endpush
