@extends('admin.layout.default')

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/testimonial.css') }}">

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Testimonial Management</h4>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Testimonials</h4>
                        <button class="btn btn-primary" data-toggle="modal" data-target="#addTestimonialModal">Add New Testimonial</button>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Example testimonial item -->
                            <div class="col-md-4 mb-4">
                                <div class="testimonial-card p-3 border">
                                    <img src="#" alt="User" class="img-fluid rounded-circle mb-3" width="80">
                                    <h5>John Doe</h5>
                                    <p class="testimonial-content">"Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua."</p>
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-success btn-sm">Edit</a>
                                        <a href="#" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this testimonial?');">Delete</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Repeat for more testimonials -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for Adding New Testimonial -->
    <div class="modal fade" id="addTestimonialModal" tabindex="-1" role="dialog" aria-labelledby="addTestimonialModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addTestimonialModalLabel">Add New Testimonial</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="#" method="POST" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input class="form-control" type="text" name="name" placeholder="User Name" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Testimonial:</label>
                            <textarea class="form-control" name="content" rows="5" placeholder="Testimonial Content" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="image">Image:</label>
                            <input type="file" class="form-control-file" name="image" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Testimonial</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/testimonial.js') }}"></script>
@endsection
