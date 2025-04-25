@extends('site.layouts.master')
@section('title')
    {{ $config->meta_title ?? $config->web_title }}
@endsection
@section('description')
    {{ $config->web_des }}
@endsection
@section('image')
    {{ url('' . $banners[0]->image->path) }}
@endsection
@section('css')
    <style>
        .user-link-section-content {
            /* margin-top: 30px; */
            margin-bottom: 30px;
            padding: 30px 40px;
            background-color: #f5f5f5;
            border-radius: 10px;
        }

        .create-user-link-section-title {
            font-size: 24px;
            font-weight: 600;
            /* margin-bottom: 20px; */
        }

        .create-user-link-section-note {
            font-size: 15px;
            color: #000;
            margin-bottom: 20px;
        }

        .create-user-link-section-note p {
            margin-bottom: 0;
        }

        .create-user-link-section-item {
            display: flex;
            justify-content: space-between;
            gap: 10px;
        }

        .create-user-link-section-item .marchant-name select {
            height: 40px;
            background-color: #fff;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 600;
            color: #000;
        }

        .create-user-link-section-item .form-group {
            flex: 1;
            margin-bottom: 15px;
        }

        .create-user-link-section-item .form-group input {
            width: 100%;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            background-color: #fff;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            height: 40px;
            font-size: 15px;
            margin-bottom: 0;
        }

        .create-user-link-section-item .btn-remove-link {
            width: 40px;
            height: 40px;
            background-color: #dddddd;
            border-radius: 10px;
            font-size: 20px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            line-height: 40px;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
        }

        .create-user-link-section-button-add .btn-add-link {
            width: 100%;
            border: 2px solid #0974ba;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            height: 40px;
            font-size: 17px;
            color: #0974ba;
            font-weight: 600;
        }

        .create-user-link-section-button-add .btn-add-link:hover {
            background-color: #0974ba;
            color: #fff;
        }

        .create-user-link-section-button-submit .btn-submit {
            width: 100%;
            border: 2px solid #0974ba;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
            height: 40px;
            font-size: 17px;
            font-weight: 600;
            color: #fff;
            background-color: #0974ba;
            margin-bottom: 15px;
        }

        .create-user-link-section-button-submit .btn-submit:hover {
            background-color: #f69326;
            color: #fff;
            border: 2px solid #f69326;
        }

        .create-user-link-section-request-note {
            font-size: 15px;
            color: #000;
        }

        @media (max-width: 768px) {
            .user-link-section-content {
                padding: 20px 10px;
            }
            .create-user-link-section-title {
                font-size: 20px;
            }
            .create-user-link-section-request-note {
                font-size: 13px;
            }
        }
    </style>
