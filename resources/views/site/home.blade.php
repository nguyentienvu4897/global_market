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
@endsection
@section('content')
    <div class="container">
        <div class="home-banner row">
            <div class="main-banner col-xxl-8 col-xl-8 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <div class="section_slider swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($banners as $banner)
                        <div class="swiper-slide">
                            <div class="clearfix">
                                <a href="{{ $banner->link }}" title="{{ $banner->name }}">
                                    <picture>
                                        <source media="(min-width: 1200px)"
                                            srcset="{{ $banner->image->path }}">
                                        <source media="(min-width: 992px)"
                                            srcset="{{ $banner->image->path }}">
                                        <source media="(min-width: 569px)"
                                            srcset="{{ $banner->image->path }}">
                                        <source media="(max-width: 480px)"
                                            srcset="{{ $banner->image->path }}">
                                        <img width="1920" height="694"
                                            src="{{ $banner->image->path }}"
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
                    @foreach($smallBanners as $banner)
                    <div class="col-xxl-12 col-xl-12 col-lg-12 col-md-6 col-sm-6 col-xs-12 col-6">
                        <a class="three_banner" href="{{ $banner->link }}" title="{{ $banner->name }}">
                            <img class="lazyload" style="height: 100%;"
                                src="data:image/png;base64,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"
                                data-src="{{$banner->image->path}}"
                                alt="{{$banner->name}}" />
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- <section class="section_2_banner container">
            <div class="row">
                <div class="col-xxl-2 col-xl-1 col-lg-1 col-md-1 col-sm-1 col-xs-1 col-1"></div>
                @foreach($smallBanners as $banner)
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
        <div class="box-deal"
            style="background-image:url({{getBanner($categorySpecialFlashsale)}});">
            <div class="title_deal">
                <a class="title_fl" href="{{route('front.show-product-category', $categorySpecialFlashsale->slug)}}" title="{{ $categorySpecialFlashsale->name }}">
                    {{ $categorySpecialFlashsale->name }}
                </a>
                <div class="count-down">
                    <div class="timer-view" data-countdown="countdown" data-date="{{date('Y-m-d-H-i-s', strtotime($categorySpecialFlashsale->end_date))}}">
                    </div>
                </div>
            </div>
            <div class="box-swi">
                <div class="swi_deal_pro swiper-container">
                    <div class="swiper-wrapper">
                        @foreach($categorySpecialFlashsale->products as $product)
                            <div class="item_product_main swiper-slide">
                                @include('site.products.product_item', ['product' => $product])
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
                <div class="more-pro-deal">
                    <a href="{{route('front.show-product-category', $categorySpecialFlashsale->slug)}}" title="Xem tất cả sản phẩm" class="a-show-more">Xem tất cả sản phẩm <i
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

    {{-- <section class="section_sportswear">
        <div class="container">
            <div class="tabwrap not-dqtab e-tabs ajax-tab-1" data-section="ajax-tab-1">
                <div class="title_index">
                    <h2 class="h2_title">
                        <a class="main-title" href="banh-quy-cookies-crackers" title="Sản phẩm của Dinosnack">Sản
                            phẩm của Dinosnack</a>
                        <span class="icon_title">
                            <img width="134" height="24"
                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_sport.png?1729657650563"
                                alt="Sản phẩm của Dinosnack" />
                        </span>
                    </h2>
                </div>
                <div class="twrap navbar-pills tabs tabs-title tabtitle1 link_tab_check_click closetab ajax clearfix">
                    <div class="tab-link item has-content" data-tab="tab-1" data-url="banh-quy-cookies-crackers">
                        <span>Tất cả</span>
                    </div>
                    <div class="tab-link item " data-tab="tab-2" data-url="banh-quy">
                        <span>Bánh kẹo ngoại nhập</span>
                    </div>
                    <div class="tab-link item " data-tab="tab-3" data-url="banh-trang">
                        <span>Bánh kẹo nội nhập</span>
                    </div>
                    <div class="tab-link item " data-tab="tab-4" data-url="banh-snacks">
                        <span>Cơm cháy - Snack</span>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="uwrap_tab">
                    <div class="tab-content tab-1">
                        <div class="row">
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31513350" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover" href="/banh-nhan-kem-chanh-vicenzi-150g"
                                            title="B&#225;nh Nh&#226;n Kem Chanh Vicenzi 150G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/kem-chanh-vicenzi-513b4cb421ee4d.jpg?v=1687538700893"
                                                alt="B&#225;nh Nh&#226;n Kem Chanh Vicenzi 150G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh" href="/banh-nhan-kem-chanh-vicenzi-150g"
                                                data-handle="banh-nhan-kem-chanh-vicenzi-150g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380765" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <div class="sale-label"><span class="smart">- 17% </span></div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-nhan-kem-chanh-vicenzi-150g" tabindex="0"
                                            title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a href="/banh-nhan-kem-chanh-vicenzi-150g"
                                                title="B&#225;nh Nh&#226;n Kem Chanh Vicenzi 150G">B&#225;nh
                                                Nh&#226;n Kem Chanh Vicenzi 150G</a></h3>
                                        <div class="price-box">
                                            <span class="price">89.900₫</span>
                                            <span class="compare-price">108.000₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31513333" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover"
                                            href="/banh-nhieu-lop-minisnack-cuon-kem-hat-phi-m-dialia-125g"
                                            title="B&#225;nh Nhiều Lớp Minisnack Cuộn Kem Hạt Phỉ M.Dialia 125G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/minisnack-puff-pastry-rolls-fill.jpg?v=1687538633963"
                                                alt="B&#225;nh Nhiều Lớp Minisnack Cuộn Kem Hạt Phỉ M.Dialia 125G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh"
                                                href="/banh-nhieu-lop-minisnack-cuon-kem-hat-phi-m-dialia-125g"
                                                data-handle="banh-nhieu-lop-minisnack-cuon-kem-hat-phi-m-dialia-125g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380725" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <div class="sale-label"><span class="smart">- 13% </span></div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-nhieu-lop-minisnack-cuon-kem-hat-phi-m-dialia-125g"
                                            tabindex="0" title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a
                                                href="/banh-nhieu-lop-minisnack-cuon-kem-hat-phi-m-dialia-125g"
                                                title="B&#225;nh Nhiều Lớp Minisnack Cuộn Kem Hạt Phỉ M.Dialia 125G">B&#225;nh
                                                Nhiều Lớp Minisnack Cuộn Kem Hạt Phỉ M.Dialia 125G</a></h3>
                                        <div class="price-box">
                                            <span class="price">79.900₫</span>
                                            <span class="compare-price">92.000₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31513326" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover"
                                            href="/banh-nhieu-lop-bocconcini-nhan-kem-sua-m-dialia-125g"
                                            title="B&#225;nh Nhiều Lớp Bocconcini Nh&#226;n Kem Sữa M.Dialia 125G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/bocconcini-puff-pastry-filled-wi.jpg?v=1687538573550"
                                                alt="B&#225;nh Nhiều Lớp Bocconcini Nh&#226;n Kem Sữa M.Dialia 125G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh"
                                                href="/banh-nhieu-lop-bocconcini-nhan-kem-sua-m-dialia-125g"
                                                data-handle="banh-nhieu-lop-bocconcini-nhan-kem-sua-m-dialia-125g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380718" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-nhieu-lop-bocconcini-nhan-kem-sua-m-dialia-125g"
                                            tabindex="0" title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a
                                                href="/banh-nhieu-lop-bocconcini-nhan-kem-sua-m-dialia-125g"
                                                title="B&#225;nh Nhiều Lớp Bocconcini Nh&#226;n Kem Sữa M.Dialia 125G">B&#225;nh
                                                Nhiều Lớp Bocconcini Nh&#226;n Kem Sữa M.Dialia 125G</a></h3>
                                        <div class="price-box">
                                            <span class="price">89.900₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31513318" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover" href="/banh-xop-vi-bo-dau-phong-loacker-125g"
                                            title="B&#225;nh Xốp Vị Bơ Đậu Phộng Loacker 125G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/290015751000-banh-xop-vi-bo-da.jpg?v=1687538521407"
                                                alt="B&#225;nh Xốp Vị Bơ Đậu Phộng Loacker 125G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh" href="/banh-xop-vi-bo-dau-phong-loacker-125g"
                                                data-handle="banh-xop-vi-bo-dau-phong-loacker-125g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380710" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-xop-vi-bo-dau-phong-loacker-125g" tabindex="0"
                                            title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a href="/banh-xop-vi-bo-dau-phong-loacker-125g"
                                                title="B&#225;nh Xốp Vị Bơ Đậu Phộng Loacker 125G">B&#225;nh Xốp Vị
                                                Bơ Đậu Phộng Loacker 125G</a></h3>
                                        <div class="price-box">
                                            <span class="price">59.900₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31513310" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover" href="/banh-ran-tong-hop-tenkei-175g"
                                            title="B&#225;nh R&#225;n Tổng Hợp Tenkei 175G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/290016742000-banh-ran-tong-hop-t.jpg?v=1687538449943"
                                                alt="B&#225;nh R&#225;n Tổng Hợp Tenkei 175G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh" href="/banh-ran-tong-hop-tenkei-175g"
                                                data-handle="banh-ran-tong-hop-tenkei-175g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380684" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-ran-tong-hop-tenkei-175g" tabindex="0"
                                            title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a href="/banh-ran-tong-hop-tenkei-175g"
                                                title="B&#225;nh R&#225;n Tổng Hợp Tenkei 175G">B&#225;nh R&#225;n
                                                Tổng Hợp Tenkei 175G</a></h3>
                                        <div class="price-box">
                                            <span class="price">128.900₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31513305" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover"
                                            href="/banh-bong-lan-phap-truyen-thong-mini-madeleines-st-michel-85g"
                                            title="B&#225;nh B&#244;ng Lan Ph&#225;p Truyền Th&#244;ng Mini Madeleines St Michel 85G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/st-85-20f10c5796e147c094e3ea3b2f.jpg?v=1687538352420"
                                                alt="B&#225;nh B&#244;ng Lan Ph&#225;p Truyền Th&#244;ng Mini Madeleines St Michel 85G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh"
                                                href="/banh-bong-lan-phap-truyen-thong-mini-madeleines-st-michel-85g"
                                                data-handle="banh-bong-lan-phap-truyen-thong-mini-madeleines-st-michel-85g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380668" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-bong-lan-phap-truyen-thong-mini-madeleines-st-michel-85g"
                                            tabindex="0" title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a
                                                href="/banh-bong-lan-phap-truyen-thong-mini-madeleines-st-michel-85g"
                                                title="B&#225;nh B&#244;ng Lan Ph&#225;p Truyền Th&#244;ng Mini Madeleines St Michel 85G">B&#225;nh
                                                B&#244;ng Lan Ph&#225;p Truyền Th&#244;ng Mini Madeleines St Michel
                                                85G</a></h3>
                                        <div class="price-box">
                                            <span class="price">36.900₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31512944" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover"
                                            href="/banh-gao-vi-dua-huu-co-le-pain-des-fleurs-150g"
                                            title="B&#225;nh Gạo Vị Dừa Hữu Cơ Le Pain Des Fleurs 150G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/banh-gao-dua-388caf0570cd4a04a49.jpg?v=1687538272580"
                                                alt="B&#225;nh Gạo Vị Dừa Hữu Cơ Le Pain Des Fleurs 150G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh" href="/banh-gao-vi-dua-huu-co-le-pain-des-fleurs-150g"
                                                data-handle="banh-gao-vi-dua-huu-co-le-pain-des-fleurs-150g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380110" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <div class="sale-label"><span class="smart">- 8% </span></div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-gao-vi-dua-huu-co-le-pain-des-fleurs-150g" tabindex="0"
                                            title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a href="/banh-gao-vi-dua-huu-co-le-pain-des-fleurs-150g"
                                                title="B&#225;nh Gạo Vị Dừa Hữu Cơ Le Pain Des Fleurs 150G">B&#225;nh
                                                Gạo Vị Dừa Hữu Cơ Le Pain Des Fleurs 150G</a></h3>
                                        <div class="price-box">
                                            <span class="price">178.500₫</span>
                                            <span class="compare-price">194.500₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31512941" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover"
                                            href="/banh-cookies-phuc-bon-tu-huu-co-biona-175g"
                                            title="B&#225;nh Cookies Ph&#250;c Bồn Tử Hữu Cơ Biona 175G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/organic-raspberry-waffles-biona.jpg?v=1687538195057"
                                                alt="B&#225;nh Cookies Ph&#250;c Bồn Tử Hữu Cơ Biona 175G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh" href="/banh-cookies-phuc-bon-tu-huu-co-biona-175g"
                                                data-handle="banh-cookies-phuc-bon-tu-huu-co-biona-175g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380107" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <div class="sale-label"><span class="smart">- 10% </span></div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-cookies-phuc-bon-tu-huu-co-biona-175g" tabindex="0"
                                            title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a href="/banh-cookies-phuc-bon-tu-huu-co-biona-175g"
                                                title="B&#225;nh Cookies Ph&#250;c Bồn Tử Hữu Cơ Biona 175G">B&#225;nh
                                                Cookies Ph&#250;c Bồn Tử Hữu Cơ Biona 175G</a></h3>
                                        <div class="price-box">
                                            <span class="price">180.000₫</span>
                                            <span class="compare-price">200.000₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31512940" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover" href="/banh-cracker-xop-cu-cai-do-orgran-100g"
                                            title="B&#225;nh Cracker Xốp Củ Cải Đỏ Orgran 100G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/290011071000-beetroot-wafer-crac.jpg?v=1687538074383"
                                                alt="B&#225;nh Cracker Xốp Củ Cải Đỏ Orgran 100G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh" href="/banh-cracker-xop-cu-cai-do-orgran-100g"
                                                data-handle="banh-cracker-xop-cu-cai-do-orgran-100g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380106" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <div class="sale-label"><span class="smart">- 18% </span></div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-cracker-xop-cu-cai-do-orgran-100g" tabindex="0"
                                            title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a href="/banh-cracker-xop-cu-cai-do-orgran-100g"
                                                title="B&#225;nh Cracker Xốp Củ Cải Đỏ Orgran 100G">B&#225;nh
                                                Cracker Xốp Củ Cải Đỏ Orgran 100G</a></h3>
                                        <div class="price-box">
                                            <span class="price">118.500₫</span>
                                            <span class="compare-price">145.000₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-15 col-md-3">
                                <div class="item_product_main">
                                    <form action="/cart/add" method="post" class="variants product-action"
                                        data-id="product-actions-31512938" enctype="multipart/form-data">
                                        <a class="image_thumb scale_hover"
                                            href="/banh-quy-bo-3-loai-truyen-thong-jules-destrooper-300g"
                                            title="B&#225;nh Quy Bơ 3 Loại Truyền Thống Jules Destrooper 300G">
                                            <img width="480" height="480" class="lazyload image1"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="//bizweb.dktcdn.net/thumb/large/100/489/005/products/290014076000-1-b9a22b56249344389.jpg?v=1687537959007"
                                                alt="B&#225;nh Quy Bơ 3 Loại Truyền Thống Jules Destrooper 300G">
                                        </a>
                                        <div class="group_action">
                                            <a title="Xem nhanh"
                                                href="/banh-quy-bo-3-loai-truyen-thong-jules-destrooper-300g"
                                                data-handle="banh-quy-bo-3-loai-truyen-thong-jules-destrooper-300g"
                                                class="btn-anima hidden-xs xem_nhanh btn-circle btn-views btn_view btn right-to quick-view">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/view.svg?1729657650563"
                                                    alt="Xem nhanh" /> Xem nhanh
                                            </a><input type="hidden" name="variantId" value="91380104" />
                                            <button
                                                class="btn-anima hidden-xs btn-buy btn-cart btn-left btn btn-views left-to add_to_cart active "
                                                title="Mua ngay">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/cart_new.svg?1729657650563"
                                                    alt="Mua ngay" /> Mua ngay
                                            </button>
                                        </div>
                                        <div class="sale-label"><span class="smart">- 14% </span></div>
                                        <a href="javascript:void(0)" class="setWishlist"
                                            data-wish="banh-quy-bo-3-loai-truyen-thong-jules-destrooper-300g"
                                            tabindex="0" title="Thêm vào yêu thích">
                                            <img width="24" height="24"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/heart.png?1729657650563"
                                                alt="Thêm vào yêu thích" />
                                        </a>
                                    </form>
                                    <div class="product-info">
                                        <h3 class="product-name"><a
                                                href="/banh-quy-bo-3-loai-truyen-thong-jules-destrooper-300g"
                                                title="B&#225;nh Quy Bơ 3 Loại Truyền Thống Jules Destrooper 300G">B&#225;nh
                                                Quy Bơ 3 Loại Truyền Thống Jules Destrooper 300G</a></h3>
                                        <div class="price-box">
                                            <span class="price">518.900₫</span>
                                            <span class="compare-price">600.000₫</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="more-pro-deal">
                            <a href="banh-quy-cookies-crackers" title="Xem tất cả sản phẩm" class="a-show-more">Xem
                                tất cả sản phẩm <i class="icon_more"></i></a>
                        </div>
                    </div>
                    <div class="tab-content tab-2">
                    </div>
                    <div class="tab-content tab-3">
                    </div>
                    <div class="tab-content tab-4">
                    </div>
                </div>
            </div>
        </div>
    </section> --}}
    {{-- <section class="section_danhgia">
        <div class="thump-image">
            <div class="bacground"
                style="background-image: url(//bizweb.dktcdn.net/100/489/005/themes/912542/assets/background_danhgia.jpg?1729657650563)">
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                    <h2 class="title-module">
                        <span>Đánh giá của khách hàng</span>
                        <img width="30" height="22"
                            src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_quo.png?1729657650563"
                            alt="Đánh giá của khách hàng" />
                    </h2>
                </div>
                <div class="thump-danhgia col-11 col-sm-10 col-lg-10 col-xl-10 col-cus-8">
                    <div class="danhgia-slider swiper-container">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <div class="avatar">
                                    <img width="80" height="80" alt="Chị Ngọc Dung " class="lazyload loaded"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                        data-src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/danhgia_1.jpg?1729657650563">
                                </div>
                                <div class="content">
                                    <p>Bánh rất ngon, hương vị đậm đà mà không bị ngấy, nhân viên thì phục vụ rất
                                        vui vẻ, tận tình nhất là món bánh tráng trộn sốt me rất ngon mà giá cả phù
                                        hợp. Dino giá cả phải chăng.</p>
                                </div>
                                <div class="testimonial">
                                    <h5>Chị Ngọc Dung </h5>
                                    <span>Khách hàng</span>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="avatar">
                                    <img width="80" height="80" alt="Chị Huỳnh Liêm " class="lazyload loaded"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                        data-src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/danhgia_2.jpg?1729657650563">
                                </div>
                                <div class="content">
                                    <p>Bánh rất ngon, hương vị đậm đà mà không bị ngấy, nhân viên thì phục vụ rất
                                        vui vẻ, tận tình nhất là món bánh tráng trộn sốt me rất ngon mà giá cả phù
                                        hợp. Dino giá cả phải chăng.</p>
                                </div>
                                <div class="testimonial">
                                    <h5>Chị Huỳnh Liêm </h5>
                                    <span>Khách hàng</span>
                                </div>
                            </div>
                            <div class="swiper-slide">
                                <div class="avatar">
                                    <img width="80" height="80" alt="Chị Sở Bình" class="lazyload loaded"
                                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                        data-src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/danhgia_3.jpg?1729657650563">
                                </div>
                                <div class="content">
                                    <p>Bánh rất ngon, hương vị đậm đà mà không bị ngấy, nhân viên thì phục vụ rất
                                        vui vẻ, tận tình nhất là món bánh tráng trộn sốt me rất ngon mà giá cả phù
                                        hợp. Dino giá cả phải chăng.</p>
                                </div>
                                <div class="testimonial">
                                    <h5>Chị Sở Bình</h5>
                                    <span>Khách hàng</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>
    </section>
    <script>
        var swiperdg = new Swiper('.danhgia-slider', {
            loop: false,
            autoplay: false,
            spaceBetween: 15,
            navigation: {
                nextEl: '.thump-danhgia .swiper-button-next',
                prevEl: '.thump-danhgia .swiper-button-prev',
            },
            breakpoints: {
                280: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                640: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                768: {
                    slidesPerView: 1,
                    spaceBetween: 15,
                },
                992: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                1024: {
                    slidesPerView: 3,
                    spaceBetween: 15
                },
                1199: {
                    slidesPerView: 3,
                    spaceBetween: 15
                }
            }
        });
    </script> --}}

    @foreach($categorySpecial as $category)
    @if($category->image)
    <section class="section_banner">
        <a class="a-banner" href="{{route('front.show-product-category', $category->slug)}}" title="Banner">
            <img width="100%" height="164" class="lazyload"
                src="data:image/png;base64,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"
                data-src="{{ $category->image ? $category->image->path : '' }}"
                alt="Banner" />
        </a>
    </section>
    @endif
    <section class="section_combo_product container">
        <div class="title_index">
            <h2 class="h2_title">
                <a class="main-title" href="{{route('front.show-product-category', $category->slug)}}" title="{{$category->name}}">{{$category->name}}</a>
                <span class="icon_title">
                    <img width="134" height="24"
                        src="/site/images/icon_combo_product.png?1729657650563"
                        alt="" />
                </span>
            </h2>
        </div>
        <div class="row">
            @foreach($category->products as $product)
            <div class="col-lg-15 col-md-3">
                <div class="item_product_main">
                    @include('site.products.product_item', ['product' => $product])
                </div>
            </div>
            @endforeach
        </div>
        <div class="more-pro-deal">
            <a href="{{route('front.show-product-category', $category->slug)}}" title="Xem tất cả sản phẩm" class="a-show-more">Xem tất cả sản phẩm <i
                    class="icon_more"></i></a>
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
                            <a class="main-title" href="javascript:void(0);" title="{{$category->name}}">{{$category->name}}</a>
                            <span class="icon_title">
                                <img width="134" height="24"
                                    src="/site/images/icon_combo_product.png?1729657650563"
                                    alt="{{$category->name}}" />
                            </span>
                        </h2>
                    </div>
                    <div class="block-blog">
                        <div class="blog-swiper swiper-container">
                            <div class="swiper-wrapper">
                                @foreach($category->posts as $post)
                                <div class="swiper-slide">
                                    <div class="item-blog">
                                        <a class="pos_a_blog"
                                            href="{{route('front.detail-blog', $post->slug)}}"
                                            title="{{$post->name}}">
                                            {{$post->name}}
                                        </a>
                                        <div class="block-thumb">
                                            <img width="600" height="380"
                                                src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                                                data-src="{{$post->image ? $post->image->path : ''}}"
                                                alt="{{$post->name}}"
                                                class="lazyload img-responsive" />
                                        </div>
                                        <div class="block-content">
                                            <h3>
                                                <a class="line-clamp-2"
                                                    href="{{route('front.detail-blog', $post->slug)}}"
                                                    title="{{$post->name}}">
                                                    {{$post->name}}
                                                </a>
                                            </h3>
                                            <p class="update_date clearfix">
                                                <span class="user_name">Admin</span>
                                                <span class="user_date"> {{date('d/m/Y', strtotime($post->created_at))}}</span>
                                            </p>
                                            <div class="box-blog-hid">
                                                <p class="line-clamp-3">
                                                    {{$post->intro}}
                                                </p>
                                                <a class="viewmore"
                                                    href="{{route('front.detail-blog', $post->slug)}}"
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
    <div id="js-global-alert" class="alert alert-success" role="alert">
        <button type="button" class="close"><span aria-hidden="true"><span
                    aria-hidden="true">&times;</span></span></button>
        <h5 class="alert-heading"></h5>
        <p class="alert-content"></p>
    </div>
@endsection
@push('script')
@endpush
