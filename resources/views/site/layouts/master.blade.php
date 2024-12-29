<!DOCTYPE html>
<html lang="vi">

<head>
    @include('site.partials.head')
    <link rel="preload" as="script" href="/site/js/jquery.js?1729657650563" />
    <script src="/site/js/jquery.js?1729657650563" type="text/javascript"></script>
    <link rel="preload" as="script" href="/site/js/swiper.js?1729657650563" />
    <script src="/site/js/swiper.js?1729657650563" type="text/javascript"></script>
    <link rel="preload" as="script" href="/site/js/lazy.js?1729657650563" />
    <script src="/site/js/lazy.js?1729657650563" type="text/javascript"></script>
    <script>
        !function (t) { "function" == typeof define && define.amd ? define(["jquery"], t) : t("object" == typeof exports ? require("jquery") : jQuery) }(function (t) { function s(s) { var e = !1; return t('[data-notify="container"]').each(function (i, n) { var a = t(n), o = a.find('[data-notify="title"]').text().trim(), r = a.find('[data-notify="message"]').html().trim(), l = o === t("<div>" + s.settings.content.title + "</div>").html().trim(), d = r === t("<div>" + s.settings.content.message + "</div>").html().trim(), g = a.hasClass("alert-" + s.settings.type); return l && d && g && (e = !0), !e }), e } function e(e, n, a) { var o = { content: { message: "object" == typeof n ? n.message : n, title: n.title ? n.title : "", icon: n.icon ? n.icon : "", url: n.url ? n.url : "#", target: n.target ? n.target : "-" } }; a = t.extend(!0, {}, o, a), this.settings = t.extend(!0, {}, i, a), this._defaults = i, "-" === this.settings.content.target && (this.settings.content.target = this.settings.url_target), this.animations = { start: "webkitAnimationStart oanimationstart MSAnimationStart animationstart", end: "webkitAnimationEnd oanimationend MSAnimationEnd animationend" }, "number" == typeof this.settings.offset && (this.settings.offset = { x: this.settings.offset, y: this.settings.offset }), (this.settings.allow_duplicates || !this.settings.allow_duplicates && !s(this)) && this.init() } var i = { element: "body", position: null, type: "info", allow_dismiss: !0, allow_duplicates: !0, newest_on_top: !1, showProgressbar: !1, placement: { from: "top", align: "right" }, offset: 20, spacing: 10, z_index: 1031, delay: 5e3, timer: 1e3, url_target: "_blank", mouse_over: null, animate: { enter: "animated fadeInDown", exit: "animated fadeOutUp" }, onShow: null, onShown: null, onClose: null, onClosed: null, icon_type: "class", template: '<div data-notify="container" class="col-xs-11 col-sm-4 alert alert-{0}" role="alert"><button type="button" aria-hidden="true" class="close" data-notify="dismiss">&times;</button><span data-notify="icon"></span> <span data-notify="title">{1}</span> <span data-notify="message">{2}</span><div class="progress" data-notify="progressbar"><div class="progress-bar progress-bar-{0}" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%;"></div></div><a href="{3}" target="{4}" data-notify="url"></a></div>' }; String.format = function () { for (var t = arguments[0], s = 1; s < arguments.length; s++)t = t.replace(RegExp("\\{" + (s - 1) + "\\}", "gm"), arguments[s]); return t }, t.extend(e.prototype, { init: function () { var t = this; this.buildNotify(), this.settings.content.icon && this.setIcon(), "#" != this.settings.content.url && this.styleURL(), this.styleDismiss(), this.placement(), this.bind(), this.notify = { $ele: this.$ele, update: function (s, e) { var i = {}; "string" == typeof s ? i[s] = e : i = s; for (var n in i) switch (n) { case "type": this.$ele.removeClass("alert-" + t.settings.type), this.$ele.find('[data-notify="progressbar"] > .progress-bar').removeClass("progress-bar-" + t.settings.type), t.settings.type = i[n], this.$ele.addClass("alert-" + i[n]).find('[data-notify="progressbar"] > .progress-bar').addClass("progress-bar-" + i[n]); break; case "icon": var a = this.$ele.find('[data-notify="icon"]'); "class" === t.settings.icon_type.toLowerCase() ? a.removeClass(t.settings.content.icon).addClass(i[n]) : (a.is("img") || a.find("img"), a.attr("src", i[n])); break; case "progress": var o = t.settings.delay - t.settings.delay * (i[n] / 100); this.$ele.data("notify-delay", o), this.$ele.find('[data-notify="progressbar"] > div').attr("aria-valuenow", i[n]).css("width", i[n] + "%"); break; case "url": this.$ele.find('[data-notify="url"]').attr("href", i[n]); break; case "target": this.$ele.find('[data-notify="url"]').attr("target", i[n]); break; default: this.$ele.find('[data-notify="' + n + '"]').html(i[n]) }var r = this.$ele.outerHeight() + parseInt(t.settings.spacing) + parseInt(t.settings.offset.y); t.reposition(r) }, close: function () { t.close() } } }, buildNotify: function () { var s = this.settings.content; this.$ele = t(String.format(this.settings.template, this.settings.type, s.title, s.message, s.url, s.target)), this.$ele.attr("data-notify-position", this.settings.placement.from + "-" + this.settings.placement.align), this.settings.allow_dismiss || this.$ele.find('[data-notify="dismiss"]').css("display", "none"), (this.settings.delay > 0 || this.settings.showProgressbar) && this.settings.showProgressbar || this.$ele.find('[data-notify="progressbar"]').remove() }, setIcon: function () { "class" === this.settings.icon_type.toLowerCase() ? this.$ele.find('[data-notify="icon"]').addClass(this.settings.content.icon) : this.$ele.find('[data-notify="icon"]').is("img") ? this.$ele.find('[data-notify="icon"]').attr("src", this.settings.content.icon) : this.$ele.find('[data-notify="icon"]').append('<img src="' + this.settings.content.icon + '" alt="Notify Icon" />') }, styleDismiss: function () { this.$ele.find('[data-notify="dismiss"]').css({ position: "absolute", right: "10px", top: "5px", zIndex: this.settings.z_index + 2 }) }, styleURL: function () { this.$ele.find('[data-notify="url"]').css({ backgroundImage: "url(data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7)", height: "100%", left: 0, position: "absolute", top: 0, width: "100%", zIndex: this.settings.z_index + 1 }) }, placement: function () { var s = this, e = this.settings.offset.y, i = { display: "inline-block", margin: "0px auto", position: this.settings.position ? this.settings.position : "body" === this.settings.element ? "fixed" : "absolute", transition: "all .5s ease-in-out", zIndex: this.settings.z_index }, n = !1, a = this.settings; switch (t('[data-notify-position="' + this.settings.placement.from + "-" + this.settings.placement.align + '"]:not([data-closing="true"])').each(function () { e = Math.max(e, parseInt(t(this).css(a.placement.from)) + parseInt(t(this).outerHeight()) + parseInt(a.spacing)) }), this.settings.newest_on_top === !0 && (e = this.settings.offset.y), i[this.settings.placement.from] = e + "px", this.settings.placement.align) { case "left": case "right": i[this.settings.placement.align] = this.settings.offset.x + "px"; break; case "center": i.left = 0, i.right = 0 }this.$ele.css(i).addClass(this.settings.animate.enter), t.each(["webkit-", "moz-", "o-", "ms-", ""], function (t, e) { s.$ele[0].style[e + "AnimationIterationCount"] = 1 }), t(this.settings.element).append(this.$ele), this.settings.newest_on_top === !0 && (e = parseInt(e) + parseInt(this.settings.spacing) + this.$ele.outerHeight(), this.reposition(e)), t.isFunction(s.settings.onShow) && s.settings.onShow.call(this.$ele), this.$ele.one(this.animations.start, function () { n = !0 }).one(this.animations.end, function () { t.isFunction(s.settings.onShown) && s.settings.onShown.call(this) }), setTimeout(function () { n || t.isFunction(s.settings.onShown) && s.settings.onShown.call(this) }, 600) }, bind: function () { var s = this; if (this.$ele.find('[data-notify="dismiss"]').on("click", function () { s.close() }), this.$ele.mouseover(function () { t(this).data("data-hover", "true") }).mouseout(function () { t(this).data("data-hover", "false") }), this.$ele.data("data-hover", "false"), this.settings.delay > 0) { s.$ele.data("notify-delay", s.settings.delay); var e = setInterval(function () { var t = parseInt(s.$ele.data("notify-delay")) - s.settings.timer; if ("false" === s.$ele.data("data-hover") && "pause" === s.settings.mouse_over || "pause" != s.settings.mouse_over) { var i = (s.settings.delay - t) / s.settings.delay * 100; s.$ele.data("notify-delay", t), s.$ele.find('[data-notify="progressbar"] > div').attr("aria-valuenow", i).css("width", i + "%") } t > -s.settings.timer || (clearInterval(e), s.close()) }, s.settings.timer) } }, close: function () { var s = this, e = parseInt(this.$ele.css(this.settings.placement.from)), i = !1; this.$ele.data("closing", "true").addClass(this.settings.animate.exit), s.reposition(e), t.isFunction(s.settings.onClose) && s.settings.onClose.call(this.$ele), this.$ele.one(this.animations.start, function () { i = !0 }).one(this.animations.end, function () { t(this).remove(), t.isFunction(s.settings.onClosed) && s.settings.onClosed.call(this) }), setTimeout(function () { i || (s.$ele.remove(), s.settings.onClosed && s.settings.onClosed(s.$ele)) }, 600) }, reposition: function (s) { var e = this, i = '[data-notify-position="' + this.settings.placement.from + "-" + this.settings.placement.align + '"]:not([data-closing="true"])', n = this.$ele.nextAll(i); this.settings.newest_on_top === !0 && (n = this.$ele.prevAll(i)), n.each(function () { t(this).css(e.settings.placement.from, s), s = parseInt(s) + parseInt(e.settings.spacing) + t(this).outerHeight() }) } }), t.notify = function (t, s) { var i = new e(this, t, s); return i.notify }, t.notifyDefaults = function (s) { return i = t.extend(!0, {}, i, s) }, t.notifyClose = function (s) { void 0 === s || "all" === s ? t("[data-notify]").find('[data-notify="dismiss"]').trigger("click") : t('[data-notify-position="' + s + '"]').find('[data-notify="dismiss"]').trigger("click") } });
    </script>
    <link rel="preload" as='style' type="text/css" href="/site/css/main.scss.css?1729657650563">
    <link rel="preload" as='style' type="text/css" href="/site/css/index.scss.css?1729657650563">
    <link rel="preload" as='style' type="text/css" href="/site/css/bootstrap-4-3-min.css?1729657650563">
    <link rel="preload" as='style' type="text/css" href="/site/css/quickviews_popup_cart.scss.css?1729657650563">
    <link rel="stylesheet" href="/site/css/bootstrap-4-3-min.css?1729657650563">
    <link href="/site/css/main.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/index.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
    <link href="/site/css/quickviews_popup_cart.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <link href='/site/css/onireviews.css?v=1811' rel='stylesheet' type='text/css'  media='all'  />

    <script>
        (function () {
            function asyncLoad() {
                var urls = [];
                for (var i = 0; i < urls.length; i++) {
                    var s = document.createElement('script');
                    s.type = 'text/javascript';
                    s.async = true;
                    s.src = urls[i];
                    var x = document.getElementsByTagName('script')[0];
                    x.parentNode.insertBefore(s, x);
                }
            };
            window.attachEvent ? window.attachEvent('onload', asyncLoad) : window.addEventListener('load', asyncLoad, false);
        })();
    </script>
    <script>
        $(document).ready(function ($) {
            awe_lazyloadImage();
        });
        function awe_lazyloadImage() {
            var ll = new LazyLoad({
                elements_selector: ".lazyload",
                load_delay: 100,
                threshold: 0
            });
        } window.awe_lazyloadImage = awe_lazyloadImage;
    </script>

    @yield('css')
    <style>
        .invalid-feedback.error {
            color: #dc3232;
            font-size: 14px;
        }
        @media (min-width: 768px) {
            /* body {
                zoom: 0.9;
            } */
        }
    </style>

    <!-- Angular Js -->
    <script src="{{ asset('libs/angularjs/angular.js?v=222222') }}"></script>
    <script src="{{ asset('libs/angularjs/angular-resource.js') }}"></script>
    <script src="{{ asset('libs/angularjs/sortable.js') }}"></script>
    <script src="{{ asset('libs/dnd/dnd.min.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.9/angular-sanitize.js"></script>
    <script src="{{ asset('libs/angularjs/select.js') }}"></script>
    <script src="{{ asset('js/angular.js') }}?version={{ env('APP_VERSION', '1') }}"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/css/toastr.css" rel="stylesheet"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.1/js/toastr.js"></script>
    @stack('script')
    <script>
        app.controller('AppController', function($rootScope, $scope, cartItemSync, $interval, $compile){
            $scope.currentUser = @json(Auth::guard('client')->user());
            $scope.isAdminClient = @json(Auth::guard('client')->check());
            $scope.showMenuAdminClient = localStorage.getItem('showMenuAdminClient') ? localStorage.getItem('showMenuAdminClient') : false;

            const currentUrl = window.location.href;
            if (currentUrl != "{{route('front.client-account')}}" && currentUrl != "{{route('front.user-order')}}" && currentUrl != "{{route('front.user-revenue')}}" && currentUrl != "{{route('front.user-level')}}") {
                $scope.showMenuAdminClient = false;
                localStorage.removeItem('showMenuAdminClient');
            }

            $scope.changeMenuClient = function($event){
                $event.preventDefault();
                $scope.showMenuAdminClient = !$scope.showMenuAdminClient;
                if($scope.showMenuAdminClient){
                    localStorage.setItem('showMenuAdminClient', $scope.showMenuAdminClient);
                    window.location.href = '{{ route('front.client-account') }}';
                }else{
                    localStorage.removeItem('showMenuAdminClient');
                    window.location.href = '{{ route('front.home-page') }}';
                }
            }

            // Biên dịch lại nội dung bên trong container
            var container = angular.element(document.getElementsByClassName('item_product_main'));
            $compile(container.contents())($scope);

            var popup = angular.element(document.getElementById('popup-cart-mobile'));
            $compile(popup.contents())($scope);

            var quickView = angular.element(document.getElementById('quick-view-product'));
            $compile(quickView.contents())($scope);

            // Đặt mua hàng
            $scope.hasItemInCart = false;
            $scope.cart = cartItemSync;
            $scope.item_qty = 1;
            $scope.quantity_quickview = 1;
            $scope.noti_product = {};

            $scope.addToCart = function (productId, quantity = 1) {
                url = "{{route('cart.add.item', ['productId' => 'productId'])}}";
                url = url.replace('productId', productId);
                let item_qty = quantity;

                if($scope.isAdminClient) {
                    jQuery.ajax({
                        type: 'POST',
                        url: url,
                        headers: {
                            'X-CSRF-TOKEN': "{{csrf_token()}}"
                        },
                        data: {
                            'qty': parseInt(item_qty)
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
                                // toastr.success('Thao tác thành công !')
                                $scope.noti_product = response.noti_product;
                                $scope.$applyAsync();
                                console.log($scope.noti_product);

                                $('#popup-cart-mobile').addClass('active');
                                $('.backdrop__body-backdrop___1rvky').addClass('active');
                                $('#quick-view-product.quickview-product').hide();
                            }
                        },
                        error: function () {
                            toastr.error('Thao tác thất bại !')
                        },
                        complete: function () {
                            $scope.$applyAsync();
                        }
                    });
                } else {
                    window.location.href = "{{route('front.login-client')}}";
                }
            }

            $scope.changeQty = function (qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function (product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function (product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('cart.update.item')}}",
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            // xóa item trong giỏ
            $scope.removeItem = function (product_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{route('cart.remove.item')}}",
                    data: {
                        product_id: product_id
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.cart.items = response.items;
                            $scope.cart.count = Object.keys($scope.cart.items).length;
                            $scope.cart.totalCost = response.total;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            if ($scope.cart.count == 0) {
                                $scope.hasItemInCart = false;
                            }
                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        jQuery.toast.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            // Xem nhanh
            $scope.quickViewProduct = {};
            $scope.showQuickView = function (productId) {
                $.ajax({
                    url: "{{route('front.get-product-quick-view')}}",
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        product_id: productId
                    },
                    success: function (response) {
                        $('#quick-view-product .quick-view-product').html(response.html);
                        var quickView = angular.element(document.getElementById('quick-view-product'));
                        $compile(quickView.contents())($scope);
                        $scope.$applyAsync();
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }

            // Search product
            jQuery('#live-search').keyup(function() {
                var keyword = jQuery(this).val();
                jQuery.ajax({
                    type: 'post',
                    url: '{{route("front.auto-search-complete")}}',
                    headers: {'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')},
                    data: {keyword: keyword},
                    success: function(data) {
                        jQuery('.live-search-results').html(data.html);
                    }
                })
            });
        })

        app.factory('cartItemSync', function ($interval) {
            var cart = {items: null, total: null};

            cart.items = @json($cartItems);
            cart.count = {{$cartItems->sum('quantity')}};
            cart.total = {{$totalPriceCart}};

            return cart;
        });

        @if(Session::has('token'))
        localStorage.setItem('{{ env("prefix") }}-token', "{{Session::get('token')}}")
        @endif
        @if(Session::has('logout'))
        localStorage.removeItem('{{ env("prefix") }}-token');
        @endif
        var CSRF_TOKEN = "{{ csrf_token() }}";
        @if (Auth::guard('client')->check())
        const DEFAULT_CLIENT_USER = {
            id: "{{ Auth::guard('client')->user()->id }}",
            fullname: "{{ Auth::guard('client')->user()->name }}"
        };
        console.log(DEFAULT_CLIENT_USER);
        @endIf
    </script>
</head>

<body ng-app="App" ng-controller="AppController">
    <div class="opacity_menu"></div>
    @include('site.partials.header')
    <div class="bodywrap active">
        @yield('content')
        @include('site.partials.footer')
    </div>
    <div class="backdrop__body-backdrop___1rvky"></div>
    {{-- <div id="list-favorite" class="d-none">
        <div class="list-favorite-right container" data-type="wishlist">
            <div class="list-favorite-main">
                <div class="list-favorite-list row">
                </div>
            </div>
        </div>
    </div> --}}
    <link rel="preload" as="style" href="/site/css/ajaxcart.scss.css?1729657650563" type="text/css">
    <link href="/site/css/ajaxcart.scss.css?1729657650563" rel="stylesheet" type="text/css" media="all" />
    <script type="text/javascript">
        window.theme = window.theme || {};
        var wW = $(window).width();
        var timeout;

        $('.img_hover_cart').click(function () {
            $('.cart-sidebar, .backdrop__body-backdrop___1rvky').addClass('active');
        });

        $(document).on('click', '.backdrop__body-backdrop___1rvky, .cart_btn-close', function () {
            $('.backdrop__body-backdrop___1rvky, .cart-sidebar, #popup-cart-desktop, .popup-cart-mobile').removeClass('active');
            return false;
        })
    </script>
    <div id="popup-cart-mobile" class="popup-cart-mobile">
        <div class="header-popcart">
            <div class="top-cart-header">
                <span>
                    <svg xmlns="http://www.w3.org/2000/svg" height="682.66669pt" viewBox="-21 -21 682.66669 682.66669"
                        width="682.66669pt">
                        <path
                            d="m322.820312 387.933594 279.949219-307.273438 36.957031 33.671875-314.339843 345.023438-171.363281-162.902344 34.453124-36.238281zm297.492188-178.867188-38.988281 42.929688c5.660156 21.734375 8.675781 44.523437 8.675781 68.003906 0 148.875-121.125 270-270 270s-270-121.125-270-270 121.125-270 270-270c68.96875 0 131.96875 26.007812 179.746094 68.710938l33.707031-37.113282c-58.761719-52.738281-133.886719-81.597656-213.453125-81.597656-85.472656 0-165.835938 33.285156-226.273438 93.726562-60.441406 60.4375-93.726562 140.800782-93.726562 226.273438s33.285156 165.835938 93.726562 226.273438c60.4375 60.441406 140.800782 93.726562 226.273438 93.726562s165.835938-33.285156 226.273438-93.726562c60.441406-60.4375 93.726562-140.800782 93.726562-226.273438 0-38.46875-6.761719-75.890625-19.6875-110.933594zm0 0" />
                    </svg>
                    Thêm vào giỏ hàng thành công
                </span>
            </div>
            <div class="media-content bodycart-mobile">
                <div class="thumb-1x1">
                    <img src="<% noti_product.product_image %>" alt="<% noti_product.product_name %>">
                </div>
                <div class="body_content">
                    <h4 class="product-title"><% noti_product.product_name %></h4>
                    <div class="product-new-price"><b><% noti_product.product_price | number %>₫</b><span></span></div>
                </div>
            </div>
            <a class="noti-cart-count" href="{{ route('cart.index') }}" title="Giỏ hàng"> Giỏ hàng của bạn hiện có <span
                    class="count_item_pr"><% cart.count %></span> sản phẩm </a>
            <a title="Đóng" class="cart_btn-close iconclose">
                <img width="50" height="50"
                    src="/site/images/icon-filter-close-bg.png?1729657650563"
                    alt="Đóng" />
            </a>
            <div class="bottom-action">
                <div class="cart_btn-close tocontinued" onclick="location.href='{{ route('cart.index') }}'">
                    Xem giỏ hàng
                </div>
                <a href="/checkout" class="checkout" title="Thanh toán ngay" onclick="location.href='{{ route('cart.checkout') }}'">
                    Thanh toán ngay
                </a>
            </div>
        </div>
    </div>
    <div id="quick-view-product" class="quickview-product" style="display:none;">
        <div class="quickview-overlay fancybox-overlay fancybox-overlay-fixed"></div>
        <div class="quick-view-product">

        </div>
    </div>
    <script type="text/javascript">
        function changeImageQuickView(img, selector) {
            var src = $(img).attr("src");
            src = src.replace("_compact", "");
            $(selector).attr("src", src);
        }
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

    </script>
    <link rel="preload" as="script" href="/site/js/quickview.js?1729657650563" />
    <script type="text/javascript" defer src="/site/js/quickview.js?1729657650563"></script>
    <link rel="preload" as="script" href="/site/js/main.js?1729657650563" />
    <script type="text/javascript" defer src="/site/js/main.js?1729657650563"></script>
    <link rel="preload" as="script" href="/site/js/index.js?1729657650563" />
    <script type="text/javascript" defer src="/site/js/index.js?1729657650563"></script>
    <div id="popupCartModal" class="modal fade" role="dialog">
    </div>
    {{-- <div class="popup-sapo">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 448 512">
                <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path
                    d="M224 0c-17.7 0-32 14.3-32 32V51.2C119 66 64 130.6 64 208v18.8c0 47-17.3 92.4-48.5 127.6l-7.4 8.3c-8.4 9.4-10.4 22.9-5.3 34.4S19.4 416 32 416H416c12.6 0 24-7.4 29.2-18.9s3.1-25-5.3-34.4l-7.4-8.3C401.3 319.2 384 273.9 384 226.8V208c0-77.4-55-142-128-156.8V32c0-17.7-14.3-32-32-32zm45.3 493.3c12-12 18.7-28.3 18.7-45.3H224 160c0 17 6.7 33.3 18.7 45.3s28.3 18.7 45.3 18.7s33.3-6.7 45.3-18.7z" />
            </svg>
        </div>
        <div class="content">
            <div class="title">
                Tích hợp sẵn các ứng dụng
            </div>
            <ul>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                    <a href="https://apps.sapo.vn/danh-gia-san-pham-v2" target="_blank" title="Đánh giá sản phẩm">Đánh
                        giá sản phẩm</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                    <a href="https://apps.sapo.vn/mua-x-tang-y-v2" target="_blank" title="Mua X tặng Y">Mua X tặng Y</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                    <a href="https://apps.sapo.vn/quan-ly-affiliate-v2" target="_blank" title="Ứng dụng Affiliate">Ứng
                        dụng Affiliate</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                    <a href="https://apps.sapo.vn/ae-da-ngon-ngu" target="_blank" title="Đa ngôn ngữ">Đa ngôn ngữ</a>
                </li>
                <li>
                    <svg xmlns="http://www.w3.org/2000/svg" height="1em" viewBox="0 0 512 512">
                        <!--! Font Awesome Free 6.4.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                        <path
                            d="M470.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L402.7 256 265.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0l160-160zm-352 160l160-160c12.5-12.5 12.5-32.8 0-45.3l-160-160c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L210.7 256 73.4 393.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0z" />
                    </svg>
                    <a href="#" target="_blank" title="Livechat Facebook">Livechat Facebook</a>
                </li>
            </ul>
            <div class="ghichu">
                Lưu ý với các ứng dụng trả phí bạn cần cài đặt và mua ứng dụng này trên App store Sapo để sử dụng ngay
            </div>
            <a title="Đóng" class="close-popup-sapo">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" x="0px"
                    y="0px" viewBox="0 0 512.001 512.001" style="enable-background:new 0 0 512.001 512.001;"
                    xml:space="preserve">
                    <g>
                        <g>
                            <path
                                d="M284.286,256.002L506.143,34.144c7.811-7.811,7.811-20.475,0-28.285c-7.811-7.81-20.475-7.811-28.285,0L256,227.717    L34.143,5.859c-7.811-7.811-20.475-7.811-28.285,0c-7.81,7.811-7.811,20.475,0,28.285l221.857,221.857L5.858,477.859    c-7.811,7.811-7.811,20.475,0,28.285c3.905,3.905,9.024,5.857,14.143,5.857c5.119,0,10.237-1.952,14.143-5.857L256,284.287    l221.857,221.857c3.905,3.905,9.024,5.857,14.143,5.857s10.237-1.952,14.143-5.857c7.811-7.811,7.811-20.475,0-28.285    L284.286,256.002z">
                            </path>
                        </g>
                    </g>
                </svg>
            </a>
        </div>
    </div>
    <script>
        $('.popup-sapo .icon').click(function () {
            $(".popup-sapo").toggleClass("active");
        });
        $('.close-popup-sapo').click(function () {
            $(".popup-sapo").toggleClass("active");
        });
    </script> --}}
    {{-- <div class="popup-ngonngu">
        <div class="icon">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-globe2"
                viewBox="0 0 16 16">
                <path
                    d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm7.5-6.923c-.67.204-1.335.82-1.887 1.855-.143.268-.276.56-.395.872.705.157 1.472.257 2.282.287V1.077zM4.249 3.539c.142-.384.304-.744.481-1.078a6.7 6.7 0 0 1 .597-.933A7.01 7.01 0 0 0 3.051 3.05c.362.184.763.349 1.198.49zM3.509 7.5c.036-1.07.188-2.087.436-3.008a9.124 9.124 0 0 1-1.565-.667A6.964 6.964 0 0 0 1.018 7.5h2.49zm1.4-2.741a12.344 12.344 0 0 0-.4 2.741H7.5V5.091c-.91-.03-1.783-.145-2.591-.332zM8.5 5.09V7.5h2.99a12.342 12.342 0 0 0-.399-2.741c-.808.187-1.681.301-2.591.332zM4.51 8.5c.035.987.176 1.914.399 2.741A13.612 13.612 0 0 1 7.5 10.91V8.5H4.51zm3.99 0v2.409c.91.03 1.783.145 2.591.332.223-.827.364-1.754.4-2.741H8.5zm-3.282 3.696c.12.312.252.604.395.872.552 1.035 1.218 1.65 1.887 1.855V11.91c-.81.03-1.577.13-2.282.287zm.11 2.276a6.696 6.696 0 0 1-.598-.933 8.853 8.853 0 0 1-.481-1.079 8.38 8.38 0 0 0-1.198.49 7.01 7.01 0 0 0 2.276 1.522zm-1.383-2.964A13.36 13.36 0 0 1 3.508 8.5h-2.49a6.963 6.963 0 0 0 1.362 3.675c.47-.258.995-.482 1.565-.667zm6.728 2.964a7.009 7.009 0 0 0 2.275-1.521 8.376 8.376 0 0 0-1.197-.49 8.853 8.853 0 0 1-.481 1.078 6.688 6.688 0 0 1-.597.933zM8.5 11.909v3.014c.67-.204 1.335-.82 1.887-1.855.143-.268.276-.56.395-.872A12.63 12.63 0 0 0 8.5 11.91zm3.555-.401c.57.185 1.095.409 1.565.667A6.963 6.963 0 0 0 14.982 8.5h-2.49a13.36 13.36 0 0 1-.437 3.008zM14.982 7.5a6.963 6.963 0 0 0-1.362-3.675c-.47.258-.995.482-1.565.667.248.92.4 1.938.437 3.008h2.49zM11.27 2.461c.177.334.339.694.482 1.078a8.368 8.368 0 0 0 1.196-.49 7.01 7.01 0 0 0-2.275-1.52c.218.283.418.597.597.932zm-.488 1.343a7.765 7.765 0 0 0-.395-.872C9.835 1.897 9.17 1.282 8.5 1.077V4.09c.81-.03 1.577-.13 2.282-.287z" />
            </svg>
        </div>
        <ul class="language">
            <li>
                <a href="#"><img src="//bizweb.dktcdn.net/100/496/044/themes/927290/assets/vn.png?1699256128806"
                        alt="Tiếng Việt">
                    <span>Tiếng Việt</span>
                </a>
            </li>
            <li>
                <a href="#"><img src="//bizweb.dktcdn.net/100/496/044/themes/927290/assets/en.png?1699256128806"
                        alt="Tiếng Anh">
                    <span>English</span>
                </a>
            </li>
        </ul>
    </div> --}}
    {{-- <a target="_blank" class="livechat-mes" href="https://m.me/sapo.vn">
        <img src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/messenger.svg?1729657650563" alt="Messenger">
    </a> --}}
</body>

</html>