@endsection
@section('content')
    <div class="container">
        <div class="home-banner row">
            <div class="main-banner col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <div class="section_slider swiper-container">
                    <div class="swiper-wrapper">
                        @foreach ($banners as $banner)
                            <div class="swiper-slide">
                                <div class="clearfix">
                                    <a href="{{ $banner->link }}" title="{{ $banner->name }}">
                                        <picture>
                                            <source media="(min-width: 1200px)" srcset="{{ $banner->image->path }}">
                                            <source media="(min-width: 992px)" srcset="{{ $banner->image->path }}">
                                            <source media="(min-width: 569px)" srcset="{{ $banner->image->path }}">
                                            <source media="(max-width: 480px)" srcset="{{ $banner->image->path }}">
                                            <img width="1920" height="694" src="{{ $banner->image->path }}"
                                                alt="{{ $banner->name }}" class="img-responsive center-block" />
                                        </picture>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <script>
                    var swiperslide = new Swiper('.section_slider', {
                        autoplay: {
                            delay: 4500,
                            disableOnInteraction: false
                        }
                    });
                </script>
            </div>
            <div class="small-banner col-xxl-4 col-xl-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 hidden-xs">
                <div class="row" style="min-height: 100%;">
                    @foreach ($smallBanners as $banner)
                        <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-6 col-sm-6 col-xs-12 col-6">
                            <a class="three_banner" href="{{ $banner->link }}" title="{{ $banner->name }}">
                                <img class="lazyload" style="height: 100%;"
                                    src="data:image/png;base64,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"
                                    data-src="{{ $banner->image->path }}" alt="{{ $banner->name }}" />
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <section class="section_2_banner container">
            <div class="row">
                <div class="col-xxl-2 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 col-1"></div>
                @foreach ($smallBanners as $banner)
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-5 col-sm-5 col-xs-5 col-5">
                    <a class="three_banner" href="{{ $banner->link }}" title="{{ $banner->name }}">
                        <img width="600" height="307" class="lazyload"
                            src="data:image/png;base64,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"
                            data-src="{{$banner->image->path}}"
                            alt="{{$banner->name}}" />
                    </a>
                </div>
                @endforeach
                <div class="col-xxl-2 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 col-1"></div>
            </div>
        </section> --}}
    </div>
    @if ($categorySpecialFlashsale)
        <section class="section_flash_sale container">
            <div class="box-deal" style="background-image:url({{ getBanner($categorySpecialFlashsale) }});">
                <div class="title_deal">
                    <a class="title_fl" href="{{ route('front.show-product-category', $categorySpecialFlashsale->slug) }}"
                        title="{{ $categorySpecialFlashsale->name }}">
                        {{ $categorySpecialFlashsale->name }}
                    </a>
                    <div class="count-down">
                        <div class="timer-view" data-countdown="countdown"
                            data-date="{{ date('Y-m-d-H-i-s', strtotime($categorySpecialFlashsale->end_date)) }}">
                        </div>
                    </div>
                </div>
                <div class="box-swi">
                    <div class="swi_deal_pro swiper-container">
                        <div class="swiper-wrapper">
                            @foreach ($categorySpecialFlashsale->products as $product)
                                <div class="item_product_main swiper-slide">
                                    @include('site.products.product_item', ['product' => $product])
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                    <div class="more-pro-deal">
                        <a href="{{ route('front.show-product-category', $categorySpecialFlashsale->slug) }}"
                            title="Xem tất cả sản phẩm" class="a-show-more">Xem tất cả sản phẩm <i
                                class="icon_more"></i></a>
                    </div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            </div>
        </section>
        <script>
            var swiperdeal = new Swiper('.swi_deal_pro', {
                slidesPerView: 4,
                spaceBetween: 15,
                slidesPerGroup: 1,
                navigation: {
                    nextEl: '.box-swi .swiper-button-next',
                    prevEl: '.box-swi .swiper-button-prev',
                },
                breakpoints: {
                    280: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    640: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    },
                    992: {
                        slidesPerView: 4,
                        spaceBetween: 15
                    },
                    1025: {
                        slidesPerView: 4,
                        spaceBetween: 15
                    },
                    1026: {
                        slidesPerView: 3,
                        spaceBetween: 15
                    },
                    1280: {
                        slidesPerView: 4,
                        spaceBetween: 15
                    }
                }
            });
        </script>
    @endif
    @foreach ($categorySpecial as $category)
        @if ($category->image)
            <section class="section_banner">
                <a class="a-banner" href="{{ route('front.show-product-category', $category->slug) }}" title="Banner">
                    <img width="100%" height="164" class="lazyload"
                        src="data:image/png;base64,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"
                        data-src="{{ $category->image ? $category->image->path : '' }}" alt="Banner" />
                </a>
            </section>
        @endif
        <section class="section_combo_product container">
            <div class="title_index">
                <h2 class="h2_title">
                    <a class="main-title" href="{{ route('front.show-product-category', $category->slug) }}"
                        title="{{ $category->name }}">{{ $category->name }}</a>
                    <span class="icon_title">
                        <img width="134" height="24" src="/site/images/icon_combo_product.png?1729657650563"
                            alt="" />
                    </span>
                </h2>
            </div>
            <div class="row">
                @foreach ($category->products as $product)
                    <div class="col-lg-15 col-md-3">
                        <div class="item_product_main">
                            @include('site.products.product_item', ['product' => $product])
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="more-pro-deal">
                <a href="{{ route('front.show-product-category', $category->slug) }}" title="Xem tất cả sản phẩm"
                    class="a-show-more">Xem tất cả sản phẩm <i class="icon_more"></i></a>
            </div>
        </section>
    @endforeach
    @if ($categorySpecialPost->count() > 0)
        @foreach ($categorySpecialPost as $category)
            <section class="secttion_blogs container">
                <div class="row">
                    <div class="col-lg-12 col-md-12">
                        <div class="title_index">
                            <h2 class="h2_title">
                                <a class="main-title" href="javascript:void(0);"
                                    title="{{ $category->name }}">{{ $category->name }}</a>
                                <span class="icon_title">
                                    <img width="134" height="24"
                                        src="/site/images/icon_combo_product.png?1729657650563"
                                        alt="{{ $category->name }}" />
                                </span>
                            </h2>
                        </div>
                        <div class="block-blog">
                            <div class="blog-swiper swiper-container">
                                <div class="swiper-wrapper">
                                    @foreach ($category->posts as $post)
                                        <div class="swiper-slide">
                                            <div class="item-blog">
                                                <a class="pos_a_blog"
                                                    href="{{ route('front.detail-blog', $post->slug) }}"
                                                    title="{{ $post->name }}">
                                                    {{ $post->name }}
                                                </a>
                                                <div class="block-thumb">
                                                    <img width="600" height="380"
                                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                        data-src="{{ $post->image ? $post->image->path : '' }}"
                                                        alt="{{ $post->name }}" class="lazyload img-responsive" />
                                                </div>
                                                <div class="block-content">
                                                    <h3>
                                                        <a class="line-clamp-2"
                                                            href="{{ route('front.detail-blog', $post->slug) }}"
                                                            title="{{ $post->name }}">
                                                            {{ $post->name }}
                                                        </a>
                                                    </h3>
                                                    <p class="update_date clearfix">
                                                        <span class="user_name">Admin</span>
                                                        <span class="user_date">
                                                            {{ date('d/m/Y', strtotime($post->created_at)) }}</span>
                                                    </p>
                                                    <div class="box-blog-hid">
                                                        <p class="line-clamp-3">
                                                            {{ $post->intro }}
                                                        </p>
                                                        <a class="viewmore"
                                                            href="{{ route('front.detail-blog', $post->slug) }}"
                                                            title="Xem thêm">Xem thêm</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            {{-- <div class="more-pro-deal">
                            <a href="tin-tuc" title="Xem tất cả tin tức" class="a-show-more">Xem tất cả tin tức<i
                                    class="icon_more"></i></a>
                        </div> --}}
                        </div>
                    </div>
                </div>
            </section>
        @endforeach
    @endif
    <script>
        var swiperblog = new Swiper('.blog-swiper', {
            slidesPerView: 3,
            loop: false,
            grabCursor: true,
            spaceBetween: 30,
            roundLengths: true,
            slideToClickedSlide: false,
            autoplay: false,
            navigation: {
                nextEl: '.block-blog .section-next',
                prevEl: '.block-blog .section-prev',
            },
            breakpoints: {
                300: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                500: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 20
                },
                768: {
                    slidesPerView: 2,
                    spaceBetween: 20
                },
                991: {
                    slidesPerView: 3,
                    spaceBetween: 20
                }
            }
        });
    </script>
@endsection
@push('script')
@endpush
