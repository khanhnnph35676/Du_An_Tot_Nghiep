 <!-- Spinner Start -->
 <div id="spinner"
     class="show w-100 vh-100 bg-white position-fixed translate-middle top-50 start-50  d-flex align-items-center justify-content-center">
     <div class="spinner-grow text-primary" role="status"></div>
 </div>
 <!-- Spinner End -->

 <!-- Navbar start -->
 <div class="container-fluid fixed-top">
     <div class="container topbar bg-primary d-none d-lg-block">
         <div class="d-flex justify-content-between">
             <div class="top-info ps-2">
                 <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#"
                         class="text-white">1 Trịnh Văn Bô</a></small>
                 <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#"
                         class="text-white">khanhnnph35676@fpt.edu.vn</a></small>
             </div>
             <div class="pe-2">
                 <a href="#" class="text-white"><small class="text-white mx-2">Chính sách bảo mật</small>/</a>
                 <a href="#" class="text-white"><small class="text-white mx-2">Điều khoản</small>/</a>
                 <a href="#" class="text-white"><small class="text-white ms-2">Bán hàng và hoàn tiền</small></a>
             </div>
         </div>
     </div>

     <div class="container px-0">
         <nav class="navbar navbar-light bg-white navbar-expand-xl">
             <a href="{{ route('storeHome') }}" class="navbar-brand">
                 <h1 class="text-primary display-6">J-Snack</h1>
             </a>
             <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse"
                 data-bs-target="#navbarCollapse">
                 <span class="fa fa-bars text-primary"></span>
             </button>
             <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                 <div class="navbar-nav mx-auto">

                     <a href="{{ route('storeHome') }}"
                         class="nav-item nav-link {{ request()->routeIs('storeHome') ? 'active' : '' }}">Trang chủ</a>
                     <a href="{{ route('storeIntro') }}"
                         class="nav-item nav-link {{ request()->routeIs('storeIntro') ? 'active' : '' }}">Giới
                         thiệu</a>
                     <a href="{{ route('storeListProduct') }}"
                         class="nav-item nav-link {{ request()->routeIs('storeListProduct') ? 'active' : '' }}">Sản
                         Phẩm</a>
                     <div class="nav-item dropdown">
                         <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Trang</a>
                         <div class="dropdown-menu m-0 bg-secondary rounded-0">
                             <a class="dropdown-item" href="{{ route('user.blog.index') }}" >Bài viết</a>
                         </div>
                     </div>
                     <a href="{{ route('storeContact') }}"
                         class="nav-item nav-link {{ request()->routeIs('storeProductDetail') ? 'active' : '' }}">Liên
                         hệ</a>
                 </div>
                 <div class="d-flex m-3 me-0">
                     <button class="btn-search btn border border-secondary btn-md-square rounded-circle bg-white me-4"
                         data-bs-toggle="modal" data-bs-target="#searchModal"><i
                             class="fas fa-search text-primary"></i></button>
                     <a href="{{ route('storeListCart') }}" class="position-relative me-4 my-auto">
                         <i class="fa fa-shopping-bag fa-2x"></i>
                         <span
                             class="position-absolute bg-secondary rounded-circle d-flex align-items-center justify-content-center text-dark px-1"
                             style="top: -5px; left: 15px; height: 20px; min-width: 20px;">
                             @php
                                 $count = 0;
                             @endphp
                             @if (Auth::check())
                                 @foreach ($cart as $item)
                                     @if ($item['user_id'] == Auth::id())
                                         @php
                                             $count++;
                                         @endphp
                                     @endif
                                 @endforeach
                             @else
                                 @foreach ($cart as $item)
                                     @if ($item['user_id'] == 0)
                                         @php
                                             $count++;
                                         @endphp
                                     @endif
                                 @endforeach
                             @endif
                             {{ $count }}
                         </span>
                     </a>
                     <div class="dropdown my-auto">
                         <a href="#" class="nav-link" id="userDropdown" role="button" data-bs-toggle="dropdown"
                             aria-expanded="false">
                             <i class="fas fa-user fa-2x"></i>
                         </a>
                         <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                             @if (Auth::check())
                                 <li><a class="dropdown-item" href="{{ route('user.profile') }}">Thông tin cá nhân</a>
                                 </li>
                                 <li><a class="dropdown-item" href="{{ route('order.history') }}">Lịch sử đặt hàng</a>
                                 </li>
                                 <li><a class="dropdown-item" href="{{ route('points') }}">Điểm thưởng</a>
                                 </li>
                                 <li>
                                     <hr class="dropdown-divider">
                                 </li>
                                 <li>
                                     <form action="{{ route('logoutUser') }}" method="POST" style="display: inline;">
                                         @csrf
                                         <button type="submit" class="dropdown-item">Đăng xuất</button>
                                     </form>
                                 </li>
                             @else
                                 <li><a class="dropdown-item" href="{{ route('user.login') }}">Đăng nhập</a>
                                 </li>
                                 <li><a class="dropdown-item" href="{{ route('user.register') }}">Đăng ký</a>
                                 </li>
                             @endif

                         </ul>
                     </div>

                 </div>
             </div>
         </nav>
     </div>
 </div>
 <!-- Navbar End -->
 <!-- Modal Search Start -->
 <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
     <div class="modal-dialog modal-fullscreen">
         <div class="modal-content rounded-0">
             <div class="modal-header">
                 <h5 class="modal-title" id="exampleModalLabel">Search by keyword</h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
             </div>
             <div class="modal-body d-flex align-items-center">
                 <!-- Gửi từ khóa tìm kiếm qua form -->
                 <form action="{{ route('storeListProduct') }}" method="GET"
                     class="input-group w-75 mx-auto d-flex">
                     <input type="search" name="search" class="form-control p-3" placeholder="Nhập từ khóa..."
                         value="{{ request('search') }}" aria-describedby="search-icon-1">
                     <button type="submit" id="search-icon-1" class="input-group-text p-3">
                         <i class="fa fa-search"></i>
                     </button>
                 </form>
             </div>
         </div>
     </div>
 </div>
 <!-- Modal Search End -->
