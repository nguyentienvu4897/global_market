@extends('site.layouts.master')
@section('title')
    {{ $category->meta_title ? $category->meta_title : $category->name }}
@endsection
@section('description')
    {{ $category->meta_des ? $category->meta_des : $category->short_des }}
@endsection
@section('css')
<link href="/site/css/sidebar_style.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
<link href="/site/css/collection_style.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
<link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
    <div>
        <div class="layout-collection">
            <section class="bread-crumb"
                style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
                <div class="container">
                    <div class="title-bread-crumb"> Sản phẩm
                    </div>
                    <ul class="breadcrumb">
                        <li class="home">
                            <a href="{{route('front.home-page')}}"><span>Trang chủ</span></a>
                            <span class="mr_lr">/</span>
                        </li>
                        <li><strong><span> {{$category->name}}</span></strong></li>
                    </ul>
                </div>
            </section>
            <div class="container">
                <div class="row">
                    <div class="block-collection col-xl-12 col-lg-12 col-12">
                        <div class="section-box-bg">
                            <h1 class="title-page d-md-block">{{$category->name}}</h1>
                            <div class="evo-sidebar-collection">
                                <div class="evo-sort-category">
                                    <div id="sort-by">
                                        <label class="left"><img width="16" height="16" alt="Sắp xếp"
                                                src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/sort.png?1729657650563" />Sắp
                                            xếp: </label>
                                        <ul id="sortBy">
                                            <li>
                                                <span>Mặc định</span>
                                                <ul>
                                                    <li><a href="javascript:;" onclick="sortby('default')"
                                                            title="Mặc định">Mặc định</a></li>
                                                    <li><a href="javascript:;" onclick="sortby('alpha-asc')"
                                                            title="A &rarr; Z">A &rarr; Z</a></li>
                                                    <li><a href="javascript:;" onclick="sortby('alpha-desc')"
                                                            title="Z &rarr; A">Z &rarr; A</a></li>
                                                    <li><a href="javascript:;" onclick="sortby('price-asc')"
                                                            title="Giá tăng dần">Giá tăng dần</a></li>
                                                    <li><a href="javascript:;" onclick="sortby('price-desc')"
                                                            title="Giá giảm dần">Giá giảm dần</a></li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="category-products">
                                <div class="products-view products-view-grid list_hover_pro">
                                    <div class="row">
                                        @foreach ($products as $product)
                                            <div class="col-6 col-xs-6 col-sm-6 col-md-4 col-lg-3 col-xl-3 col-xl-15">
                                                <div class="item_product_main">
                                                    @include('site.products.product_item', compact('product'))
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="pagenav">
                                    {{ $products->links() }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="opacity_sidebar"></div>
        <script>

            // var colId = 3176597;

            // var selectedViewData = "data";
            // $('.add_to_cart').click(function(e) {
            //     e.preventDefault();
            //     var $this = $(this);
            //     var form = $this.parents('form');
            //     $.ajax({
            //         type: 'POST',
            //         url: '/cart/add.js',
            //         async: false,
            //         data: form.serialize(),
            //         dataType: 'json',
            //         beforeSend: function() {},
            //         success: function(line_item) {
            //             ajaxCart.load();
            //             $('.popup-cart-mobile, .backdrop__body-backdrop___1rvky').addClass('active');
            //             AddCartMobile(line_item);
            //         },
            //         cache: false
            //     });
            // });
            $('.bolocs').click(function(e) {
                e.stopPropagation();
                $('.aside-filter').slideToggle();
            });

            $('.aside-filter').click(function(e) {
                e.stopPropagation();
            });
        </script>
        <div id="js-global-alert" class="alert alert-success" role="alert">
            <button type="button" class="close"><span aria-hidden="true"><span
                        aria-hidden="true">&times;</span></span></button>
            <h5 class="alert-heading"></h5>
            <p class="alert-content"></p>
        </div>
    </div>
@endsection

@push('script')
@endpush
