 <!--**********************************
            Sidebar start
        ***********************************-->
 <div class="quixnav">
     <div class="quixnav-scroll">
         <ul class="metismenu" id="menu">
             <li class="nav-label first text-white">Mục chính</li>
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-app-store"></i><span class="nav-text">Trang chủ</span></a>
                 <ul aria-expanded="false">
                     <li><a href="{{ route('admin.admin1') }}">Thống kê sản phẩm</a></li>
                     <li><a href="{{ route('admin.chart') }}">Biểu đồ kinh doanh</a></li>
                 </ul>
             </li>
             <li>
                 <a href="{{ route('admin.profile') }}" aria-expanded="false">
                     <i class="icon icon-single-04"></i>
                     <span class="nav-text">Thông tin cá nhân</span>
                 </a>
             </li>
             <li class="nav-label text-white">Nội dung</li>
             {{-- Danh mục quản lý sản phẩm, danh mục sản phẩm --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="fa-solid fa-cart-shopping"></i>
                     <span class="nav-text">Quản lý sản phẩm</span></a>
                 <ul aria-expanded="false">
                     <li><a href="{{ route('admin.listProducts') }}">Sản phẩm</a></li>
                     <li><a href="{{ route('admin.listCategories') }}">Danh mục</a></li>
                 </ul>
             </li>
             {{-- Danh mục quản lý người dùng --}}
             @if (Auth::user()->rule_id == 1)
                 <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                             class="fa-solid fa-users"></i><span class="nav-text">Quản lý tài khoản</span></a>
                     <ul aria-expanded="false">
                         <li><a href="{{ route('admin.listCustomer') }}">Quản lý người dùng</a></li>
                         <li><a href="{{ route('admin.listEmployees') }}">Quản lý thành viên</a></li>
                         <li><a href="{{route('admin.testimonials')}}">Quản lý đánh giá</a></li>
                     </ul>
                 </li>
             @endif
             {{-- Danh mục quản lý cửa hàng: Sản phẩm order, Giảm giá, Phương thức thanh toán, Thống kê  --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="fa-solid fa-shop"></i><span class="nav-text">Quản lý cửa hàng</span></a>
                 <ul aria-expanded="true">

                        <li><a href="{{ route('admin.listOrders') }}">Quản lý đơn hàng</a></li>
                    @if (Auth::user()->rule_id == 1 )
                        <li><a href="{{ route('admin.formPayment') }}">Phương thức thanh toán</a></li>
                        <li><a href="{{ route('admin.listDiscounts') }}">Quản lý giảm giá</a></li>
                        <li><a href="{{ route('admin.listPoints') }}">Quản lý điểm thưởng</a></li>
                    @endif
                 </ul>
             </li>
             {{-- Danh mục quản lý Blog --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                     <i class="fa-solid fa-blog"></i><span class="nav-text">Quản lý bài viết</span></a>
                 <ul aria-expanded="true">
                     <li><a href="{{ route('admin.blog.list') }}">Bài viết</a></li>
                     <li><a href="#">Danh mục</a></li>
                 </ul>
             </li>
             {{-- <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-chart-bar-33"></i><span class="nav-text">Thống kê</span></a>
                 <ul aria-expanded="true">
                     <li><a href="{{ route('admin.statistics') }}">Thống kê </a></li>

                 </ul>
             </li> --}}
             {{-- Danh mục giao tiếp với khách --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="fa-solid fa-envelope"></i>
                     <span class="nav-text">Email </span>
                 </a>
                 <ul aria-expanded="false">
                     <li><a href="{{ route('admin.inbox') }}">Hộp thư đến</a></li>
                     <li><a href="{{ route('admin.compose') }}">Soạn thư</a></li>
                 </ul>
             </li>
             <li><a href="{{route('admin.listChat')}}"> <i class="fa-solid fa-comments"></i>
                     <span class="nav-text">Tin nhắn</span>
                 </a></li>
             <li><a href="{{ route('admin.calender') }}"><i class="fa-solid fa-calendar-days"></i>
                     <span class="nav-text">
                         Lịch
                     </span></a></li>
         </ul>
     </div>
 </div>
 <!--**********************************
            Sidebar end
        ***********************************-->
