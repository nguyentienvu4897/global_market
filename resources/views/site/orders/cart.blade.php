@extends('site.layouts.master')
@section('title')
    Giỏ hàng
@endsection

@section('css')
    <link href="{{ asset('site/css/breadcrumb_style.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
    <link href="{{ asset('site/css/cartpage.scss.css') }}" rel="stylesheet" type="text/css" media="all" />
@endsection

@section('content')
    <div ng-controller="CartController" ng-cloak>
        <section class="bread-crumb"
            style="background: linear-gradient(0deg, rgba(0,0,0,0), rgba(0,0,0,0)),  url(/site/images/bg_footer.jpg?1721988795194) center no-repeat;">
            <div class="container">
                <div class="title-bread-crumb"> Giỏ hàng
                </div>
                <ul class="breadcrumb">
                    <li class="home">
                        <a href="{{ route('front.home-page') }}"><span>Trang chủ</span></a>
                        <span class="mr_lr">/</span>
                    </li>
                    <li><strong><span>Giỏ hàng</span></strong></li>
                </ul>
            </div>
        </section>
        <section class="main-cart-page main-container col1-layout">
            <div class="main container cartpcstyle">
                <div class="wrap_background_aside margin-bottom-40">
                    <div class="header-cart">
                        <div class="title-block-page">
                            <h1 class="title_cart">
                                <span>Giỏ hàng của bạn</span>
                            </h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12 col-lg-12 col-12 col-cart-left col-xs-12 col-12">
                            <div class="clearfix"></div>
                            <div class="cart-page d-xl-block d-none">
                                <div class="drawer__inner">
                                    <div class="CartPageContainer" style="font-size: 16px;">
                                        <form class="cart ajaxcart cartpage">
                                            <div class="cart-header-info">
                                                <div>Thông tin sản phẩm</div>
                                                <div>Đơn giá</div>
                                                <div>Số lượng</div>
                                                <div>Thành tiền</div>
                                            </div>
                                            <div class="ajaxcart__inner ajaxcart__inner--has-fixed-footer cart_body items">
                                                <div class="ajaxcart__row" ng-repeat="item in items">
                                                    <div class="ajaxcart__product cart_product" data-line="1">
                                                        <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-image cart_image" title="<%item.name%>">
                                                            <img ng-src="<%item.attributes.image%>" alt="<%item.name%>">
                                                        </a>
                                                        <div class="grid__item cart_info">
                                                        <div class="ajaxcart__product-name-wrapper cart_name">
                                                            <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-name h4" title="<%item.name%>"><%item.name%></a>
                                                            <a title="Xóa" class="cart__btn-remove remove-item-cart ajaxifyCart--remove" href="javascript:;" data-line="1" ng-click="removeItem(item.id)">Xóa</a>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half text-right cart_prices">
                                                                <span class="cart-price"><% item.attributes.price | number %>₫</span>
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half cart_select">
                                                                <div class="ajaxcart__qty input-group-btn">
                                                                    <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count" data-id="" data-qty="0" data-line="1" aria-label="-" ng-click="decrementQuantity(item); changeQty(item.quantity, item.id)">
                                                                    -
                                                                    </button>
                                                                    <input type="text" name="updates[]" class="ajaxcart__qty-num number-sidebar" maxlength="3" ng-model="item.quantity" value="<%item.quantity%>" min="0" data-id="" data-line="1" aria-label="quantity" pattern="[0-9]*" ng-change="changeQty(item.quantity, item.id)">
                                                                    <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count" data-id="" data-line="1" data-qty="2" aria-label="+" ng-click="incrementQuantity(item); changeQty(item.quantity, item.id)">
                                                                    +
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="grid">
                                                            <div class="grid__item one-half text-right cart_prices">
                                                                <span class="cart-price"><% item.price * item.quantity | number %>₫</span>
                                                            </div>
                                                        </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ajaxcart__footer ajaxcart__footer--fixed cart-footer">
                                                <div class="row">
                                                    <div class="col-lg-8 col-12">
                                                        <a class="btn-proceed-checkout btn-checkouts" title="Tiếp tục mua hàng" href="{{ route('front.home-page') }}">Tiếp tục mua hàng</a>
                                                    </div>
                                                    <div class="col-lg-4 col-12">
                                                        <div class="ajaxcart__subtotal">
                                                        <div class="cart__subtotal">
                                                            <div class="cart__col-6">Tổng tiền:</div>
                                                            <div class="text-right cart__totle"><span class="total-price"><% total | number %>₫</span></div>
                                                        </div>
                                                        </div>
                                                        <div class="cart__btn-proceed-checkout-dt">
                                                        <button onclick="window.location.href = '{{ route('cart.checkout') }}'" type="button" class="button btn btn-default cart__btn-proceed-checkout" id="btn-proceed-checkout" title="Thanh toán">Thanh toán</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="cart-mobile-page d-block d-xl-none">
                                <div class="CartMobileContainer">
                                    <form class="cart ajaxcart cart-mobile">
                                        <div class="ajaxcart__inner ajaxcart__inner--has-fixed-footer cart_body">
                                            <div class="ajaxcart__row" ng-repeat="item in items">
                                                <div class="ajaxcart__product cart_product" data-line="1">
                                                    <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-image cart_image" title="<%item.name%>">
                                                        <img ng-src="<%item.attributes.image%>" alt="<%item.name%>">
                                                    </a>
                                                    <div class="grid__item cart_info">
                                                    <div class="ajaxcart__product-name-wrapper cart_name">
                                                        <a href="/san-pham/<%item.attributes.slug%>.html" class="ajaxcart__product-name h4" title="<%item.name%>"><%item.name%></a>
                                                    </div>
                                                    <div class="grid">
                                                        <div class="grid__item one-half cart_select cart_item_name">
                                                            <div class="ajaxcart__qty input-group-btn">
                                                                <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count" data-id="" data-qty="0" data-line="1" aria-label="-">
                                                                -
                                                                </button>
                                                                <input type="text" name="updates[]" class="ajaxcart__qty-num number-sidebar" maxlength="3" value="1" min="0" data-id="" data-line="1" aria-label="quantity" pattern="[0-9]*">
                                                                <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count" data-id="" data-line="1" data-qty="2" aria-label="+">
                                                                +
                                                                </button>
                                                            </div>
                                                        </div>
                                                        <div class="grid__item one-half text-right cart_prices">
                                                            <span class="cart-price"><% item.price * item.quantity | number %>₫</span>
                                                            <a title="Xóa" class="cart__btn-remove remove-item-cart ajaxifyCart--remove" href="javascript:;" data-line="1" ng-click="removeItem(item)">Xóa</a>
                                                        </div>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ajaxcart__footer ajaxcart__footer--fixed cart-footer">
                                            <div class="ajaxcart__subtotal">
                                                <div class="cart__subtotal">
                                                    <div class="cart__col-6">Tổng tiền:</div>
                                                    <div class="text-right cart__totle"><span class="total-price"><% total | number %>₫</span></div>
                                                </div>
                                            </div>
                                            <div class="cart_btn_continue">
                                                <a class="btn-proceed-checkout btn-checkouts" title="Tiếp tục mua hàng" href="collections/all">Tiếp tục mua hàng</a>
                                            </div>
                                            <div class="cart__btn-proceed-checkout-dt">
                                                <button onclick="window.location.href = '{{ route('cart.checkout') }}'" type="button" class="button btn btn-default cart__btn-proceed-checkout" id="btn-proceed-checkout" title="Thanh toán">Thanh toán</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="col-xl-3 col-lg-4 col-12 col-sm-12 col-xs-12 col-12 col-cart-right">
                            <form method="post" novalidate="" class="formVAT">
                                <h4>
                                    Thời gian giao hàng
                                </h4>
                                <div class="timedeli-modal">
                                    <fieldset class="input_group date_pick">
                                        <input type="text" placeholder="Chọn ngày" readonly="" id="date" name="attributes[shipdate]" class="date_picker" required="">
                                    </fieldset>
                                    <fieldset class="input_group date_time">
                                        <select name="time" class="timeer timedeli-cta">
                                        <option selected="">Chọn giờ</option>
                                        <option value="08h00 - 12h00">08h00 - 12h00</option>
                                        <option value="14h00 - 18h00">14h00 - 18h00</option>
                                        <option value="19h00 - 21h00">19h00 - 21h00</option>
                                        </select>
                                    </fieldset>
                                </div>
                                <div class="r-bill">
                                    <div class="checkbox">
                                        <input type="hidden" name="attributes[invoice]" id="re-checkbox-bill" value="không">
                                        <input type="checkbox" id="checkbox-bill" name="attributes[invoice]" value="có" class="regular-checkbox">
                                        <label for="checkbox-bill" class="box"></label>
                                        <label for="checkbox-bill" class="title">Xuất hóa đơn công ty</label>
                                    </div>
                                    <div class="bill-field">
                                        <div class="form-group">
                                        <label>Tên công ty</label>
                                        <input type="text" class="form-control val-f" name="attributes[company_name]" value="" placeholder="Tên công ty">
                                        </div>
                                        <div class="form-group">
                                        <label>Mã số thuế</label>
                                        <input type="number" pattern=".{10,}" class="form-control val-f val-n" name="attributes[tax_code]" value="" placeholder="Mã số thuế">
                                        </div>
                                        <div class="form-group">
                                        <label>Địa chỉ công ty</label>
                                        <textarea type="text" class="form-control val-f" name="attributes[company_address]" placeholder="Nhập địa chỉ công ty (bao gồm Phường/Xã, Quận/Huyện, Tỉnh/Thành phố nếu có)"></textarea>
                                        </div>
                                        <div class="form-group">
                                        <label>Email nhận hoá đơn</label>
                                        <input type="email" class="form-control val-f val-email" name="attributes[invoice_email]" value="" placeholder="Email nhận hoá đơn">
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="clearfix"></div>
                            <div class="product-coupon__wrapper my-3">
                                <div class="coupon-toggle">
                                    <img class="mr-1" src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/coupon-icon.png?1729657650563" alt="Mã khuyến mãi">
                                    <span>Mã khuyến mãi</span>
                                </div>
                                <div class="product-coupons coupon-toggle-btn">
                                    Xem chi tiết
                                    <svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-right fa-w-10">
                                        <path fill="currentColor" d="M285.476 272.971L91.132 467.314c-9.373 9.373-24.569 9.373-33.941 0l-22.667-22.667c-9.357-9.357-9.375-24.522-.04-33.901L188.505 256 34.484 101.255c-9.335-9.379-9.317-24.544.04-33.901l22.667-22.667c9.373-9.373 24.569-9.373 33.941 0L285.475 239.03c9.373 9.372 9.373 24.568.001 33.941z" class=""></path>
                                    </svg>
                                </div>
                            </div>
                            <div id="modal-coupon-product" class="modalcoupon-product" style="display:none;">
                                <div class="modalcoupon-overlay fancybox-overlay fancybox-overlay-fixed"></div>
                                <div class="modal-coupon-product">
                                    <div class="row">
                                        <div class="col-md-12 col-12">
                                        <div class="chosee_size">
                                            <p class="title-size">Mã khuyến mãi</p>
                                        </div>
                                        <div class="box-cpou-dk ">
                                            <div class="item_list_coupon">
                                                <div class="money_coupon">
                                                    10%
                                                </div>
                                                <div class="content_coupon">
                                                    <div class="boz-left">
                                                    <div class="zip_coupon">
                                                        Mã khuyến mãi <b>DINOS10</b>
                                                    </div>
                                                    <div class="noidung_coupon">
                                                        Mã giảm 10% cho đơn hàng tối thiểu 500k.
                                                    </div>
                                                    </div>
                                                    <div class="boz-right">
                                                    <button class="btn dis_copy" data-copy="DINOS10">
                                                    <span>Sao chép mã</span>
                                                    </button>
                                                    <div class="dk_btn dk_btn_1">
                                                        <span>Điều kiện</span>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="contet_dk contet_dk_1">
                                                Áp dụng cho đơn hàng từ 500k trở lên. Không đi kèm với chương trình khác
                                            </div>
                                        </div>
                                        <div class="box-cpou-dk ">
                                            <div class="item_list_coupon">
                                                <div class="money_coupon">
                                                    15%
                                                </div>
                                                <div class="content_coupon">
                                                    <div class="boz-left">
                                                    <div class="zip_coupon">
                                                        Mã khuyến mãi <b>DINOS15</b>
                                                    </div>
                                                    <div class="noidung_coupon">
                                                        Mã giảm 15% cho đơn hàng tối thiểu 800k.
                                                    </div>
                                                    </div>
                                                    <div class="boz-right">
                                                    <button class="btn dis_copy" data-copy="DINOS15">
                                                    <span>Sao chép mã</span>
                                                    </button>
                                                    <div class="dk_btn dk_btn_2">
                                                        <span>Điều kiện</span>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="contet_dk contet_dk_2">
                                                Áp dụng cho đơn hàng từ 800k trở lên<br>
                                                Không đi kèm với chương trình khác
                                            </div>
                                        </div>
                                        <div class="box-cpou-dk ">
                                            <div class="item_list_coupon">
                                                <div class="money_coupon">
                                                    20%
                                                </div>
                                                <div class="content_coupon">
                                                    <div class="boz-left">
                                                    <div class="zip_coupon">
                                                        Mã khuyến mãi <b>DINOS20</b>
                                                    </div>
                                                    <div class="noidung_coupon">
                                                        Mã giảm 20% cho đơn hàng tối thiểu 1000k.
                                                    </div>
                                                    </div>
                                                    <div class="boz-right">
                                                    <button class="btn dis_copy" data-copy="DINOS20">
                                                    <span>Sao chép mã</span>
                                                    </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="box-cpou-dk last-cpou">
                                            <div class="item_list_coupon">
                                                <div class="money_coupon">
                                                    0K
                                                </div>
                                                <div class="content_coupon">
                                                    <div class="boz-left">
                                                    <div class="zip_coupon">
                                                        Mã khuyến mãi <b>FREESHIP</b>
                                                    </div>
                                                    <div class="noidung_coupon">
                                                        Miễn phí vận chuyển cho đơn hàng trên 300k.
                                                    </div>
                                                    </div>
                                                    <div class="boz-right">
                                                    <button class="btn dis_copy" data-copy="FREESHIP">
                                                    <span>Sao chép mã</span>
                                                    </button>
                                                    <div class="dk_btn dk_btn_4">
                                                        <span>Điều kiện</span>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="contet_dk contet_dk_4">
                                                Áp dụng cho đơn hàng từ 300k trở lên
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <a title="Close" class="modalcoupon-close close-window" href="javascript:;">
                                        <svg aria-hidden="true" focusable="false" data-prefix="far" data-icon="times" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-times fa-w-10">
                                        <path fill="currentColor" d="M207.6 256l107.72-107.72c6.23-6.23 6.23-16.34 0-22.58l-25.03-25.03c-6.23-6.23-16.34-6.23-22.58 0L160 208.4 52.28 100.68c-6.23-6.23-16.34-6.23-22.58 0L4.68 125.7c-6.23 6.23-6.23 16.34 0 22.58L112.4 256 4.68 363.72c-6.23 6.23-6.23 16.34 0 22.58l25.03 25.03c6.23 6.23 16.34 6.23 22.58 0L160 303.6l107.72 107.72c6.23 6.23 16.34 6.23 22.58 0l25.03-25.03c6.23-6.23 6.23-16.34 0-22.58L207.6 256z" class=""></path>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                            <script>
                                $(document).on('click', '.modalcoupon-close, #modal-coupon-product .modalcoupon-overlay, .fancybox-overlay', function(e){
                                    $("#modal-coupon-product").fadeOut(0);
                                    awe_hidePopup();
                                });
                                $(document).ready(function ($){
                                    var modal = $('.modalcoupon-product');
                                    var btn = $('.coupon-toggle-btn');
                                    var span = $('.modalcoupon-close');
                                    btn.click(function () {
                                        modal.show();
                                    });
                                    span.click(function () {
                                        modal.hide();
                                    });
                                    $(window).on('click', function (e) {
                                        if ($(e.target).is('.modal')) {
                                            modal.hide();
                                        }
                                    });
                                });
                                $('.dk_btn_1').click(function () {
                                    $('.contet_dk_1').slideToggle();
                                    return false;
                                });
                                $('.dk_btn_2').click(function () {
                                    $('.contet_dk_2').slideToggle();
                                    return false;
                                });
                                $('.dk_btn_3').click(function () {
                                    $('.contet_dk_3').slideToggle();
                                    return false;
                                });
                                $('.dk_btn_4').click(function () {
                                    $('.contet_dk_4').slideToggle();
                                    return false;
                                });
                                $(document).on('click', '.dis_copy',function(e){
                                    e.preventDefault();
                                    var copyText = $(this).attr('data-copy');
                                    var copyTextarea = document.createElement("textarea");
                                    copyTextarea.textContent = copyText;
                                    document.body.appendChild(copyTextarea);
                                    copyTextarea.select();
                                    document.execCommand("copy");
                                    document.body.removeChild(copyTextarea);
                                    var cur_text = $(this).text();
                                    var $cur_btn = $(this);
                                    $(this).addClass("disabled");
                                    $(this).text("Đã lưu");
                                    $(this).parent().addClass('active');
                                    setTimeout(function(){
                                        $cur_btn.removeClass("disabled");
                                        $cur_btn.parent().removeClass('active');
                                        $cur_btn.text(cur_text);
                                    },2500)
                                })
                            </script>
                        </div> --}}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('script')
    <script>
        app.controller('CartController', function($scope, cartItemSync, $interval, $rootScope) {
            $scope.items = @json($cartCollection);
            $scope.total = "{{ $total_price }}";
            $scope.total_qty = "{{ $total_qty }}";
            $scope.checkCart = true;

            $scope.countItem = Object.keys($scope.items).length;

            jQuery(document).ready(function() {
                if ($scope.total == 0) {
                    $scope.checkCart = false;
                    $scope.$applyAsync();
                }
            })

            $scope.changeQty = function(qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function(product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function(product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{ route('cart.update.item') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function(product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('cart.remove.item') }}",
                    data: {
                        product_id: product_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            if ($scope.total == 0) {
                                $scope.checkCart = false;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = Object.keys($scope.items).length;

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }
        });
    </script>
@endpush
