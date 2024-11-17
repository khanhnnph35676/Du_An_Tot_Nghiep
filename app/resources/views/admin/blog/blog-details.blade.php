
@extends('admin.layout.default')

@section('content')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.22.0/standard/ckeditor.js"></script>
    <style>
        .cke_notification { 
            display: none !important; 
        }
    </style>

<!--Empty Cart Start-->
<div class="empty-cart-page section-padding-5">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-lg-9">
                <div class="blog-single">
                    <h2 class="title text-primary">{{$Blog->BlogTitle}}</h2>
                    <div class="articles-date">{{$Blog->created_at}}</div>
                    <div class="blogDesc mb-30 text-dark">{!!$Blog->BlogDesc!!}</div>
                    {!!$Blog->BlogContent!!}
                </div>
            </div>
            <div class="col-lg-3">
                <div class="sidebar-post">
                    <h3 class="widget-title">Bài viết gần đây</h3>
                    <ul class="post-items">
                        {{-- @foreach($list_new_blog as $key => $new_blog)
                        <li>
                            <div class="single-post">
                                <div class="post-thumb">
                                    <a href="{{URL::to('/blog/'.$new_blog->BlogSlug)}}"><img src="{{asset('public/storage/kidoldash/images/blog/'.$new_blog->BlogImage)}}" alt=""></a>
                                </div>
                                <div class="post-content">
                                    <div class="post-title"><a class="two-line" href="{{URL::to('/blog/'.$new_blog->BlogSlug)}}">{{$new_blog->BlogTitle}}</a></div>
                                    <span class="date">{{$new_blog->created_at->format('d-m-Y H:i:s')}}</span>
                                </div>
                            </div>
                        </li>
                        @endforeach --}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!--Empty Cart End-->

@endsection