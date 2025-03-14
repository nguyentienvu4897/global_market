@extends('site.layouts.master')
@section('title')
    {{ $cate_title }}
@endsection
@section('description')
    {{ $cate_des ?? '' }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection

@section('css')
    <link href="{{ asset('site/css/blog_article_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <style>
        .text-limit-3-line {
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
    </style>
@endsection

@section('content')
    <section class="bread-crumb"
        style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
        <div class="container">
            <div class="title-bread-crumb"> Tin tức
            </div>
            <ul class="breadcrumb">
                <li class="home">
                    <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                    <span class="mr_lr">/</span>
                </li>
                <li><strong><span>Tin tức</span></strong></li>
            </ul>
        </div>
    </section>
    <div class="blog_wrapper layout-blog" itemscope itemtype="https://schema.org/Blog">
        <div class="container">
            <div class="row">
                <div class="right-content col-lg-9 col-12">
                    <h1 class="title-page">{{ $cate_title }}</h1>
                    <section class="list-blogs blog-main listmain_blog clearfix">
                        <div class="row_blog_responsive">
                            <div class="row clearfix">
                                @foreach($blogs as $post)
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="item_blog_index clearfix ">
                                        <div class="img-blog">
                                            <a class="image-blog"
                                                href="{{ route('front.detail-blog', $post->slug) }}"
                                                title="{{ $post->name }}">
                                                <img width="600" height="380"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                    data-src="{{ $post->image->path }}"
                                                    alt="{{ $post->name }}"
                                                    class="lazyload img-responsive" />
                                            </a>
                                        </div>
                                        <div class="blog_content">
                                            <h3><a href="{{ route('front.detail-blog', $post->slug) }}"
                                                    title="{{ $post->name }}">{{ $post->name }}</a></h3>
                                            <p class="update_date clearfix">
                                                <span class="user_date">
                                                    <svg aria-hidden="true" focusable="false" data-prefix="fal"
                                                        data-icon="clock" role="img" xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 512 512" class="svg-inline--fa fa-clock fa-w-16">
                                                        <path fill="currentColor"
                                                            d="M256 8C119 8 8 119 8 256s111 248 248 248 248-111 248-248S393 8 256 8zm216 248c0 118.7-96.1 216-216 216-118.7 0-216-96.1-216-216 0-118.7 96.1-216 216-216 118.7 0 216 96.1 216 216zm-148.9 88.3l-81.2-59c-3.1-2.3-4.9-5.9-4.9-9.7V116c0-6.6 5.4-12 12-12h14c6.6 0 12 5.4 12 12v146.3l70.5 51.3c5.4 3.9 6.5 11.4 2.6 16.8l-8.2 11.3c-3.9 5.3-11.4 6.5-16.8 2.6z"
                                                            class=""></path>
                                                    </svg>
                                                    {{ date('d/m/Y', strtotime($post->created_at)) }}
                                                </span>
                                            </p>
                                            <p class="blog_description text-limit-3-line">{{ $post->intro }}</p>
                                            <a class="read-more"
                                                href="{{ route('front.detail-blog', $post->slug) }}"
                                                title="Đọc tiếp">Đọc tiếp</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="text-xs-right pageinate-page-blog section clearfix">
                                {{ $blogs->links() }}
                            </div>
                        </div>
                    </section>
                </div>
                <div class="blog_left_base col-lg-3 col-12">
                    @include('site.blogs.nav-blog', ['newBlogs' => $newBlogs])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
