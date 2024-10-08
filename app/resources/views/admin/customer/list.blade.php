@extends('admin.layout.default')

@push('styleHome')
    <!-- Datatable -->
@endpush

@section('content')
<link rel="stylesheet" href="{{ asset('backend/css/product.css') }}">
<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles mx-0">
            <div class="col-sm-6 p-md-0">
                <div class="welcome-text">
                    <h4>Hi, welcome back!</h4>
                    <span class="ml-1">Customer List</span>
                </div>
            </div>
            <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                <ol class="breadcrumb">
                    {{-- <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li> --}}
                    <li class="breadcrumb-item active"><a href="javascript:void(0)">Customers</a></li>
                </ol>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">List Customers</h4>
                        <div class="btn-group" role="group">
                            <a href="{{ route('admin.customerCreate') }}" class="btn btn-secondary">Add Customer</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="display">
                                <thead>
                                    <tr>
                                        <th>Stt</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Avatar</th>
                                        <th>Phone</th>
                                        <th>Gender</th>
                                        <th>Birth Date</th>
                                        <th>Rule</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($users as $key => $user)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                @if($user->avatar)
                                                    <img src="{{ asset('storage/' . $user->avatar) }}" alt="{{ $user->name }}" width="100px">
                                                @endif
                                            </td>
                                            <td>{{ $user->phone }}</td>
                                            <td>{{ ucfirst($user->gender) }}</td>
                                            <td>{{ $user->birth_date ? \Carbon\Carbon::parse($user->birth_date)->format('d-m-Y') : 'N/A' }}</td>
                                            <td>{{ optional($user->rule)->rule_name }}</td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="{{ route('admin.customerEdit', $user->id) }}" class="btn btn-secondary mr-1">Update</a>
                                                    <form action="{{ route('admin.customerDestroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-dark">Delete</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="{{ asset('backend/js/product.js') }}"></script>
@endsection


@push('scriptHome')

@endpush