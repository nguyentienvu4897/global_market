@extends('site.layouts.master')
@section('title')
    {{ $product->name }}
@endsection
@section('description')
    {{ $product->short_des }}
@endsection

@section('css')
    <link href="/site/css/product_style.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link rel="preload stylesheet" as="style" fetchpriority="low" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/css/swiper.min.css">
    <link rel="preload stylesheet" as="style" fetchpriority="low" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/4.3.5/css/swiper.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script defer fetchpriority="low" src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.4.1/js/swiper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .text-limit-3-line {
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }
        .hidden {
            display: none;
        }

        .product-attributes {
            margin-bottom: 0 !important;
        }
        .product-attributes label {
            font-weight: 600;
            margin-bottom: 0 !important;
        }
        .product-attribute-values {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .product-attribute-values .badge, .product-attribute-values .badge+ .badge {
            width: auto;
            border: 1px solid #0974ba;
            padding: 2px 10px;
            border-radius: 5px;
            font-size: 14px;
            color: #0974ba;
            height: 30px;
            cursor: pointer;
            pointer-events: auto;
        }
        .product-attribute-values .badge:hover {
            background-color: #0974ba;
            color: #fff;
        }
        .product-attribute-values .badge.active {
            background-color: #0974ba;
            color: #fff;
        }
    </style>
@endsection

@section('content')
    <div ng-controller="ProductDetailController">
        <section class="bread-crumb"
            style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
            <div class="container">
                <div class="title-bread-crumb">Sản phẩm
                </div>
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="{{route('front.home-page')}}"><span>Trang chủ</span></a>
                        <span class="mr_lr">/</span>
                    </li>
                    <li><strong><span>{{ $product->name }}</span></strong>
                    <li>
                </ul>
            </div>
        </section>
        <section class="product layout-product" itemscope itemtype="https://schema.org/Product">
            <div class="container">
                <div class="details-product">
                    <div class="row">
                        <div class="col-lg-9 col-col-md-9 col-sm-12 col-xs-12">
                            <div class="row">
                                <div class="product-detail-left product-images col-12 col-md-5 col-lg-5">
                                    <div class="product-image-block relative">
                                        <div class="swiper-container gallery-top">
                                            <div class="swiper-wrapper" id="lightgallery">
                                                @foreach ($product->galleries as $item)
                                                <a class="swiper-slide" data-hash="0"
                                                    href="{{ $item->image->path }}"
                                                    title="Click để xem">
                                                    <img height="480" width="480"
                                                        src="{{ $item->image->path }}"
                                                        alt="{{ $product->name }}"
                                                        data-image="{{ $item->image->path }}"
                                                        class="img-responsive mx-auto d-block swiper-lazy" />
                                                </a>
                                                @endforeach
                                                <a class="swiper-slide" data-hash="0"
                                                    href="{{ $product->image->path }}"
                                                    title="Click để xem">
                                                    <img height="480" width="480"
                                                        src="{{ $product->image->path }}"
                                                        alt="{{ $product->name }}"
                                                        data-image="{{ $product->image->path }}"
                                                        class="img-responsive mx-auto d-block swiper-lazy" />
                                                </a>
                                            </div>
                                        </div>
                                        {{-- <div class="product-wish">
                                            <a href="javascript:void(0)" class="setWishlist btn-anima"
                                                data-wish="{{ $product->slug }}" tabindex="0"
                                                title="Thêm vào yêu thích">
                                                <img class="lazyload" width="24" height="24"
                                                    src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                    data-src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                    alt="Thêm vào yêu thích" />
                                            </a>
                                        </div> --}}
                                        <div class="swiper-container gallery-thumbs">
                                            <div class="swiper-wrapper">
                                                @foreach ($product->galleries as $item)
                                                <div class="swiper-slide" data-hash="0">
                                                    <div class="p-100">
                                                        <img height="80" width="80"
                                                            src="{{ $item->image->path }}"
                                                            alt="{{ $product->name }}"
                                                            data-image="{{ $item->image->path }}"
                                                            class="swiper-lazy" />
                                                    </div>
                                                </div>
                                                @endforeach
                                                <div class="swiper-slide" data-hash="0">
                                                    <div class="p-100">
                                                        <img height="80" width="80"
                                                            src="{{ $product->image->path }}"
                                                            alt="{{ $product->name }}"
                                                            data-image="{{ $product->image->path }}"
                                                            class="swiper-lazy" />
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="swiper-button-next"></div>
                                            <div class="swiper-button-prev"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="details-pro col-12 col-md-7 col-lg-7">
                                    <h1 class="title-product">{{ $product->name }}</h1>
                                    {{-- <div class="product-top clearfix">
                                        <div class="sku-product clearfix">
                                            <span class="d-none" itemprop="brand" itemtype="http://schema.org/Brand"
                                                itemscope>
                                                <meta itemprop="name" content="{{ $product->brand->name }}" />
                                                Thương hiệu: <strong>{{ $product->brand->name }}</strong>
                                            </span>
                                            <span class="variant-sku" itemprop="sku" content="Đang cập nhật">Mã: <span
                                                    class="a-sku">Đang cập nhật</span></span><br>
                                            <span class="d-none" itemprop="type" itemtype="http://schema.org/Type"
                                                itemscope>
                                                <meta itemprop="name" content="{{ $product->category->name }}" />
                                                Chất liệu: <strong>{{ $product->category->name }}</strong>
                                            </span>
                                        </div>
                                    </div> --}}
                                    <form class="form-inline">
                                        <div class="inventory_quantity">
                                            <span class="mb-break">
                                                <span class="stock-brand-title">Danh mục:</span>
                                                <span class="a-vendor" style="cursor: pointer;" onclick="window.location.href='{{ route('front.show-product-category', $product->category->slug) }}'">{{ $product->category->name }}
                                                </span>
                                            </span>
                                        </div>
                                        <div class="price-box clearfix">
                                            <span class="special-price">
                                                <span class="price product-price">{{ formatCurrency($product->price) }}₫</span>
                                                <meta itemprop="price" content="{{ formatCurrency($product->price) }}">
                                                <meta itemprop="priceCurrency" content="VND">
                                            </span>
                                            @if ($product->base_price > 0)
                                            <!-- Giá Khuyến mại -->
                                            <span class="old-price" itemprop="priceSpecification" itemscope=""
                                                itemtype="http://schema.org/priceSpecification">
                                                <del class="price product-price-old">
                                                    {{ formatCurrency($product->base_price) }}₫
                                                </del>
                                                <meta itemprop="price" content="{{ formatCurrency($product->base_price) }}">
                                                <meta itemprop="priceCurrency" content="VND">
                                            </span>
                                            <!-- Giás gốc -->
                                            <span class="label_product">-
                                                {{round(($product->base_price - $product->price) / $product->base_price * 100, 0)}}%
                                            </span>
                                            @endif
                                        </div>
                                        <div class="product-summary">
                                            <div class="title_summary">Mô tả sản phẩm</div>
                                            <div class="rte">
                                                {!! $product->intro !!}
                                            </div>
                                        </div>
                                        @if(isset($product->attributes) && count($product->attributes) > 0)
                                        @foreach ($product->attributes as $index => $attribute)
                                            <div class="mt-2 product-attributes">
                                                <label>{{ $attribute['name'] }}</label>
                                                <div class="product-attribute-values">
                                                    @foreach ($attribute['values'] as $value)
                                                        <div class="badge badge-primary" data-value="{{ $value }}" data-name="{{ $attribute['name'] }}" data-index="{{ $index }}">{{ $value }}</div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        @endforeach
                                        @endif
                                        <div class="form-product  ">
                                            <div class="clearfix form-group ">
                                                <div class="flex-quantity">
                                                    <div class="custom custom-btn-number show">
                                                        <div class="input_number_product">
                                                            <button class="btn_num num_1 button button_qty"
                                                                onclick="minusQuantity()"
                                                                type="button">&minus;</button>
                                                            <input type="text" id="qtym" name="quantity"
                                                                value="1" maxlength="3"
                                                                class="form-control prd_quantity"
                                                                ng-model="form.quantity">
                                                            <button class="btn_num num_2 button button_qty"
                                                                onclick="plusQuantity()"
                                                                type="button"><span>&plus;</span></button>
                                                        </div>
                                                    </div>
                                                    <div class="mb-break">
                                                        <div style="font-size: 18px">
                                                            <span><i class="fa fa-tag" style="color: #f69326"></i><i style="font-size: 16px">Thưởng hoa hồng lên đến</i> <span style="color: #0974ba; font-weight:bold;">{{ formatCurrency($product->revenue_price) }}₫</span></span>
                                                        </div>
                                                    </div>
                                                    <div class="btn-mua button_actions clearfix">
                                                        <button type="submit" ng-click="addToCartFromProductDetail()"
                                                            class="btn btn_base normal_button btn_add_cart btn-cart">
                                                            <span class="txt-main text_1"><i></i>Thêm vào giỏ hàng</span>
                                                        </button>
                                                        <a href="javascript:void(0)" class="btn btn-buy-now" ng-click="addToCartCheckoutFromProductDetail()">
                                                            <span class="txt-main text_1">Mua trực tiếp</span></a>
                                                        @if ($product->type == 1)
                                                            <a href="{{ $product->short_link ?? $product->aff_link }}" class="btn btn-buy-now" target="_blank" style="margin-top: 15px; margin-left: 0; width: 100%; background-color: #f69326;">
                                                                <span class="txt-main text_1">Mua qua sàn thương mại</span></a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                            {{-- <div class="title_section_coupon">Mua nhiều giảm giá</div>
                            <section class="section_coupon">
                                <div class="coupon-swiper swiper-container">
                                    <div class="swiper-wrapper">
                                        <div class="item_coupon swiper-slide">
                                            <div class="image">
                                                <img width="88" height="88"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_coupon.png?1729657650563"
                                                    alt="10%">
                                                <span>10%</span>
                                            </div>
                                            <div class="content_wrap">
                                                <div class="content-top">
                                                    NHẬP MÃ:DINOS10
                                                    <span>Mã giảm 10% cho đơn hàng tối thiểu 500k.</span>
                                                </div>
                                                <div class="content-bottom">
                                                    <div class="coupon-code js-copy" data-copy="DINOS10"
                                                        title="Sao chép">Sao chép mã</div>
                                                    <a title="Chi tiết" href="javascript:void(0)" class="info-button"
                                                        data-coupon="DINOS10"
                                                        data-content="Áp dụng cho đơn hàng từ 500k trở lên. Không đi kèm với chương trình khác">Điều
                                                        kiện</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item_coupon swiper-slide">
                                            <div class="image">
                                                <img width="88" height="88"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_coupon.png?1729657650563"
                                                    alt="15%">
                                                <span>15%</span>
                                            </div>
                                            <div class="content_wrap">
                                                <div class="content-top">
                                                    NHẬP MÃ:DINOS15
                                                    <span>Mã giảm 15% cho đơn hàng tối thiểu 800k.</span>
                                                </div>
                                                <div class="content-bottom">
                                                    <div class="coupon-code js-copy" data-copy="DINOS15"
                                                        title="Sao chép">Sao chép mã</div>
                                                    <a title="Chi tiết" href="javascript:void(0)" class="info-button"
                                                        data-coupon="DINOS15"
                                                        data-content="Áp dụng cho đơn hàng từ 800k trở lên<br>
                                        Không đi kèm với chương trình khác">Điều
                                                        kiện</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item_coupon swiper-slide">
                                            <div class="image">
                                                <img width="88" height="88"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_coupon.png?1729657650563"
                                                    alt="20%">
                                                <span>20%</span>
                                            </div>
                                            <div class="content_wrap">
                                                <div class="content-top">
                                                    NHẬP MÃ:DINOS20
                                                    <span>Mã giảm 20% cho đơn hàng tối thiểu 1000k.</span>
                                                </div>
                                                <div class="content-bottom">
                                                    <div class="coupon-code js-copy" data-copy="DINOS20"
                                                        title="Sao chép">Sao chép mã</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="item_coupon swiper-slide">
                                            <div class="image">
                                                <img width="88" height="88"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_coupon.png?1729657650563"
                                                    alt="0K">
                                                <span>0K</span>
                                            </div>
                                            <div class="content_wrap">
                                                <div class="content-top">
                                                    NHẬP MÃ:FREESHIP
                                                    <span>Miễn phí vận chuyển cho đơn hàng trên 300k.</span>
                                                </div>
                                                <div class="content-bottom">
                                                    <div class="coupon-code js-copy" data-copy="FREESHIP"
                                                        title="Sao chép">Sao chép mã</div>
                                                    <a title="Chi tiết" href="javascript:void(0)" class="info-button"
                                                        data-coupon="FREESHIP"
                                                        data-content="Áp dụng cho đơn hàng từ 300k trở lên">Điều kiện</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                            <div class="popup-coupon">
                                <div class="content">
                                    <div class="title">Thông tin voucher</div>
                                    <a href="javascript:void(0)" class="close-pop">
                                        <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                            version="1.1" x="0px" y="0px" viewBox="0 0 512.001 512.001"
                                            style="enable-background:new 0 0 512.001 512.001;" xml:space="preserve">
                                            <g>
                                                <g>
                                                    <path
                                                        d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z">
                                                    </path>
                                                </g>
                                            </g>
                                        </svg>
                                    </a>
                                    <ul>
                                        <li>
                                            <span>Mã khuyến mãi:</span>
                                            <span class="code"></span>
                                        </li>
                                        <li>
                                            <span>Điều kiện:</span>
                                            <span class="dieukien"></span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <script>
                                var coupon = new Swiper('.coupon-swiper', {
                                    slidesPerView: 4,
                                    loop: false,
                                    grabCursor: true,
                                    spaceBetween: 10,
                                    roundLengths: true,
                                    slideToClickedSlide: false,
                                    autoplay: false,
                                    breakpoints: {
                                        300: {
                                            slidesPerView: 1.2,
                                            spaceBetween: 10
                                        },
                                        500: {
                                            slidesPerView: 1.2,
                                            spaceBetween: 10
                                        },
                                        640: {
                                            slidesPerView: 1.8,
                                            spaceBetween: 10
                                        },
                                        767: {
                                            slidesPerView: 2.5,
                                            spaceBetween: 10
                                        },
                                        1260: {
                                            slidesPerView: 2.5,
                                            spaceBetween: 10
                                        },
                                        1367: {
                                            slidesPerView: 2.6,
                                            spaceBetween: 10
                                        },
                                        1440: {
                                            slidesPerView: 2.8,
                                            spaceBetween: 10
                                        },
                                        1560: {
                                            slidesPerView: 3.2,
                                            spaceBetween: 10
                                        },
                                        1750: {
                                            slidesPerView: 4,
                                            spaceBetween: 10
                                        }
                                    }
                                });
                                $(document).on('click', '.js-copy', function(e) {
                                    e.preventDefault();
                                    var copyText = $(this).attr('data-copy');
                                    var copyTextarea = document.createElement("textarea");
                                    copyTextarea.textContent = copyText;
                                    copyTextarea.style.position = "fixed";
                                    document.body.appendChild(copyTextarea);
                                    copyTextarea.select();
                                    document.execCommand("copy");
                                    document.body.removeChild(copyTextarea);
                                    var cur_text = $(this).text();
                                    var $cur_btn = $(this);
                                    $(this).addClass("iscopied");
                                    $(this).text("Đã lưu");
                                    setTimeout(function() {
                                        $cur_btn.removeClass("iscopied");
                                        $cur_btn.text(cur_text);
                                    }, 1500)
                                })
                                $('.info-button').click(function() {
                                    var code = $(this).attr('data-coupon'),
                                        dieukien = $(this).attr('data-content');
                                    $('.popup-coupon .code').html(code);
                                    $('.popup-coupon .dieukien').html(dieukien);
                                    $('.popup-coupon, .backdrop__body-backdrop___1rvky').addClass('active');
                                });
                                $('.close-pop').click(function() {
                                    $('.popup-coupon, .backdrop__body-backdrop___1rvky').removeClass('active');
                                });
                            </script> --}}
                            <div class="product-tab e-tabs not-dqtab">
                                <ul class="tabs tabs-title clearfix">
                                    <li class="tab-link active" data-tab="#tab-1">
                                        <h3>Chi tiết sản phẩm</h3>
                                    </li>
                                    <li class="tab-link" data-tab="#tab-2" >
                                        <h3>Đánh giá sản phẩm</h3>
                                    </li>
                                </ul>
                                <div class="tab-float">
                                    <div id="tab-1" class="tab-content active content_extab">
                                        <div class="rte product_getcontent">
                                            {!! $product->body !!}
                                        </div>
                                    </div>
                                    <div id="tab-2" class="tab-content content_extab">
                                        <div class="rte product_getcontent" id="onireviewapp">
                                            @include('site.partials.onireview')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="details-pro-3 col-12 col-md-12 col-lg-3">
                            <div class="row">
                                <div class="col-lg-12 col-col-md-12 col-sm-6 col-xs-12">
                                    <div class="product-favi">
                                        <a href="banh-keo" title="Có thể bạn thích">
                                            <div class="title-head">
                                                Có thể bạn thích
                                            </div>
                                        </a>
                                        <div class="product-favi-content">
                                            @foreach ($bestSellerProducts as $item)
                                            <div class="product-view">
                                                <a class="image_thumb" href="{{ route('front.show-product-detail', $item->slug) }}"
                                                    title="{{ $item->name }}">
                                                    <img width="370" height="480" class="lazyload"
                                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                        data-src="{{ $item->image->path }}"
                                                        alt="{{ $item->name }}">
                                                </a>
                                                <div class="product-info">
                                                    <h3 class="product-name"><a href="{{ route('front.show-product-detail', $item->slug) }}"
                                                            title="{{ $item->name }}">{{ $item->name }}</a></h3>
                                                    <div class="price-box">
                                                        <span class="price">{{ formatCurrency($item->price) }}₫</span>
                                                        @if ($item->base_price > 0)
                                                        <span class="compare-price">{{ formatCurrency($item->base_price) }}₫</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-col-md-12 col-sm-6 col-xs-12">
                                    <a class="banner_right_pro" href="javascript:void(0);" title="Banner">
                                        <img width="375" height="525"
                                            src="{{$product->image->path}}"
                                            alt="Banner" />
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12 col-col-md-12 col-sm-12 col-xs-12">
                            <div class="productRelate">
                                <div class="title_index">
                                    <h2 class="h2_title">
                                        <a class="main-title" href="{{ route('front.show-product-category', $product->category->slug) }}" title="Sản phẩm liên quan">Sản phẩm liên
                                            quan</a>
                                        <span class="icon_title">
                                            <img width="134" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_lienquan_sport.png?1729657650563"
                                                alt="Sản phẩm liên quan" />
                                        </span>
                                    </h2>
                                </div>
                                <div class="product-relate-swiper swiper-container">
                                    <div class="swiper-wrapper">
                                        @foreach ($productsRelated as $item)
                                        <div class="swiper-slide">
                                            <div class=" item_product_main">
                                                @include('site.products.product_item', ['product' => $item])
                                            </div>
                                        </div>
                                        @endforeach
                                    </div>
                                    <div class="swiper-button-prev"></div>
                                    <div class="swiper-button-next"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script>
            var variantsize = false;
            var ww = $(window).width();

            function validate(evt) {
                var theEvent = evt || window.event;
                var key = theEvent.keyCode || theEvent.which;
                key = String.fromCharCode(key);
                var regex = /[0-9]|\./;
                if (!regex.test(key)) {
                    theEvent.returnValue = false;
                    if (theEvent.preventDefault) theEvent.preventDefault();
                }
            }
            jQuery(function($) {
                $('.selector-wrapper').hide();

                $('.selector-wrapper').css({
                    'text-align': 'left',
                    'margin-bottom': '15px'
                });
            });

            jQuery('.swatch :radio').change(function() {
                var optionIndex = jQuery(this).closest('.swatch').attr('data-option-index');
                var optionValue = jQuery(this).val();
                jQuery(this)
                    .closest('form')
                    .find('.single-option-selector')
                    .eq(optionIndex)
                    .val(optionValue)
                    .trigger('change');
                $(this).closest('.swatch').find('.header .value-roperties').html(optionValue);
            });
            setTimeout(function() {
                $('.swatch .swatch-element').each(function() {
                    $(this).closest('.swatch').find('.header .value-roperties').html($(this).closest('.swatch')
                        .find('input:checked').val());
                });
            }, 500);
        </script>
        <script>
            function activeTab(obj) {
                $('.product-tab ul li').removeClass('active');
                $(obj).addClass('active');
                var id = $(obj).attr('data-tab');
                $('.tab-content').removeClass('active');
                $(id).addClass('active');
            }
            $('.product-tab ul li').click(function() {
                activeTab(this);
                return false;
            });
            var galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 4,
                slidesPerView: 10,
                freeMode: true,
                lazy: true,
                watchSlidesVisibility: true,
                watchSlidesProgress: true,
                hashNavigation: true,
                slideToClickedSlide: true,
                breakpoints: {
                    260: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    300: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    500: {
                        slidesPerView: 3,
                        spaceBetween: 10,
                    },
                    640: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                    1199: {
                        slidesPerView: 4,
                        spaceBetween: 10,
                    },
                },
                navigation: {
                    nextEl: '.gallery-thumbs .swiper-button-next',
                    prevEl: '.gallery-thumbs .swiper-button-prev',
                },
            });
            var galleryTop = new Swiper('.gallery-top', {
                spaceBetween: 0,
                lazy: true,
                hashNavigation: true,
                thumbs: {
                    swiper: galleryThumbs
                }
            });
            var swiperrela = new Swiper('.product-relate-swiper', {
                slidesPerView: 5,
                spaceBetween: 20,
                slidesPerGroup: 1,
                navigation: {
                    nextEl: '.product-relate-swiper .swiper-button-next',
                    prevEl: '.product-relate-swiper .swiper-button-prev',
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
                    1024: {
                        slidesPerView: 4,
                        spaceBetween: 15
                    },
                    1700: {
                        slidesPerView: 5,
                        spaceBetween: 15
                    }
                }
            });
            $(document).ready(function() {
                $("#lightgallery").lightGallery({
                    thumbnail: false
                });
            });
        </script>
    </div>
