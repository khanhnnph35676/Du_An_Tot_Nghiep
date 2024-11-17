 <!--**********************************
            Sidebar start
        ***********************************-->
 <div class="quixnav">
     <div class="quixnav-scroll">
         <ul class="metismenu" id="menu">
             <li class="nav-label first">Main Menu</li>
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-single-04"></i><span class="nav-text">Dashboard</span></a>
                 <ul aria-expanded="false">
                     <li><a href="{{ route('admin.admin1') }}">Dashboard 1</a></li>
                     <li><a href="./index2.html">Dashboard 2</a></li>
                 </ul>
             </li>
             <li class="nav-label">Content</li>
             {{-- Danh mục quản lý sản phẩm, danh mục sản phẩm --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-app-store"></i><span class="nav-text">Catalog</span></a>
                 <ul aria-expanded="false">
                     <li><a href="{{route('admin.listProducts')}}">Product</a></li>
                     <li><a href="{{route('admin.listCategories')}}">Categories</a></li>
                 </ul>
             </li>
             {{-- Danh mục quản lý người dùng --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-chart-bar-33"></i><span class="nav-text">Customer</span></a>
                 <ul aria-expanded="false">
                     <li><a href="{{route('admin.listCustomer')}}">All Customers</a></li>
                 </ul>
             </li>
             {{-- Danh mục quản lý cửa hàng: Sản phẩm order, Giảm giá, Phương thức thanh toán, Thống kê  --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-world-2"></i><span class="nav-text">Store</span></a>
                 <ul aria-expanded="true">
                     <li><a href="{{route('admin.listOrders')}}">Order</a></li>
                     <li><a href="{{route('admin.listDiscounts')}}">Discounts</a></li>
                     <li><a href="{{route('admin.formPayment') }}">Payment</a></li>
                     <li><a href="./ui-accordion.html">Statistics</a></li>
                 </ul>
             </li>
             {{-- Danh mục giao tiếp với khách --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                         class="icon icon-app-store"></i><span class="nav-text">Apps </span></a>
                 <ul aria-expanded="false">
                     <li><a href="{{ route('admin.profile') }}">Profile</a></li>
                     <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">Email</a>
                         <ul aria-expanded="false">
                             <li><a href="{{ route('admin.inbox') }}">Inbox</a></li>
                             <li><a href="{{ route('admin.compose') }}">Compose</a></li>
                         </ul>
                     </li>
                     <li><a href="./app-profile.html">Chatbox</a></li>
                     <li><a href="{{ route('admin.calender')}}">Calenda</a></li>
                 </ul>
             </li>
             {{-- Danh mục quản lý Blog --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
                <i class="fa-solid fa-blog"></i><span class="nav-text">Quản lý Blog</span></a>
                 <ul aria-expanded="true">
                    <li><a href="{{ route('admin.blog.list')}}">Danh sách Blog</a></li>
                 </ul>
             </li>
             {{-- Danh mục cài đặt: Thoát admin --}}
             <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="icon icon-plug"></i><span
                         class="nav-text">Systems</span></a>
                 <ul aria-expanded="false">
                     <li><a href="./uc-select2.html">Logout</a></li>
                 </ul>
             </li>

         </ul>
     </div>
 </div>
 <!--**********************************
            Sidebar end
        ***********************************-->
