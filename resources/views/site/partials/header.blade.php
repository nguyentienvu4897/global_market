<div class="top-header-wrapper">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-xlcus-6 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 header-logo">
                <a href="{{route('front.seller-login')}}">Kênh người bán</a> <span style="color: #fff;">|</span> <a href="{{route('front.seller-register')}}">Trở thành người bán hàng</a>
            </div>
        </div>
    </div>
</div>
<div class="top-header" ng-cloak>
    <div class="container">
        <div class="row">
            <div class="col-xl-2 col-xlcus-2 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12 header-logo">
                <a href="{{ route('front.home-page') }}" class="logo-wrapper" title="{{$config->web_title}}"><img class="lazyload" width="340" height="104"
                        src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAAAXNSR0IArs4c6QAAAARnQU1BAACxjwv8YQUAAAAJcEhZcwAADsQAAA7EAZUrDhsAAAANSURBVBhXYzh8+PB/AAffA0nNPuCLAAAAAElFTkSuQmCC"
                        data-src="{{$config->image->path ?? ''}}" /></a>
            </div>
            <div class="col-xl-5 col-xlcus-4 col-lg-12 col-md-12 col-sm-12 col-xs-12 col-12">
                <button class="menu-icon" aria-label="Menu" id="btn-menu-mobile" title="Menu">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <line y1="4.5" x2="24" y2="4.5" stroke="#fff"></line>
                        <line y1="11.5" x2="24" y2="11.5" stroke="#fff"></line>
                        <line y1="19.5" x2="24" y2="19.5" stroke="#fff"></line>
                    </svg>
                </button>
                <div class="list-top-item header_tim_kiem">
                    <form action="{{ route('front.search') }}" method="get" class="header-search-form input-group search-bar"
                        role="search">
                        <div class="box-search">
                            <input type="text" name="keyword" required id="live-search"
                                class="input-group-field auto-search search-auto form-control"
                                placeholder="Tìm sản phẩm..." autocomplete="off">
                            <button type="submit" class="btn icon-fallback-text" aria-label="Tìm kiếm"
                                title="Tìm kiếm">
                                <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M14.1404 13.4673L19.852 19.1789C20.3008 19.6276 19.6276 20.3008 19.1789 19.852L13.4673 14.1404C12.0381 15.4114 10.1552 16.1835 8.09176 16.1835C3.6225 16.1835 0 12.5613 0 8.09176C0 3.6225 3.62219 0 8.09176 0C12.561 0 16.1835 3.62219 16.1835 8.09176C16.1835 10.1551 15.4115 12.038 14.1404 13.4673ZM0.951972 8.09176C0.951972 12.0356 4.14824 15.2316 8.09176 15.2316C12.0356 15.2316 15.2316 12.0353 15.2316 8.09176C15.2316 4.14797 12.0353 0.951972 8.09176 0.951972C4.14797 0.951972 0.951972 4.14824 0.951972 8.09176Z"
                                        fill="#222"></path>
                                </svg>
                            </button>
                        </div>
                        <div class="search-suggest live-search-results">

                        </div>
                    </form>
                </div>
                <ul class="list-search-key">
                    @foreach($tag_search as $key => $tag)
                    @if ($key == 2)
                    <li><a href="{{ route('front.search').'?tag='.$tag->name }}" title="{{ $tag->name }}">{{ $tag->name }} </a>
                    </li>
                    @else
                    <li><a href="{{ route('front.search').'?tag='.$tag->name }}" title="{{ $tag->name }}">{{ $tag->name }} </a>
                        <span>|</span>
                    </li>
                    @endif
                    @endforeach
                </ul>
            </div>
            <div class="col-xl-5 col-xlcus-6 col-lg-12 box-right">
                <div class="box-icon-right">
                    {{-- <a href="/san-pham-yeu-thich" class="header-acc" title="Sản phẩm yêu thích">
                        <div class="img_acc">
                            <img width="22" height="22"
                                src="/site/images/icon_favo.png?1729657650563"
                                alt="Sản phẩm yêu thích" />
                        </div>
                        <span>Sản phẩm <br>yêu thích</span>
                    </a> --}}
                    <a href="{{route('front.user-revenue')}}" class="header-acc" title="Hoa hồng của bạn" ng-click="changeMenuClient($event, '{{route('front.user-revenue')}}')">
                        <div class="img_acc">
                            <img width="22" height="22"
                                src="/site/images/icon_res.png?1729657650563"
                                alt="Hoa hồng của bạn" />
                        </div>
                        <span>Hoa hồng <br><span class="balance-amount">{{ formatCurrency($waiting_quyet_toan_amount) }}₫</span></span>
                    </a>
                    <a href="{{ route('front.client-account') }}" title="Tài khoản của bạn" class="header-acc" ng-click="changeMenuClient($event, '{{route('front.client-account')}}')">
                        <div class="img_acc">
                            <img width="22" height="22"
                                src="/site/images/icon_user.png?1729657650563"
                                alt="Tài khoản của bạn" />
                        </div>
                        <span>Tài khoản <br>{{ Auth::guard('client')->check() ? Auth::guard('client')->user()->name : 'của bạn' }}</span>
                    </a>
                    <div class="header-action_cart">
                        <div class="header-acc" style="margin-right: 0;">
                            <a href="{{ route('cart.index') }}" class="cart-header" title="Giỏ hàng">
                                <img width="32" height="32"
                                    src="/site/images/cart.png?1729657650563"
                                    alt="Giỏ hàng" />
                                <span class="count_item count_item_pr" ng-if="cart.count > 0"><% cart.count %></span>
                            </a>
                            <span>Giỏ hàng <br>của bạn</span>
                        </div>
                        <div class="top-cart-content">
                            <div class="CartHeaderContainer">
                                <form class="cart ajaxcart cartheader" ng-if="cart.count > 0">
                                    <div class="ajaxcart__inner ajaxcart__inner--has-fixed-footer cart_body items">
                                        <div class="ajaxcart__row" ng-repeat="item in cart.items">
                                            <div class="ajaxcart__product cart_product" data-line="1">
                                                <a ng-href="/san-pham/<% item.attributes.slug %>.html" class="ajaxcart__product-image cart_image" title="<% item.name %>">
                                                    <img width="80" height="80" ng-src="<% item.attributes.image %>" alt="<% item.name %>">
                                                </a>
                                                <div class="grid__item cart_info">
                                                    <div class="ajaxcart__product-name-wrapper cart_name">
                                                        <a ng-href="/san-pham/<% item.attributes.slug %>.html" class="ajaxcart__product-name h4" title="<% item.name %>"><% item.name %></a>
                                                        <div class="cart_attribute">
                                                            <div ng-repeat="attribute in item.attributes.attributes" style="line-height: 1;">
                                                                <span class="cart_attribute_name" style="margin-left: 8px; font-weight: 600; font-size: 14px;"><% attribute.name %> :</span>
                                                                <span class="cart_attribute_value" style="font-size: 14px;"><% attribute.value %></span>
                                                            </div>
                                                        </div>
                                                        <a title="Xóa" class="cart__btn-remove remove-item-cart ajaxifyCart--remove" href="javascript:;" data-line="1" ng-click='removeItem(item.id)'></a>
                                                    </div>
                                                    <div class="grid">
                                                    <div class="grid__item one-half cart_select cart_item_name">
                                                        <div class="ajaxcart__qty input-group-btn">
                                                            <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--minus items-count" data-id="" data-qty="1" data-line="1" aria-label="-" ng-click="decrementQuantity(item); changeQty(item.quantity, item.id)">
                                                            -
                                                            </button>
                                                            <input type="text" name="" class="ajaxcart__qty-num number-sidebar" maxlength="3" ng-model="item.quantity" value="<%item.quantity%>" min="0" data-id="" data-line="1" aria-label="quantity" pattern="[0-9]*" ng-change="changeQty(item.quantity, item.id)">
                                                            <button type="button" class="ajaxcart__qty-adjust ajaxcart__qty--plus items-count" data-id="" data-line="1" data-qty="3" aria-label="+" ng-click="incrementQuantity(item); changeQty(item.quantity, item.id)">
                                                            +
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <div class="grid__item one-half text-right cart_prices">
                                                        <span class="cart-price"><% item.price | number %>₫</span>
                                                    </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="ajaxcart__footer ajaxcart__footer--fixed cart-footer" ng-if="cart.count > 0">
                                        <div class="ajaxcart__subtotal">
                                            <div class="cart__subtotal">
                                                <div class="cart__col-6">Tổng tiền:</div>
                                                <div class="text-right cart__totle"><span class="total-price"><% cart.total | number %>₫</span></div>
                                            </div>
                                        </div>
                                        <div class="cart__btn-proceed-checkout-dt ">
                                            {{-- <button onclick="location.href='{{ route('cart.checkout') }}'" type="button" class="button btn btn-default cart__btn-proceed-checkout" id="btn-proceed-checkout" title="Thanh toán" style="margin-bottom: 10px;">Thanh toán</button> --}}
                                            <button onclick="location.href='{{ route('cart.index') }}'" type="button" class="button btn btn-default cart__btn-proceed-checkout" id="btn-proceed-checkout" title="Xem giỏ hàng">Xem giỏ hàng</button>
                                        </div>
                                    </div>
                                </form>
                                <div class="cart--empty-message" ng-if="!cart.items || cart.count == 0">
                                    <img width="32" height="32" src="/site/images/no-cart.png?1677998172667">
                                    <p>Không có sản phẩm nào trong giỏ hàng của bạn</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box-swisa">
                    <div class="img_hot">
                        <img width="14" height="18"
                            src="/site/images/icon_hot.png?1729657650563"
                            alt="Icon" />
                    </div>
                    @php
                        $text_top_header = explode("\n", $config->text_top_header);
                    @endphp
                    <div class="fullpage">
                        @foreach($text_top_header as $text)
                        <span class="quotes" style="font-size: 15px;">{{ $text }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<header class="header" ng-cloak>
    <div class="container">
        <div class="box-catelory">
            <div class="header-menu">
                <div class="menu_mega indexs">
                    <div class="title_menu">
                        <div class="menu"></div>
                        <span class="title_">Danh mục sản phẩm</span>
                    </div>
                    <div class="blog-aside bg-aside-inde">
                        <div class="aside-content">
                            <div class="ul_menu">
                                @foreach($productCategories as $category)
                                <div class="nav_item nav-item lv1 li_check">
                                    <div class="box-menu">
                                        <a href="{{ route('front.show-product-category', $category->slug) }}" title="{{ $category->name }}" class="no-img">
                                            {{-- <div class="box-icon-cate">
                                                <img width="24" height="24"
                                                    src="//bizweb.dktcdn.net/100/489/005/themes/912542/assets/icon_megamenu_2.png?1729657650563"
                                                    alt="Bánh Kẹo" />
                                            </div> --}}
                                            {{ $category->name }}
                                        </a>
                                        @if($category->childs->count() > 0)
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" class="active">
                                            <path
                                                d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                                        </svg>
                                        <div class="ul_content_right_1">
                                            @foreach($category->childs as $child)
                                            <div class="nav_item nav-item lv2">
                                                <a href="{{ route('front.show-product-category', $child->slug) }}" title="{{ $child->name }}">|-- {{ $child->name }}</a>
                                                @if($child->childs->count() > 0)
                                                <div class="ul_content_right_2">
                                                    @foreach($child->childs as $childChild)
                                                    <div class="nav_item nav-item lv3">
                                                        <a href="{{ route('front.show-product-category', $childChild->slug) }}" title="{{ $childChild->name }}">|-- |-- {{ $childChild->name }}</a>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                @endif
                                            </div>
                                            @endforeach
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-mid">
                <div class="navigation-horizontal">
                    <nav class="header-nav">
                        <ul id="nav" class="nav" ng-if="isAdminClient && showMenuAdminClient">
                            <li class="nav-item {{ Route::currentRouteName() == 'front.client-account' ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('front.client-account')}}" title="Quản lý tải khoản">Quản lý tài khoản</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'front.user-order' ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('front.user-order')}}" title="Đơn hàng">Đơn hàng</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'front.user-revenue' ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('front.user-revenue')}}" title="Hoa hồng">Hoa hồng</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'front.user-level' ? 'active' : '' }}">
                                <a class="nav-link" href="{{route('front.user-level')}}" title="Cấp bậc">Cấp bậc</a>
                            </li>
                            <li class="nav-item ">
                                <a class="nav-link" href="javascript:void(0)" title="Quay lại" ng-click="changeMenuClient($event)">Quay lại</a>
                            </li>
                        </ul>
                        <ul id="nav" class="nav" ng-if="!isAdminClient || !showMenuAdminClient">
                            <li class="nav-item {{ Route::currentRouteName() == 'front.home-page' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('front.home-page') }}" title="Trang chủ">Trang chủ</a>
                            </li>
                            <li class="nav-item {{ Route::currentRouteName() == 'front.about-us' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('front.about-us') }}" title="Giới thiệu">Giới thiệu</a>
                            </li>
                            @foreach($postCategories as $category)
                            <li class="nav-item has-childs {{ Route::currentRouteName() == 'front.list-blog' && Route::current()->parameter('slug') == $category->slug ? 'active' : '' }}">
                                <a href="{{ route('front.list-blog', $category->slug) }}" class="nav-link" title="{{ $category->name }}">
                                    {{ $category->name }}
                                    @if($category->getChilds()->count() > 0)
                                    <i class="dropcon"></i>
                                    @endif
                                </a>
                                @if($category->getChilds()->count() > 0)
                                <i class="open_mnu down_icon"></i>
                                <ul class="dropdown-menu">
                                    @foreach($category->getChilds() as $child)
                                    <li class="dropdown-submenu nav-item-lv2 has-childs2">
                                        <a class="nav-link" href="{{ route('front.list-blog', $child->slug) }}" title="{{ $child->name }}">
                                            {{ $child->name }}
                                            @if($child->getChilds()->count() > 0)
                                            <i class="dropcon"></i>
                                            @endif
                                        </a>
                                        @if($child->getChilds()->count() > 0)
                                        <i class="open_mnu down_icon"></i>
                                        <ul class="dropdown-menu">
                                            @foreach($child->getChilds() as $childChild)
                                            <li class="nav-item-lv3">
                                                <a class="nav-link" href="{{ route('front.list-blog', $childChild->slug) }}" title="{{ $childChild->name }}">{{ $childChild->name }}</a>
                                            </li>
                                            @endforeach
                                        </ul>
                                        @endif
                                    </li>
                                    @endforeach
                                </ul>
                                @endif
                            </li>
                            @endforeach
                            <li class="nav-item {{ Route::currentRouteName() == 'front.contact-us' ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('front.contact-us') }}" title="Liên hệ">Liên hệ</a>
                            </li>
                            {{-- <li class="nav-item {{ Route::currentRouteName() == 'front.connect-us' ? 'active' : '' }}">
                                <a class="nav-link" href="" title="Hướng dẫn">Hướng dẫn</a>
                            </li> --}}
                        </ul>
                    </nav>
                    <div class="control-menu">
                        <a href="#" id="prev">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path fill="#000"
                                    d="M41.4 233.4c-12.5 12.5-12.5 32.8 0 45.3l192 192c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L109.3 256 278.6 86.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0l-192 192z" />
                            </svg>
                        </a>
                        <a href="#" id="next">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                <path fill="#000"
                                    d="M342.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L274.7 256 105.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z" />
                            </svg>
                        </a>
                    </div>
                    <div class="header_hotline">
                        <img width="42" height="46"
                            src="/site/images/phone-icon.png?1729657650563"
                            alt="Hotline" />
                        <div class="txt_hotline">
                            <a href="tel:{{str_replace(' ', '', $config->hotline)}}" title="{{$config->hotline}}">
                                {{$config->hotline}}
                            </a>
                            <span>Số hotline</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
