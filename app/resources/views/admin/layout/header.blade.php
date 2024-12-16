 <!--**********************************
            Nav header start
        ***********************************-->
 <style>
     .list-unstyled {
         overflow: auto;
         max-height: 280px;
     }

     .list-unstyled::-webkit-scrollbar {
         width: 2px;
         /* Độ rộng của scrollbar */
     }

     .list-unstyled::-webkit-scrollbar-thumb {
         background: #888;
         /* Màu của thanh cuộn */
         border-radius: 4px;
         /* Bo tròn góc */
     }

     .list-unstyled::-webkit-scrollbar-thumb:hover {
         background: #555;
         /* Màu khi hover */
     }

     .media-body {
         max-width: 400px;
     }
 </style>
 <div class="nav-header">
     <div class="nav-control">
         <div class="hamburger">
             <span class="line"></span><span class="line"></span><span class="line"></span>
         </div>
     </div>
 </div>
 <!--**********************************
            Nav header end
        ***********************************-->
 <!--**********************************
            Header start
        ***********************************-->
 <div class="header">
     <div class="header-content">
         <nav class="navbar navbar-expand">
             <div class="collapse navbar-collapse justify-content-between">
                 <div class="header-left">
                     <div class="search_bar dropdown">
                         <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                             <i class="mdi mdi-magnify"></i>
                         </span>
                         <div class="dropdown-menu p-0 m-0">
                             <form>
                                 <input class="form-control" type="search" placeholder="Tìm kiếm" aria-label="Search">
                             </form>
                         </div>
                     </div>
                 </div>

                 <ul class="navbar-nav header-right">
                     <li class="nav-item dropdown notification_dropdown">
                         <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                             <i class="mdi mdi-bell"></i>
                             <div class="pulse-css"></div>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right">
                             <ul class="list-unstyled">
                                 @foreach ($messages as $item)
                                     <li class="media dropdown-item" id="message-{{ $item->id }}">
                                         <a href="{{ route('admin.orderDetail', ['order_id' => $item->order->id]) }}"
                                             class="d-flex align-items-center mr-3">
                                             <span class="primary mr-3"><i class="ti-shopping-cart"></i></span>
                                             <div class="media-body" style="max:width:300px;">
                                                 <span><strong>{{ $item->user->email }}</strong> mới đặt hàng</span>
                                                 <br>
                                                 <strong>Mã đơn: {{ $item->order->order_code }}</strong>
                                             </div>
                                         </a>
                                         <div>
                                             <span class="text-end">Ngày
                                                 {{ $item->order->created_at->format('d-m') . ' lúc ' . $item->order->created_at->format('H:i') }}</span>
                                         </div>
                                         {{--  --}}
                                         <form action="{{ route('admin.deleteMessage', $item->id) }}" method="POST"
                                             class="ml-3" id="delete-form-{{ $item->id }}">
                                             @csrf
                                             @method('DELETE')
                                             <button
                                                 class="badge-circle text-white bg-primary d-flex align-items-center delete-mes"
                                                 data-id="{{ $item->id }}"
                                                 onclick="deleteMessage({{ $item->id }})">x</button>
                                         </form>
                                     </li>
                                 @endforeach

                                 {{-- <li class="media dropdown-item">
                                    <span class="primary"><i class="ti-shopping-cart"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Jennifer</strong> purchased Light Dashboard 2.0.</p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="danger"><i class="ti-bookmark"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>Robin</strong> marked a <strong>ticket</strong> as unsolved.
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="primary"><i class="ti-heart"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong>David</strong> purchased Light Dashboard 1.0.</p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li>
                                <li class="media dropdown-item">
                                    <span class="success"><i class="ti-image"></i></span>
                                    <div class="media-body">
                                        <a href="#">
                                            <p><strong> James.</strong> has added a<strong>customer</strong>
                                                Successfully
                                            </p>
                                        </a>
                                    </div>
                                    <span class="notify-time">3:20 am</span>
                                </li> --}}
                             </ul>
                             <a class="all-notification" href="#">Xem thêm <i class="ti-arrow-right"></i></a>
                         </div>
                     </li>
                     <li class="nav-item dropdown header-profile">
                         <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                             <i class="mdi mdi-account"></i>
                         </a>
                         <div class="dropdown-menu dropdown-menu-right">
                             <a href="" class="dropdown-item">
                                 <i class="icon-user"></i>
                                 <span class="ml-2">Thông tin cá nhân </span>
                             </a>
                             <a href="" class="dropdown-item">
                                 <i class="icon-envelope-open"></i>
                                 <span class="ml-2">Giao tiếp khách hàng </span>
                             </a>
                             <div class="dropdown-item">
                                 <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                                     @csrf
                                     <button type="submit" class="btn btn text-dark">
                                         <i class="fa-solid fa-arrow-right-from-bracket fa-sm"
                                             style="color: #000000;"></i>
                                         Đăng Xuất
                                     </button>
                                 </form>
                             </div>

                         </div>
                     </li>
                 </ul>
             </div>
         </nav>
     </div>
 </div>
 <script>
    //  document.querySelectorAll('.delete-mes').forEach(function(button) {
    //      button.addEventListener('click', function(e) {
    //          e.preventDefault(); // Prevent the page from reloading

    //          const messageId = this.getAttribute('data-id'); // Get the message ID
    //          const messageRow = document.getElementById(
    //              `message-${messageId}`); // Find the corresponding row
    //          if (messageRow) {
    //              messageRow.remove();
    //          }
    //      });
    //  });
 </script>
 <!--**********************************
            Header end ti-comment-alt
        ***********************************-->
