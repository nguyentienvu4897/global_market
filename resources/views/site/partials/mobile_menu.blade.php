<div id="main-menu"
    class="mobile-sidebar no-scrollbar mfp-hide mobile-sidebar-slide mobile-sidebar-levels-1 mobile-sidebar-levels-2"
    data-levels="2">
    <div class="sidebar-menu no-scrollbar ">
        <ul class="nav nav-sidebar nav-vertical nav-uppercase nav-slide" data-tab="1">
            <li class="header-search-form search-form html relative has-icon">
                <div class="header-search-form-wrapper">
                    <div class="searchform-wrapper ux-search-box relative is-normal">
                        <form role="search" method="get" class="searchform" action="https://winecellar.vn/">
                            <div class="flex-row relative">
                                <div class="flex-col flex-grow">
                                    <label class="screen-reader-text" for="woocommerce-product-search-field-4">Tìm
                                        kiếm:</label>
                                    <input type="search" id="woocommerce-product-search-field-4"
                                        class="search-field mb-0"
                                        placeholder="Hãy thử  &#039;vang cá chép&#039; xem sao!" value=""
                                        name="s" />
                                    <input type="hidden" name="post_type" value="product" />
                                </div>
                                <div class="flex-col">
                                    <button type="submit" value="Tìm kiếm"
                                        class="ux-search-submit submit-button secondary button  icon mb-0"
                                        aria-label="Submit">
                                        <i class="icon-search"></i> </button>
                                </div>
                            </div>
                            <div class="live-search-results text-left z-top"></div>
                        </form>
                    </div>
                </div>
            </li>
            <li
                class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-35556 current_page_item menu-item-36227">
                <a href="{{route('front.home-page')}}" aria-current="page">Trang chủ</a>
            </li>
            <li class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-11284"><a
                    href="{{route('front.about-us')}}">Giới thiệu</a></li>
            @foreach ($productCategories as $productCategory)
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-45626">
                <a href="{{route('front.show-product-category', $productCategory->slug)}}">{{ $productCategory->name }}</a>
                @if ($productCategory->childs->count() > 0)
                <ul class="sub-menu nav-sidebar-ul children">
                    @foreach ($productCategory->childs as $child)
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-48865"><a
                            href="{{route('front.show-product-category', $child->slug)}}">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
            @foreach ($postCategories as $postCategory)
            <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-48851">
                <a href="{{route('front.list-blog', $postCategory->slug)}}">{{ $postCategory->name }}</a>
                @if ($postCategory->getChilds()->count() > 0)
                <ul class="sub-menu nav-sidebar-ul children">
                    @foreach ($postCategory->getChilds() as $child)
                    <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-48852"><a
                            href="{{route('front.list-blog', $child->slug)}}">{{ $child->name }}</a></li>
                    @endforeach
                </ul>
                @endif
            </li>
            @endforeach
            <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-11288"><a
                    href="{{route('front.contact-us')}}">Liên hệ</a></li>
        </ul>
    </div>
</div>