@endsection

@push('script')
<script>
    // Plus number quantiy product detail
    var plusQuantity = function() {
        if ( jQuery('input[name="quantity"]').val() != undefined ) {
            var currentVal = parseInt(jQuery('input[name="quantity"]').val());
            if (!isNaN(currentVal)) {
                jQuery('input[name="quantity"]').val(currentVal + 1);
            } else {
                jQuery('input[name="quantity"]').val(1);
            }
        }else {
            console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
        }
    }
    // Minus number quantiy product detail
    var minusQuantity = function() {
        if ( jQuery('input[name="quantity"]').val() != undefined ) {
            var currentVal = parseInt(jQuery('input[name="quantity"]').val());
            if (!isNaN(currentVal) && currentVal > 1) {
                jQuery('input[name="quantity"]').val(currentVal - 1);
            }
        }else {
            console.log('error: Not see elemnt ' + jQuery('input[name="quantity"]').val());
        }
    }
    app.controller('ProductDetailController', function($scope, $http, $interval, cartItemSync, $rootScope, $compile) {
        $scope.product = @json($product);
        $scope.form = {
            quantity: 1
        };

        $scope.selectedAttributes = [];
        jQuery('.product-attribute-values .badge').click(function() {
            if(!jQuery(this).hasClass('active')) {
                jQuery(this).parent().find('.badge').removeClass('active');
                jQuery(this).addClass('active');
                if ($scope.selectedAttributes.length > 0 && $scope.selectedAttributes.find(item => item.index == jQuery(this).data('index'))) {
                    $scope.selectedAttributes.find(item => item.index == jQuery(this).data('index')).value = jQuery(this).data('value');
                } else {
                    let index = jQuery(this).data('index');
                    $scope.selectedAttributes.push({
                        index: index,
                        name: jQuery(this).data('name'),
                        value: jQuery(this).data('value'),
                    });
                }
            } else {
                jQuery(this).parent().find('.badge').removeClass('active');
                jQuery(this).removeClass('active');
                $scope.selectedAttributes = $scope.selectedAttributes.filter(item => item.index != jQuery(this).data('index'));
            }
            $scope.$apply();
            console.log($scope.selectedAttributes);
        });

        $scope.addToCartFromProductDetail = function() {
            let quantity = $('form input[name="quantity"]').val();
            url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
            url = url.replace('productId', $scope.product.id);

            jQuery.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    'qty': parseInt(quantity),
                    'attributes': $scope.selectedAttributes
                },
                success: function (response) {
                    if (response.success) {
                        if (response.count > 0) {
                            $scope.hasItemInCart = true;
                        }

                        $interval.cancel($rootScope.promise);

                        $rootScope.promise = $interval(function () {
                            cartItemSync.items = response.items;
                            cartItemSync.total = response.total;
                            cartItemSync.count = response.count;
                        }, 1000);
                        toastr.success('Thao tác thành công !')
                    }
                },
                error: function () {
                    toastr.error('Thao tác thất bại !')
                },
                complete: function () {
                    $scope.$applyAsync();
                }
            });
        }

        $scope.addToCartCheckoutFromProductDetail = function() {
            let quantity = $('form input[name="quantity"]').val();
            url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
            url = url.replace('productId', $scope.product.id);

            jQuery.ajax({
                type: 'POST',
                url: url,
                headers: {
                    'X-CSRF-TOKEN': "{{csrf_token()}}"
                },
                data: {
                    'qty': parseInt(quantity),
                    'attributes': $scope.selectedAttributes
                },
                success: function (response) {
                    if (response.success) {
                        if (response.count > 0) {
                            $scope.hasItemInCart = true;
                        }

                        $interval.cancel($rootScope.promise);

                        $rootScope.promise = $interval(function () {
                            cartItemSync.items = response.items;
                            cartItemSync.total = response.total;
                            cartItemSync.count = response.count;
                        }, 1000);
                        toastr.success('Thao tác thành công !')
                        window.location.href = "{{route('cart.index')}}";
                    }
                },
                error: function () {
                    toastr.error('Thao tác thất bại !')
                },
                complete: function () {
                    $scope.$applyAsync();
                }
            });
        }
    });
</script>
@endpush
